<?php
/**
 * bbGuild LOTRO Extension — seed data structural correctness
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Per tests/integration-tests.md's "Notes for other plugins": this plugin
 * has no external API, so the only integration-level value beyond the
 * unit/functional tests is fixture-loading correctness — load the real
 * seed data into a real DB (via a real extension install) and assert
 * structural correctness the unit test (which only inspects captured
 * sql_multi_insert() calls in isolation) can't: cross-table references,
 * duplicate keys, and full language coverage.
 *
 * Extends \phpbb_functional_test_case directly (not
 * \phpbb_database_test_case — see integration-tests.md's 2026-09
 * correction) since that's what gives a real DB connection and a real
 * installed extension in this test framework.
 *
 * @group integration
 */
class avathar_bbguildlotro_lotro_seed_data_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}

	private function fetch_all(string $sql): array
	{
		$db = $this->get_db();
		$result = $db->sql_query($sql);
		$rows = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$db->sql_freeresult($result);

		return $rows;
	}

	public function test_every_class_has_a_valid_armor_type()
	{
		$rows = $this->fetch_all('SELECT class_id, class_armor_type
			FROM ' . $this->get_table_prefix() . "bb_classes
			WHERE game_id = 'lotro'");

		$this->assertNotEmpty($rows);
		$valid = array('CLOTH', 'MAIL', 'PLATE');
		foreach ($rows as $row)
		{
			$this->assertContains($row['class_armor_type'], $valid, "class_id {$row['class_id']} has an invalid armor type");
		}
	}

	public function test_every_race_references_a_valid_faction()
	{
		$factions = $this->fetch_all("SELECT faction_id FROM " . $this->get_table_prefix() . "bb_factions WHERE game_id = 'lotro'");
		$valid_faction_ids = array_map('intval', array_column($factions, 'faction_id'));
		$valid_faction_ids[] = 0; // 0 is the "no faction" sentinel used elsewhere in bbguild core

		$races = $this->fetch_all('SELECT race_id, race_faction_id
			FROM ' . $this->get_table_prefix() . "bb_races
			WHERE game_id = 'lotro'");

		// DIAGNOSTIC (temporary): this assertion has failed in CI on
		// race_id 0 / faction_id 1 despite lotro_installer.php seeding
		// exactly that pair and nothing else touching bb_factions for
		// game_id='lotro' in this test suite. Dumping full state on
		// failure to actually observe what CI sees instead of guessing
		// further from static reading. Remove once root-caused.
		$this->assertNotEmpty($races, 'no lotro races found at all — factions count: ' . count($factions) . ', games row: ' . var_export($this->fetch_all("SELECT * FROM " . $this->get_table_prefix() . "bb_games WHERE game_id = 'lotro'"), true));
		foreach ($races as $row)
		{
			$this->assertContains(
				(int) $row['race_faction_id'],
				$valid_faction_ids,
				"race_id {$row['race_id']} references a faction_id not present in bb_factions for game_id='lotro'. "
				. 'valid_faction_ids=' . var_export($valid_faction_ids, true)
				. ' raw factions rows=' . var_export($factions, true)
				. ' race_count=' . count($races)
			);
		}
	}

	public function test_no_duplicate_class_ids_for_this_game()
	{
		$rows = $this->fetch_all('SELECT class_id, COUNT(*) AS cnt
			FROM ' . $this->get_table_prefix() . "bb_classes
			WHERE game_id = 'lotro'
			GROUP BY class_id
			HAVING COUNT(*) > 1");

		$this->assertEmpty($rows, 'duplicate class_id(s) for game_id=lotro: ' . implode(',', array_column($rows, 'class_id')));
	}

	public function test_no_duplicate_race_ids_for_this_game()
	{
		$rows = $this->fetch_all('SELECT race_id, COUNT(*) AS cnt
			FROM ' . $this->get_table_prefix() . "bb_races
			WHERE game_id = 'lotro'
			GROUP BY race_id
			HAVING COUNT(*) > 1");

		$this->assertEmpty($rows, 'duplicate race_id(s) for game_id=lotro: ' . implode(',', array_column($rows, 'race_id')));
	}

	public function test_every_class_id_has_a_language_row()
	{
		$class_ids = array_column($this->fetch_all("SELECT class_id FROM " . $this->get_table_prefix() . "bb_classes WHERE game_id = 'lotro'"), 'class_id');
		$lang_class_ids = array_unique(array_column($this->fetch_all("SELECT attribute_id FROM " . $this->get_table_prefix() . "bb_language WHERE game_id = 'lotro' AND attribute = 'class'"), 'attribute_id'));

		foreach ($class_ids as $class_id)
		{
			$this->assertContains((int) $class_id, array_map('intval', $lang_class_ids), "class_id $class_id has no bb_language row");
		}
	}

	/**
	 * KNOWN CONTENT GAP: race_id 35 ("Rivendell Elf", image
	 * 'lotro_elf_rivendell') is seeded in bb_races_table but has zero
	 * bb_language rows under attribute='race' in ANY of the 4 seeded
	 * languages — see tests/game/lotro_installer_test.php's
	 * test_install_races_race_id_35_has_no_translation_anywhere() for the
	 * same finding at the unit level. Documented here rather than fixed
	 * (out of scope for this test-suite ticket); excluded from the
	 * otherwise-strict "every seeded race has a translation" check below
	 * so this integration test documents the gap explicitly instead of
	 * failing on a known, already-flagged issue.
	 */
	public function test_every_race_id_has_a_language_row_except_known_gap()
	{
		$known_gap_race_ids = array(35);

		$race_ids = array_column($this->fetch_all("SELECT race_id FROM " . $this->get_table_prefix() . "bb_races WHERE game_id = 'lotro'"), 'race_id');
		$lang_race_ids = array_unique(array_column($this->fetch_all("SELECT attribute_id FROM " . $this->get_table_prefix() . "bb_language WHERE game_id = 'lotro' AND attribute = 'race'"), 'attribute_id'));
		$lang_race_ids = array_map('intval', $lang_race_ids);

		foreach ($race_ids as $race_id)
		{
			$race_id = (int) $race_id;
			if (in_array($race_id, $known_gap_race_ids, true))
			{
				$this->assertNotContains($race_id, $lang_race_ids, "race_id $race_id now has a translation — remove it from \$known_gap_race_ids");
				continue;
			}

			$this->assertContains($race_id, $lang_race_ids, "race_id $race_id has no bb_language row");
		}
	}
}
