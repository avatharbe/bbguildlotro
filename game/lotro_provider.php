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
use avathar\bbguild\model\games\specialization_provider_interface;

class lotro_provider implements game_provider_interface, specialization_provider_interface
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

	public function get_installer(): \avathar\bbguild\model\games\game_install_interface
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

	public function get_api(): ?\avathar\bbguild\model\games\game_api_interface
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

	/**
	 * Class Trait Tree catalog (issue #6), keyed by class_id (see
	 * game/lotro_installer.php's install_classes() for the id map).
	 *
	 * LOTRO's classes each carry three "trait lines" (in-game UI tabs
	 * commonly called the Blue/Red/Yellow line) since the Update 24
	 * ("Mordor") class trait tree revamp — a genuine specialization layer
	 * on top of the fixed class_id, not something invented for this
	 * catalog. spec_order 1/2/3 follows that same Blue/Red/Yellow tab
	 * order used in-game.
	 *
	 * role_id uses this plugin's default (unoverridden) abstract_game_install
	 * role set: 0 Damage, 1 Healer, 2 Defense. LOTRO's trait lines don't
	 * map perfectly onto a strict DPS/Healer/Tank trichotomy — several
	 * lines are crowd-control/support hybrids with no dedicated "Support"
	 * bucket available here — so those are bucketed under Damage(0) as
	 * the closest fit; see the docblock note on each such class below.
	 *
	 * Deliberately NOT included: class_id 0 (Unknown, not a real class)
	 * and the Monster Play (Ettenmoors) class_ids 20-25 (Reaver, Defiler,
	 * Weaver, Blackarrow, Warleader, Stalker). Monster Play classes do
	 * have their own trait trees in-game, but this catalog's Free Peoples
	 * entries below were confirmed against current (2026) class-guide
	 * sources; equivalent confirmation for the six Monster Play trait
	 * trees could not be obtained (wiki pages were unreachable at time of
	 * writing), so they are honestly left out rather than guessed at.
	 * Follow-up ticket: fill in Monster Play specs once sourced.
	 *
	 * Also NOT included: the yellow trait line for Guardian, Minstrel,
	 * and Warden. All three still show a yellow tab in the trait UI, but
	 * per the current (2026) class-guide consensus (LOTRO Hub's Ultimate
	 * Class Guide, I Love Fried Orc's trait planner, and — for Minstrel
	 * specifically — the official Update 33.2 patch notes on
	 * forums.lotro.com) that line was converted to a "Supplemental
	 * Traits (Passive)" tree: players can no longer select it as their
	 * class specialization, only the other two remain choosable. Listing
	 * it here as a normal third spec would misrepresent what a player can
	 * actually pick, so class_id 4/7/9 below carry 2 entries, not 3.
	 *
	 * spec_icon intentionally left empty: no icon assets exist yet for
	 * these lines, matching the bbguildgw2 precedent (also shipped with
	 * empty spec_icon). Tracked separately as a follow-up.
	 *
	 * @return array<int, list<array{spec_name:string,role_id:int,spec_icon:string,spec_order:int}>>
	 */
	public static function spec_catalog(): array
	{
		[$dps, $healer, $tank] = [0, 1, 2];

		return array(
			1 => array( // Burglar — third line ("Mischief-maker") is a
				// control/support hybrid with no healing; bucketed as
				// Damage for lack of a dedicated Support role here.
				array('spec_name' => 'The Gambler',        'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'The Quiet Knife',     'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'The Mischief-maker',  'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 3),
			),
			2 => array( // Captain
				array('spec_name' => 'Hands of Healing',   'role_id' => $healer, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'Lead the Charge',    'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'Leader of Men',      'role_id' => $tank,   'spec_icon' => '', 'spec_order' => 3),
			),
			3 => array( // Champion
				array('spec_name' => 'The Martial Champion', 'role_id' => $tank, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'The Berserker',        'role_id' => $dps,  'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'The Deadly Storm',     'role_id' => $dps,  'spec_icon' => '', 'spec_order' => 3),
			),
			4 => array( // Guardian — yellow line ("The Fighter of Shadow")
				// is a passive/supplemental tree as of the current class
				// revamp, not a selectable specialization; see the
				// catalog-level docblock note above. Only 2 real specs.
				array('spec_name' => 'The Defender of the Free', 'role_id' => $tank, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'The Keen Blade',           'role_id' => $dps,  'spec_icon' => '', 'spec_order' => 2),
			),
			5 => array( // Hunter — all three lines are DPS variants
				// (mobile/ranged/utility); Hunter has no tank or heal line.
				array('spec_name' => 'Huntsman',        'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'Bowmaster',       'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'Trapper of Foes', 'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 3),
			),
			6 => array( // Lore-master — third line ("The Ancient Master")
				// is support/crowd-control focused, not a dedicated heal
				// line; bucketed as Damage for lack of a Support role.
				array('spec_name' => 'Keeper of Animals',        'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => "Master of Nature's Fury",  'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'The Ancient Master',       'role_id' => $dps, 'spec_icon' => '', 'spec_order' => 3),
			),
			7 => array( // Minstrel — yellow line ("The Protector of Song")
				// was converted to a passive/supplemental tree in Update
				// 33.2 and can no longer be chosen as a specialization
				// (confirmed via official forums.lotro.com patch notes);
				// only 2 real specs.
				array('spec_name' => 'The Watcher of Resolve',  'role_id' => $healer, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'The Warrior-Skald',       'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 2),
			),
			8 => array( // Rune-keeper
				array('spec_name' => 'Benediction of Peace', 'role_id' => $healer, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'Cleansing Flame',      'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'Solitary Thunder',     'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 3),
			),
			9 => array( // Warden — yellow line ("Assailment") is a
				// passive/supplemental tree, not a selectable
				// specialization; see the catalog-level docblock note
				// above. Only 2 real specs.
				array('spec_name' => 'Determination', 'role_id' => $tank, 'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'Recklessness',  'role_id' => $dps,  'spec_icon' => '', 'spec_order' => 2),
			),
			10 => array( // Beorning
				array('spec_name' => 'The Hide', 'role_id' => $tank,   'spec_icon' => '', 'spec_order' => 1),
				array('spec_name' => 'The Claw', 'role_id' => $dps,    'spec_icon' => '', 'spec_order' => 2),
				array('spec_name' => 'The Roar', 'role_id' => $healer, 'spec_icon' => '', 'spec_order' => 3),
			),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function get_spec_label(): string
	{
		return 'Trait Line';
	}

	/**
	 * Interface implementation: delegates to the static catalog.
	 *
	 * @return array<int, list<array{spec_name:string,role_id:int,spec_icon:string,spec_order:int}>>
	 */
	public function get_specializations(): array
	{
		return self::spec_catalog();
	}
}
