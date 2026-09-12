<?php
/**
 * bbGuild LOTRO Extension — guild view rendering functional test
 *
 * @package   bbguildlotro v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Inserts a guild fixture with game_id='lotro' and one player (a valid
 * class/race pair for this game), GETs /guild/{guild_id} as an
 * authenticated user, and asserts:
 * - Response is 200
 * - The roster portal module rendered the player row
 * - The class image path resolves under
 *   ext/avathar/bbguildlotro/images/ (portal/modules/roster.php's
 *   display_listing() builds this from lotro_provider::get_images_path())
 *
 * Fixture uses guild_id 4242 — distinct from bbguild core's own sample
 * "Test Guild" (id=1) and from disable_keeps_core_test.php's control
 * guild, per tests/integration-tests.md's fixture-identity note.
 *
 * Catches: guild_context wiring, image path resolution, roster module
 * not picking up a newly-installed game's provider.
 *
 * @group functional
 */
class avathar_bbguildlotro_guild_view_renders_test extends phpbb_functional_test_case
{
	const GUILD_ID = 4242;

	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildlotro');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$db = $this->get_db();
		$prefix = self::$config['table_prefix'];

		// Clean up any leftover row from a previous run, then insert fresh.
		$db->sql_query('DELETE FROM ' . $prefix . 'bb_players WHERE player_guild_id = ' . self::GUILD_ID);
		$db->sql_query('DELETE FROM ' . $prefix . 'bb_ranks WHERE guild_id = ' . self::GUILD_ID);
		$db->sql_query('DELETE FROM ' . $prefix . 'bb_portal_modules WHERE guild_id = ' . self::GUILD_ID);
		$db->sql_query('DELETE FROM ' . $prefix . 'bb_guild WHERE id = ' . self::GUILD_ID);

		$db->sql_query('INSERT INTO ' . $prefix . 'bb_guild ' . $db->sql_build_array('INSERT', array(
			'id'             => self::GUILD_ID,
			'name'           => 'Lotro Test Guild',
			'realm'          => 'Test Realm',
			'region'         => 'us',
			'roster'         => 1,
			'players'        => 1,
			'emblemurl'      => '',
			'game_id'        => 'lotro',
			'game_edition'   => 'retail',
			'min_armory'     => 0,
			'rec_status'     => 1,
			'guilddefault'   => 0,
			'armory_enabled' => 0,
			'armoryresult'   => '',
			'recruitforum'   => 0,
			'faction'        => 1,
		)));

		$db->sql_query('INSERT INTO ' . $prefix . 'bb_ranks ' . $db->sql_build_array('INSERT', array(
			'guild_id'    => self::GUILD_ID,
			'rank_id'     => 0,
			'rank_name'   => 'Member',
			'rank_hide'   => 0,
			'rank_prefix' => '',
			'rank_suffix' => '',
		)));

		// class_id 2 = Captain (PLATE, imagename 'lotro_captain'),
		// race_id 12 = Man of Gondor (faction_id 1, imagename 'lotro_man_gondor').
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_players ' . $db->sql_build_array('INSERT', array(
			'game_id'             => 'lotro',
			'player_name'         => 'Testlotroplayer',
			'player_region'       => 'us',
			'player_realm'        => 'Test Realm',
			'player_title'        => '',
			'player_level'        => 75,
			'player_race_id'      => 12,
			'player_class_id'     => 2,
			'player_rank_id'      => 0,
			'player_role'         => 'DPS',
			'player_comment'      => '',
			'player_joindate'     => time(),
			'player_outdate'      => 0,
			'player_guild_id'     => self::GUILD_ID,
			'player_gender_id'    => 0,
			'player_achiev'       => 0,
			'player_armory_url'   => '',
			'player_portrait_url' => '',
			'player_spec'         => '',
			'phpbb_user_id'       => 0,
			'player_status'       => 1,
			'deactivate_reason'   => '',
			'last_update'         => time(),
		)));

		$db->sql_query('INSERT INTO ' . $prefix . 'bb_portal_modules ' . $db->sql_build_array('INSERT', array(
			'guild_id'            => self::GUILD_ID,
			'module_classname'    => '\avathar\bbguild\portal\modules\roster',
			'module_column'       => 2,
			'module_order'        => 1,
			'module_name'         => 'BBGUILD_PORTAL_ROSTER',
			'module_image_src'    => '',
			'module_icon'         => '',
			'module_icon_size'    => 16,
			'module_image_width'  => 16,
			'module_image_height' => 16,
			'module_group_ids'    => '',
			'module_status'       => 1,
		)));
	}

	public function test_guild_view_renders_lotro_roster_row()
	{
		$this->login('admin');

		self::request('GET', 'app.php/guild/' . self::GUILD_ID, array(), false);
		$status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $status, '/guild/' . self::GUILD_ID . ' did not render');

		$body = self::$client->getResponse()->getContent();
		$this->assertStringContainsString('Testlotroplayer', $body, 'roster module did not render the player row');
		$this->assertStringContainsString('ext/avathar/bbguildlotro/images/', $body, 'class image did not resolve under this plugin\'s images/ path');
		$this->assertStringContainsString('lotro_captain', $body, 'class image did not resolve to the expected imagename');

		$this->logout();
	}
}
