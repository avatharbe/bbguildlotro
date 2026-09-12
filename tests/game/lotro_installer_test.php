<?php
/**
 * @package bbGuild LOTRO Extension
 * @copyright (c) 2026 avathar.be
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace avathar\bbguildlotro\tests\game;

use PHPUnit\Framework\TestCase;
use avathar\bbguildlotro\game\lotro_installer;

class lotro_installer_test extends TestCase
{
	/** @var lotro_installer */
	protected $installer;

	/** @var array Captured sql_multi_insert calls: array of [table, data] */
	protected $inserted = array();

	/** @var \PHPUnit\Framework\MockObject\MockObject */
	protected $db;

	protected function setUp(): void
	{
		parent::setUp();

		$this->inserted = array();

		$this->db = $this->createMock(\phpbb\db\driver\driver_interface::class);

		// Capture sql_multi_insert calls
		$this->db->method('sql_multi_insert')
			->willReturnCallback(function ($table, $data) {
				$this->inserted[] = array('table' => $table, 'data' => $data);
			});

		// sql_query (DELETE statements) — no-op
		$this->db->method('sql_query')->willReturn(true);
		$this->db->method('sql_escape')->willReturnCallback(function ($v) { return $v; });

		$cache = $this->createMock(\phpbb\cache\driver\driver_interface::class);
		$config = new \phpbb\config\config(array());
		$user = $this->getMockBuilder(\phpbb\user::class)
			->disableOriginalConstructor()
			->getMock();

		$this->installer = new lotro_installer($this->db, $cache, $config, $user);

		// Set table_names and game_id via reflection (normally set by install())
		$ref = new \ReflectionClass($this->installer);

		$tn = $ref->getProperty('table_names');
		$tn->setAccessible(true);
		$tn->setValue($this->installer, array(
			'bb_factions_table' => 'phpbb_bb_factions',
			'bb_classes_table'  => 'phpbb_bb_classes',
			'bb_races_table'    => 'phpbb_bb_races',
			'bb_language_table' => 'phpbb_bb_language',
		));

		$gid = $ref->getProperty('game_id');
		$gid->setAccessible(true);
		$gid->setValue($this->installer, 'lotro');
	}

	/**
	 * Invoke a protected method on the installer.
	 */
	private function invoke_protected(string $method_name): void
	{
		$this->inserted = array();
		$method = new \ReflectionMethod(lotro_installer::class, $method_name);
		$method->setAccessible(true);
		$method->invoke($this->installer);
	}

	// ── Factions ───────────────────────────────────────────

	public function test_install_factions_count(): void
	{
		$this->invoke_protected('install_factions');
		$this->assertCount(1, $this->inserted);
		$this->assertCount(2, $this->inserted[0]['data']);
	}

	public function test_install_factions_ids(): void
	{
		$this->invoke_protected('install_factions');
		$factions = $this->inserted[0]['data'];
		$ids = array_column($factions, 'faction_id');
		$this->assertContains(1, $ids, 'Free Peoples faction_id=1');
		$this->assertContains(2, $ids, 'Servants of the Eye faction_id=2');
	}

	public function test_install_factions_names(): void
	{
		$this->invoke_protected('install_factions');
		$factions = $this->inserted[0]['data'];
		$names = array_column($factions, 'faction_name');
		$this->assertContains('Free Peoples', $names);
		$this->assertContains('Servants of the Eye', $names);
	}

	public function test_install_factions_game_id(): void
	{
		$this->invoke_protected('install_factions');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertSame('lotro', $row['game_id']);
		}
	}

	// ── Classes ────────────────────────────────────────────

	public function test_install_classes_count(): void
	{
		$this->invoke_protected('install_classes');
		// First insert: class rows, second insert: language rows
		$this->assertCount(2, $this->inserted);
		// 11 Free Peoples classes (incl. class_id 0 "Unknown") + 6 Monster Play classes
		$this->assertCount(17, $this->inserted[0]['data']);
	}

	public function test_install_classes_valid_armor_types(): void
	{
		$this->invoke_protected('install_classes');
		$valid = array('CLOTH', 'MAIL', 'PLATE');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertContains($row['class_armor_type'], $valid, "class_id {$row['class_id']} has valid armor type");
		}
	}

	public function test_install_classes_game_id(): void
	{
		$this->invoke_protected('install_classes');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertSame('lotro', $row['game_id']);
		}
	}

	public function test_install_classes_language_coverage(): void
	{
		$this->invoke_protected('install_classes');
		$lang_rows = $this->inserted[1]['data'];
		$languages = array_unique(array_column($lang_rows, 'language'));
		sort($languages);
		$this->assertSame(array('de', 'en', 'fr', 'it'), $languages);
	}

	public function test_install_classes_language_entries_per_lang(): void
	{
		$this->invoke_protected('install_classes');
		$lang_rows = $this->inserted[1]['data'];
		$per_lang = array_count_values(array_column($lang_rows, 'language'));
		// 17 classes x 4 languages = 68 total — full parity, unlike races below.
		foreach ($per_lang as $lang => $count)
		{
			$this->assertSame(17, $count, "$lang has 17 class name entries");
		}
	}

	// ── Races ──────────────────────────────────────────────

	public function test_install_races_count(): void
	{
		$this->invoke_protected('install_races');
		// First insert: race rows, second insert: language rows
		$this->assertCount(2, $this->inserted);
		$this->assertCount(25, $this->inserted[0]['data']);
	}

	public function test_install_races_valid_factions(): void
	{
		$this->invoke_protected('install_races');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertContains($row['race_faction_id'], array(1, 2), "race_id {$row['race_id']} has valid faction");
		}
	}

	public function test_install_races_game_id(): void
	{
		$this->invoke_protected('install_races');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertSame('lotro', $row['game_id']);
		}
	}

	public function test_install_races_language_coverage(): void
	{
		$this->invoke_protected('install_races');
		$lang_rows = $this->inserted[1]['data'];
		$languages = array_unique(array_column($lang_rows, 'language'));
		sort($languages);
		$this->assertSame(array('de', 'en', 'fr', 'it'), $languages);
	}

	/**
	 * KNOWN CONTENT GAP (found by this test, not fixed here — see issue
	 * tracker follow-up): unlike install_classes(), race translations are
	 * NOT at full parity across languages or against bb_races_table's 25
	 * seeded race_ids. Locking down the actual current counts so this
	 * suite documents the gap instead of silently asserting something
	 * that isn't true:
	 *   - en/it: 24 rows each (missing race_id 35 "Rivendell Elf" — no
	 *     language row in ANY of the 4 languages, see
	 *     test_install_races_race_id_35_has_no_translation_anywhere below)
	 *   - de: 23 rows (missing race_id 0 "Unknown" in addition to 35)
	 *   - fr: 20 rows (missing race_id 0, 11, 12, 13 — the three "Man of
	 *     ..." sub-races — in addition to 35)
	 */
	public function test_install_races_language_entries_per_lang(): void
	{
		$this->invoke_protected('install_races');
		$lang_rows = $this->inserted[1]['data'];
		$per_lang = array_count_values(array_column($lang_rows, 'language'));
		$this->assertSame(array(
			'en' => 24,
			'de' => 23,
			'fr' => 20,
			'it' => 24,
		), $per_lang);
	}

	/**
	 * Regression lock for the known gap above: race_id 35 (image
	 * 'lotro_elf_rivendell', faction_id 1) is seeded in bb_races_table but
	 * has zero rows in bb_language_table under attribute='race', in any of
	 * the 4 languages. This means the roster/ACP UI has no display name
	 * for this race today. Flagged here rather than fixed, per the scope
	 * of this test-suite ticket.
	 */
	public function test_install_races_race_id_35_has_no_translation_anywhere(): void
	{
		$this->invoke_protected('install_races');

		$race_ids = array_column($this->inserted[0]['data'], 'race_id');
		$this->assertContains(35, $race_ids, 'race_id 35 (Rivendell Elf) should still be seeded in bb_races_table');

		$lang_rows = $this->inserted[1]['data'];
		$attribute_ids_with_lang = array_unique(array_column($lang_rows, 'attribute_id'));
		$this->assertNotContains(35, $attribute_ids_with_lang, 'documents the known gap — remove this assertion once race_id 35 gets a translation row');
	}

	// ── has_api_support() ──────────────────────────────────

	public function test_has_api_support_is_false(): void
	{
		// lotro_installer does not override has_api_support(); the abstract
		// base's default (false) applies, matching lotro_provider::has_api().
		$method = new \ReflectionMethod(lotro_installer::class, 'has_api_support');
		$method->setAccessible(true);
		$this->assertFalse($method->invoke($this->installer));
	}
}
