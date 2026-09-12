<?php
/**
 * bbGuild LOTRO Extension — migration idempotency smoke test
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Disables bbguildlotro (data preserved) and re-enables it, then asserts
 * seeded rows were not duplicated. Disable does not revert schema/data,
 * so re-enabling re-runs every migration's effectively_installed() check
 * against data that's already there — this is the only way to exercise
 * that path without a second fresh install. Catches migrations that
 * mistakenly re-seed or re-create on a second run.
 *
 * Unlike bbguildwow, this plugin has no bb_specializations rows yet
 * (specs are a separate, unimplemented ticket — install_specs() is not
 * overridden, so the abstract base's no-op default runs), so there is
 * nothing to check there.
 *
 * @group smoke
 */
class avathar_bbguildlotro_smoke_migration_idempotency_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	private function count_rows(string $table, string $where): int
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(*) AS cnt FROM ' . $table . ' WHERE ' . $where;
		$result = $db->sql_query($sql);
		$count = (int) $db->sql_fetchfield('cnt');
		$db->sql_freeresult($result);

		return $count;
	}

	public function test_reenable_does_not_duplicate_seeded_data()
	{
		$before_games = $this->count_rows($this->get_table_prefix() . 'bb_games', "game_id = 'lotro'");
		$before_classes = $this->count_rows($this->get_table_prefix() . 'bb_classes', "game_id = 'lotro'");
		$before_races = $this->count_rows($this->get_table_prefix() . 'bb_races', "game_id = 'lotro'");
		$before_language = $this->count_rows($this->get_table_prefix() . 'bb_language', "game_id = 'lotro'");
		$before_migrations = $this->count_rows($this->get_table_prefix() . 'migrations', "migration_name LIKE '%bbguildlotro%'");

		$this->disable_ext('avathar/bbguildlotro');
		$this->install_ext('avathar/bbguildlotro');

		$after_games = $this->count_rows($this->get_table_prefix() . 'bb_games', "game_id = 'lotro'");
		$after_classes = $this->count_rows($this->get_table_prefix() . 'bb_classes', "game_id = 'lotro'");
		$after_races = $this->count_rows($this->get_table_prefix() . 'bb_races', "game_id = 'lotro'");
		$after_language = $this->count_rows($this->get_table_prefix() . 'bb_language', "game_id = 'lotro'");
		$after_migrations = $this->count_rows($this->get_table_prefix() . 'migrations', "migration_name LIKE '%bbguildlotro%'");

		$this->assertSame(1, $before_games, 'expected exactly one lotro row in bb_games before re-enable');
		$this->assertSame($before_games, $after_games, 'bb_games lotro row was duplicated on re-enable');
		$this->assertSame($before_classes, $after_classes, 'bb_classes lotro rows were duplicated on re-enable');
		$this->assertSame($before_races, $after_races, 'bb_races lotro rows were duplicated on re-enable');
		$this->assertSame($before_language, $after_language, 'bb_language lotro rows were duplicated on re-enable');
		$this->assertSame($before_migrations, $after_migrations, 'bbguildlotro migration rows changed on re-enable');
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}
}
