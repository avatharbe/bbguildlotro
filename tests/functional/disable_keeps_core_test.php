<?php
/**
 * bbGuild LOTRO Extension — disabling this plugin must not break core
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Per tests/functional-tests.md's "Notes for other plugins", this is the
 * single most important guardrail for a non-flagship plugin: disabling
 * bbguildlotro must not cascade-break bbguild core for guilds that have
 * nothing to do with it.
 *
 * Enables bbguild core + bbguildlotro, then uses a control guild on
 * core's own built-in 'custom' game_id (bbguild's own sample data,
 * seeded by migrations/v200b3::insert_sample_data() — no other game
 * plugin required). Disables bbguildlotro. Asserts:
 * - the control guild's page still renders 200
 * - bbguild core's ACP game list still loads
 *
 * Catches: shared service definitions accidentally moved into the
 * plugin, event listeners that throw when the plugin is gone.
 *
 * @group functional
 */
class avathar_bbguildlotro_disable_keeps_core_test extends phpbb_functional_test_case
{
	/** @var int */
	private $control_guild_id;

	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$db = $this->get_db();
		$prefix = self::$config['table_prefix'];

		// bbguild core seeds a 'custom' game_id "Test Guild" (id 1) via its
		// own sample-data migration step on install. Use it if present so
		// this test truly doesn't depend on any other plugin; otherwise
		// (e.g. sample data was removed by another test file) fall back to
		// inserting our own 'custom'-game control guild at a distinct id.
		$sql = "SELECT id FROM " . $prefix . "bb_guild WHERE game_id = 'custom' " . $db->sql_order_by(array('id' => 'ASC'));
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			$this->control_guild_id = (int) $row['id'];
			return;
		}

		$this->control_guild_id = 4243;
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_guild ' . $db->sql_build_array('INSERT', array(
			'id'             => $this->control_guild_id,
			'name'           => 'Control Guild',
			'realm'          => 'Control Realm',
			'region'         => 'us',
			'roster'         => 1,
			'players'        => 0,
			'emblemurl'      => '',
			'game_id'        => 'custom',
			'game_edition'   => 'retail',
			'min_armory'     => 0,
			'rec_status'     => 1,
			'guilddefault'   => 0,
			'armory_enabled' => 0,
			'armoryresult'   => '',
			'recruitforum'   => 0,
			'faction'        => 0,
		)));
	}

	private function get_status(string $path): int
	{
		self::request('GET', $path, array(), false);
		return (int) self::$client->getResponse()->getStatus();
	}

	public function test_disabling_bbguildlotro_does_not_break_core_guild_or_acp()
	{
		$this->login('admin');

		$before_guild_status = $this->get_status('app.php/guild/' . $this->control_guild_id);
		$this->assertSame(200, $before_guild_status, 'control guild did not render before disabling bbguildlotro');

		$this->admin_login();
		$before_acp_status = $this->get_status('adm/index.php?i=-avathar-bbguild-acp-game_module&mode=listgames&sid=' . $this->sid);
		$this->assertSame(200, $before_acp_status, 'ACP game list did not load before disabling bbguildlotro');

		$this->disable_ext('avathar/bbguildlotro');

		$after_guild_status = $this->get_status('app.php/guild/' . $this->control_guild_id);
		$this->assertSame(200, $after_guild_status, 'control guild broke after disabling bbguildlotro');

		$after_acp_status = $this->get_status('adm/index.php?i=-avathar-bbguild-acp-game_module&mode=listgames&sid=' . $this->sid);
		$this->assertSame(200, $after_acp_status, 'ACP game list broke after disabling bbguildlotro');

		// Restore state for any test files that run after this one in the
		// same suite (phpbb_functional_test_case does not reset DB state
		// between test classes).
		$this->install_ext('avathar/bbguildlotro');

		$this->logout();
	}
}
