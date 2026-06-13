<?php
/**
 * LOTRO Game Provider
 *
 * @package   bbguildlotro v2.0
 * @copyright 2018 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace avathar\bbguildlotro\game;

use avathar\bbguild\model\games\game_provider_interface;

class lotro_provider implements game_provider_interface
{
	/** @var lotro_installer */
	private $installer;

	/** @var \phpbb\extension\manager */
	private $ext_manager;

	public function __construct(lotro_installer $installer, \phpbb\extension\manager $ext_manager)
	{
		$this->installer = $installer;
		$this->ext_manager = $ext_manager;
	}

	public function get_game_id(): string
	{
		return 'lotro';
	}

	public function get_game_name(): string
	{
		return 'Lord of the Rings Online';
	}

	public function get_installer(): game_install_interface
	{
		return $this->installer;
	}

	public function get_boss_base_url(): string
	{
		return 'http://lotro.allakhazam.com/db/bestiary.html?lotrmob=%s';
	}

	public function get_zone_base_url(): string
	{
		return 'http://lotro.allakhazam.com/db/geography.html?lotrarea=%s';
	}

	public function get_images_path(): string
	{
		return $this->ext_manager->get_extension_path('avathar/bbguildlotro', true) . 'images/';
	}

	public function has_api(): bool
	{
		return false;
	}

	public function get_api(): ?game_api_interface
	{
		return null;
	}

	public function get_regions(): array
	{
		return array(
			'us' => 'US',
			'eu' => 'EU',
		);
	}

	public function get_api_locales(): array
	{
		return array();
	}

	public function get_armor_types(): array
	{
		return array(
			'CLOTH' => 'Cloth',
			'MAIL'  => 'Mail',
			'PLATE' => 'Plate',
		);
	}
}
