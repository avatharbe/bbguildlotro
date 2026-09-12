<?php
/**
 * bbGuild LOTRO Extension — enable functional test
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Enables bbguild core, then bbguildlotro on top. Asserts:
 * - a 'lotro' row is present in bb_games
 * - bbguildlotro's classes are seeded in bb_classes for game_id='lotro'
 * - the plugin's own version constant matches composer.json
 *
 * Unlike bbguildwow, this plugin has no ACP modules of its own — nothing
 * is registered under bbguild's ACP category by bbguildlotro, so (per
 * functional-tests.md's "Notes for other plugins") there is no ACP
 * module visibility assertion here.
 *
 * Catches: migration regressions, services.yml misconfig, missing tables.
 *
 * @group functional
 */
class avathar_bbguildlotro_extension_enable_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	public function test_lotro_game_row_present()
	{
		$db = $this->get_db();
		$sql = 'SELECT game_id, game_name
			FROM ' . $this->get_table_prefix() . "bb_games
			WHERE game_id = 'lotro'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertNotFalse($row, "expected a 'lotro' row in bb_games after enabling bbguildlotro");
		$this->assertSame('Lord of the Rings Online', $row['game_name']);
	}

	public function test_lotro_classes_seeded()
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(*) AS cnt
			FROM ' . $this->get_table_prefix() . "bb_classes
			WHERE game_id = 'lotro'";
		$result = $db->sql_query($sql);
		$count = (int) $db->sql_fetchfield('cnt');
		$db->sql_freeresult($result);

		$this->assertSame(17, $count, 'expected 17 lotro classes seeded in bb_classes');
	}

	public function test_lotro_races_seeded()
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(*) AS cnt
			FROM ' . $this->get_table_prefix() . "bb_races
			WHERE game_id = 'lotro'";
		$result = $db->sql_query($sql);
		$count = (int) $db->sql_fetchfield('cnt');
		$db->sql_freeresult($result);

		$this->assertSame(25, $count, 'expected 25 lotro races seeded in bb_races');
	}

	public function test_version_constant_matches_composer_json()
	{
		$composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

		$this->assertSame($composer['version'], \avathar\bbguildlotro\ext::BBGUILDLOTRO_VERSION);
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}
}
