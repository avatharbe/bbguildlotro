<?php
/**
 * bbGuild LOTRO Extension — game registry functional test
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * After enabling bbguildlotro, asserts its game_provider is actually
 * registered with bbguild core's game registry (avathar.bbguild.game_registry,
 * fed by the tagged 'bbguild.game_provider' service collection) and
 * reachable, with has_api() === false — unlike bbguildwow, this plugin
 * has no external API.
 *
 * No in-process DI container is reachable from a phpbb_functional_test_case
 * (see tests/integration-tests.md's "No DI container is reachable
 * in-process" note — it applies here too, functional or integration),
 * so registration is verified two ways instead of a direct service
 * resolve:
 * - bb_games.armory_enabled for game_id='lotro' is 0 — this column is
 *   written by abstract_game_install::install() from has_api_support(),
 *   which lotro_installer does not override (default false), matching
 *   lotro_provider::has_api() === false.
 * - the ACP game list page (which reads the real, container-built
 *   game_registry service to render its rows) actually shows "Lord of
 *   the Rings Online" — proof the provider is registered and reachable,
 *   not just that a raw bb_games row exists.
 *
 * Catches: 'bbguild.game_provider' tag missing in services.yml, broken
 * provider class.
 *
 * @group functional
 */
class avathar_bbguildlotro_game_registry_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	public function test_lotro_has_no_api_per_bb_games_row()
	{
		$db = $this->get_db();
		$sql = 'SELECT armory_enabled
			FROM ' . self::$config['table_prefix'] . "bb_games
			WHERE game_id = 'lotro'";
		$result = $db->sql_query($sql);
		$armory_enabled = $db->sql_fetchfield('armory_enabled');
		$db->sql_freeresult($result);

		$this->assertNotFalse($armory_enabled, "expected a 'lotro' row in bb_games");
		$this->assertEquals(0, $armory_enabled, 'lotro has no API — armory_enabled should be 0');
	}

	public function test_lotro_provider_reachable_via_acp_game_list()
	{
		$this->login('admin');
		$this->admin_login();

		self::request('GET', 'adm/index.php?i=-avathar-bbguild-acp-game_module&mode=listgames&sid=' . $this->sid, array(), false);
		$status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $status, 'ACP game list page did not load');

		$body = self::$client->getResponse()->getContent();
		$this->assertStringContainsString('Lord of the Rings Online', $body, 'lotro provider not visible in the ACP game list — game_registry did not pick it up');

		$this->logout();
	}
}
