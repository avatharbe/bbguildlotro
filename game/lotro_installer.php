<?php
/**
 * LOTRO Installer
 *
 * Installs Lord of the Rings Online factions, classes, races, and roles.
 *
 * @package   bbguildlotro v2.0
 * @copyright 2018 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace avathar\bbguildlotro\game;

use avathar\bbguild\model\games\abstract_game_install;

class lotro_installer extends abstract_game_install
{
	/**
	 * Installs LOTRO factions
	 */
	protected function install_factions()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_factions_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'faction_id' => 1, 'faction_name' => 'Free Peoples');
		$sql_ary[] = array('game_id' => $this->game_id, 'faction_id' => 2, 'faction_name' => 'Servants of the Eye');
		$this->db->sql_multi_insert($this->table('bb_factions_table'), $sql_ary);
	}

	/**
	 * Installs LOTRO classes with translations (en, de, fr, it)
	 */
	protected function install_classes()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_classes_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		// Free Peoples
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 0,  'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#999999', 'imagename' => 'lotro_unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 1,  'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#FF0044', 'imagename' => 'lotro_burglar');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 2,  'class_armor_type' => 'PLATE', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC9933', 'imagename' => 'lotro_captain');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 3,  'class_armor_type' => 'PLATE', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#FF0044', 'imagename' => 'lotro_champion');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 4,  'class_armor_type' => 'PLATE', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC9933', 'imagename' => 'lotro_guardian');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 5,  'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#0077DD', 'imagename' => 'lotro_hunter');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 6,  'class_armor_type' => 'CLOTH', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC00AA', 'imagename' => 'lotro_lore-master');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 7,  'class_armor_type' => 'CLOTH', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#66FFCC', 'imagename' => 'lotro_minstrel');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 8,  'class_armor_type' => 'CLOTH', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC00AA', 'imagename' => 'lotro_rune-keeper');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 9,  'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC9933', 'imagename' => 'lotro_warden');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 10, 'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#CC9933', 'imagename' => 'lotro_beorning');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 11, 'class_armor_type' => 'PLATE', 'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#996633', 'imagename' => 'lotro_brawler');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 12, 'class_armor_type' => 'MAIL',  'class_min_level' => 1,  'class_max_level' => 75, 'colorcode' => '#0099CC', 'imagename' => 'lotro_mariner');
		// Monster Play
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 20, 'class_armor_type' => 'MAIL',  'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#FF0044', 'imagename' => 'lotro_reaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 21, 'class_armor_type' => 'CLOTH', 'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#66FFCC', 'imagename' => 'lotro_defiler');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 22, 'class_armor_type' => 'CLOTH', 'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#CC00AA', 'imagename' => 'lotro_weaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 23, 'class_armor_type' => 'MAIL',  'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#0077DD', 'imagename' => 'lotro_blackarrow');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 24, 'class_armor_type' => 'PLATE', 'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#CC9933', 'imagename' => 'lotro_warleader');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 25, 'class_armor_type' => 'MAIL',  'class_min_level' => 75, 'class_max_level' => 75, 'colorcode' => '#FF0044', 'imagename' => 'lotro_stalker');
		$this->db->sql_multi_insert($this->table('bb_classes_table'), $sql_ary);
		unset($sql_ary);

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_language_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "' AND attribute = 'class'");
		$sql_ary = array();

		// en
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'en', 'attribute' => 'class', 'name' => 'Unknown',    'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'en', 'attribute' => 'class', 'name' => 'Burglar',    'name_short' => 'Burglar');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'en', 'attribute' => 'class', 'name' => 'Captain',    'name_short' => 'Captain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'en', 'attribute' => 'class', 'name' => 'Champion',   'name_short' => 'Champion');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'en', 'attribute' => 'class', 'name' => 'Guardian',   'name_short' => 'Guardian');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'en', 'attribute' => 'class', 'name' => 'Hunter',     'name_short' => 'Hunter');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'en', 'attribute' => 'class', 'name' => 'Lore-master','name_short' => 'Lore-master');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'en', 'attribute' => 'class', 'name' => 'Minstrel',   'name_short' => 'Minstrel');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'en', 'attribute' => 'class', 'name' => 'Rune-keeper','name_short' => 'Rune-keeper');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'en', 'attribute' => 'class', 'name' => 'Warden',     'name_short' => 'Warden');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'en', 'attribute' => 'class', 'name' => 'Beorning',   'name_short' => 'Beorning');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'en', 'attribute' => 'class', 'name' => 'Brawler',    'name_short' => 'Brawler');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'en', 'attribute' => 'class', 'name' => 'Mariner',    'name_short' => 'Mariner');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 20, 'language' => 'en', 'attribute' => 'class', 'name' => 'Reaver',     'name_short' => 'Reaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'en', 'attribute' => 'class', 'name' => 'Defiler',    'name_short' => 'Defiler');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'en', 'attribute' => 'class', 'name' => 'Weaver',     'name_short' => 'Weaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'en', 'attribute' => 'class', 'name' => 'BlackArrow', 'name_short' => 'Blackarrow');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'en', 'attribute' => 'class', 'name' => 'Warleader',  'name_short' => 'Warleader');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 25, 'language' => 'en', 'attribute' => 'class', 'name' => 'Stalker',    'name_short' => 'Stalker');

		// de
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'de', 'attribute' => 'class', 'name' => 'Unbekannt',       'name_short' => 'Unbekannt');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'de', 'attribute' => 'class', 'name' => 'Schurke',         'name_short' => 'Schurke');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'de', 'attribute' => 'class', 'name' => 'Hauptmann',       'name_short' => 'Capitaine');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'de', 'attribute' => 'class', 'name' => 'Waffenmeister',   'name_short' => 'Champion');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'de', 'attribute' => 'class', 'name' => 'Wächter',         'name_short' => 'Guardien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'de', 'attribute' => 'class', 'name' => 'Jager',           'name_short' => 'Chasseur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'de', 'attribute' => 'class', 'name' => 'Kundiger',        'name_short' => 'Kundiger');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'de', 'attribute' => 'class', 'name' => 'Barde',           'name_short' => 'Barde');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'de', 'attribute' => 'class', 'name' => 'Runenbewahrer',   'name_short' => 'Runenbewahrer');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'de', 'attribute' => 'class', 'name' => 'Hüter',           'name_short' => 'Hüter');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'de', 'attribute' => 'class', 'name' => 'Beorninger',      'name_short' => 'Beorninger');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'de', 'attribute' => 'class', 'name' => 'Schläger',        'name_short' => 'Schläger');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'de', 'attribute' => 'class', 'name' => 'Seemann',         'name_short' => 'Seemann');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 20, 'language' => 'de', 'attribute' => 'class', 'name' => 'Schnitter',       'name_short' => 'Schnitter');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'de', 'attribute' => 'class', 'name' => 'Defiler',         'name_short' => 'Defiler');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'de', 'attribute' => 'class', 'name' => 'Weberspinne',     'name_short' => 'Weberspinne');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'de', 'attribute' => 'class', 'name' => 'Schwarzpfeil',    'name_short' => 'Schwarzpfeil');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'de', 'attribute' => 'class', 'name' => 'Kriegsanführer',  'name_short' => 'Kriegsanführer');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 25, 'language' => 'de', 'attribute' => 'class', 'name' => 'Pirscher',        'name_short' => 'Pirscher');

		// fr
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Inconnu',           'name_short' => 'Inconnu');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Cambrioleur',       'name_short' => 'Cambrioleur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Capitaine',         'name_short' => 'Capitaine');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Champion',          'name_short' => 'Champion');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Guardien',          'name_short' => 'Guardien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Chasseur',          'name_short' => 'Chasseur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Maitre du Savoir',  'name_short' => 'Maitre du Savoir');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Ménestrel',         'name_short' => 'Ménestrel');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Gardien des Rune',  'name_short' => 'Gardien des Rune');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'fr', 'attribute' => 'class', 'name' => 'Sentinelle',        'name_short' => 'Sentinelle');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Beornide',          'name_short' => 'Beornide');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Bagarreur',         'name_short' => 'Bagarreur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Marin',             'name_short' => 'Marin');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 20, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Coupeur',           'name_short' => 'Coupeur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Defiler',           'name_short' => 'Defiler');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Araignée',          'name_short' => 'Araignée');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Flêche Noire',      'name_short' => 'Flêche Noire');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Commandeur',        'name_short' => 'Commandeur');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 25, 'language' => 'fr', 'attribute' => 'class', 'name' => 'Malfrat',           'name_short' => 'Malfrat');

		// it
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'it', 'attribute' => 'class', 'name' => 'Unknown',    'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'it', 'attribute' => 'class', 'name' => 'Burglar',    'name_short' => 'Burglar');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'it', 'attribute' => 'class', 'name' => 'Captain',    'name_short' => 'Captain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'it', 'attribute' => 'class', 'name' => 'Champion',   'name_short' => 'Champion');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'it', 'attribute' => 'class', 'name' => 'Guardian',   'name_short' => 'Guardian');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'it', 'attribute' => 'class', 'name' => 'Hunter',     'name_short' => 'Hunter');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'it', 'attribute' => 'class', 'name' => 'Lore-master','name_short' => 'Lore-master');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'it', 'attribute' => 'class', 'name' => 'Minstrel',   'name_short' => 'Minstrel');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'it', 'attribute' => 'class', 'name' => 'Rune-keeper','name_short' => 'Rune-keeper');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'it', 'attribute' => 'class', 'name' => 'Warden',     'name_short' => 'Warden');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'it', 'attribute' => 'class', 'name' => 'Beorning',   'name_short' => 'Beorning');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'it', 'attribute' => 'class', 'name' => 'Rissaiolo', 'name_short' => 'Rissaiolo');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'it', 'attribute' => 'class', 'name' => 'Marinaio',   'name_short' => 'Marinaio');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 20, 'language' => 'it', 'attribute' => 'class', 'name' => 'Reaver',     'name_short' => 'Reaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'it', 'attribute' => 'class', 'name' => 'Defiler',    'name_short' => 'Defiler');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'it', 'attribute' => 'class', 'name' => 'Weaver',     'name_short' => 'Weaver');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'it', 'attribute' => 'class', 'name' => 'BlackArrow', 'name_short' => 'Blackarrow');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'it', 'attribute' => 'class', 'name' => 'Warleader',  'name_short' => 'Warleader');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 25, 'language' => 'it', 'attribute' => 'class', 'name' => 'Stalker',    'name_short' => 'Stalker');

		$this->db->sql_multi_insert($this->table('bb_language_table'), $sql_ary);
	}

	/**
	 * Installs LOTRO races with translations (en, de, fr, it)
	 */
	protected function install_races()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_races_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 0,  'race_faction_id' => 1, 'image_female' => 'lotro_unknown',          'image_male' => 'lotro_unknown');
		// Man
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 1,  'race_faction_id' => 1, 'image_female' => 'lotro_man',              'image_male' => 'lotro_man');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 11, 'race_faction_id' => 1, 'image_female' => 'lotro_man_dalelands',    'image_male' => 'lotro_man_dalelands');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 12, 'race_faction_id' => 1, 'image_female' => 'lotro_man_gondor',       'image_male' => 'lotro_man_gondor');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 13, 'race_faction_id' => 1, 'image_female' => 'lotro_man_rohan',        'image_male' => 'lotro_man_rohan');
		// Hobbit
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 2,  'race_faction_id' => 1, 'image_female' => 'lotro_hobbit',           'image_male' => 'lotro_hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 21, 'race_faction_id' => 1, 'image_female' => 'lotro_hobbit_fallohide', 'image_male' => 'lotro_hobbit_fallohide');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 22, 'race_faction_id' => 1, 'image_female' => 'lotro_hobbit_harfoot',   'image_male' => 'lotro_hobbit_harfoot');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 23, 'race_faction_id' => 1, 'image_female' => 'lotro_hobbit_stoor',     'image_male' => 'lotro_hobbit_stoor');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 24, 'race_faction_id' => 1, 'image_female' => 'lotro_hobbit_river',     'image_male' => 'lotro_hobbit_river');
		// Elf
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 3,  'race_faction_id' => 1, 'image_female' => 'lotro_elf',              'image_male' => 'lotro_elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 31, 'race_faction_id' => 1, 'image_female' => 'lotro_elf_edhellond',    'image_male' => 'lotro_elf_edhellond');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 32, 'race_faction_id' => 1, 'image_female' => 'lotro_elf_lindon',       'image_male' => 'lotro_elf_lindon');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 33, 'race_faction_id' => 1, 'image_female' => 'lotro_elf_lorien',       'image_male' => 'lotro_elf_lorien');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 34, 'race_faction_id' => 1, 'image_female' => 'lotro_elf_mirkwood',     'image_male' => 'lotro_elf_mirkwood');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 35, 'race_faction_id' => 1, 'image_female' => 'lotro_elf_rivendell',    'image_male' => 'lotro_elf_rivendell');
		// Dwarf
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 4,  'race_faction_id' => 1, 'image_female' => 'lotro_dwarf',            'image_male' => 'lotro_dwarf');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 41, 'race_faction_id' => 1, 'image_female' => 'lotro_dwarf_blue',       'image_male' => 'lotro_dwarf_blue');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 42, 'race_faction_id' => 1, 'image_female' => 'lotro_dwarf_grey',       'image_male' => 'lotro_dwarf_grey');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 43, 'race_faction_id' => 1, 'image_female' => 'lotro_dwarf_iron',       'image_male' => 'lotro_dwarf_iron');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 44, 'race_faction_id' => 1, 'image_female' => 'lotro_dwarf_lonely',     'image_male' => 'lotro_dwarf_lonely');
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 45, 'race_faction_id' => 1, 'image_female' => 'lotro_dwarf_white',      'image_male' => 'lotro_dwarf_white');
		// Beorning
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 5,  'race_faction_id' => 1, 'image_female' => 'lotro_beorning',        'image_male' => 'lotro_beorning');
		// High Elf
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 6,  'race_faction_id' => 1, 'image_female' => 'lotro_highelf',         'image_male' => 'lotro_highelf');
		// Stout-Axe
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 7,  'race_faction_id' => 1, 'image_female' => 'lotro_stoutaxe',        'image_male' => 'lotro_stoutaxe');
		// Monster
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 50, 'race_faction_id' => 2, 'image_female' => 'lotro_monster',          'image_male' => 'lotro_monster');
		$this->db->sql_multi_insert($this->table('bb_races_table'), $sql_ary);
		unset($sql_ary);

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_language_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "' AND attribute = 'race'");
		$sql_ary = array();

		// en
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'en', 'attribute' => 'race', 'name' => 'Unknown',              'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'en', 'attribute' => 'race', 'name' => 'Man',                   'name_short' => 'Man');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'en', 'attribute' => 'race', 'name' => 'Man of Dalelands',      'name_short' => 'Dalelands');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'en', 'attribute' => 'race', 'name' => 'Man of Gondor',         'name_short' => 'Gondorian');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 13, 'language' => 'en', 'attribute' => 'race', 'name' => 'Man of Rohan',          'name_short' => 'Rohirrim');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'en', 'attribute' => 'race', 'name' => 'Hobbit',                'name_short' => 'Hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'en', 'attribute' => 'race', 'name' => 'Fallohide Hobbit',      'name_short' => 'Fallohide');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'en', 'attribute' => 'race', 'name' => 'Harfoot Hobbit',        'name_short' => 'Harfoot');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'en', 'attribute' => 'race', 'name' => 'Stoor Hobbit',          'name_short' => 'Stoor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'en', 'attribute' => 'race', 'name' => 'River Hobbit',          'name_short' => 'River Hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'en', 'attribute' => 'race', 'name' => 'Elf',                   'name_short' => 'Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 31, 'language' => 'en', 'attribute' => 'race', 'name' => 'Nandor Elf',            'name_short' => 'Nandor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 32, 'language' => 'en', 'attribute' => 'race', 'name' => 'Lorien Elf',            'name_short' => 'Lorien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 33, 'language' => 'en', 'attribute' => 'race', 'name' => 'Mirkwood Elf',          'name_short' => 'Mirkwood');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 34, 'language' => 'en', 'attribute' => 'race', 'name' => 'Rivendell Elf',         'name_short' => 'Rivendell');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'en', 'attribute' => 'race', 'name' => 'Dwarf',                 'name_short' => 'Dwarf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 41, 'language' => 'en', 'attribute' => 'race', 'name' => 'Blue Mountains Dwarf',  'name_short' => 'Blue Mountains');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 42, 'language' => 'en', 'attribute' => 'race', 'name' => 'Grey Mountain Dwarf',   'name_short' => 'Grey Mountains');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 43, 'language' => 'en', 'attribute' => 'race', 'name' => 'Iron Hill Dwarf',       'name_short' => 'Iron Hills');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 44, 'language' => 'en', 'attribute' => 'race', 'name' => 'Lonely Mountain Dwarf', 'name_short' => 'Lonely Montain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 45, 'language' => 'en', 'attribute' => 'race', 'name' => 'White Mountain Dwarf',  'name_short' => 'White Mountain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'en', 'attribute' => 'race', 'name' => 'Beorning',              'name_short' => 'Beorning');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'en', 'attribute' => 'race', 'name' => 'High Elf',              'name_short' => 'High Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'en', 'attribute' => 'race', 'name' => 'Stout-axe Dwarf',       'name_short' => 'Stout-axe');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 50, 'language' => 'en', 'attribute' => 'race', 'name' => 'Servant of the Eye',    'name_short' => 'Servant of the Eye');

		// de
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'de', 'attribute' => 'race', 'name' => 'Mensch',              'name_short' => 'Mensch');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'de', 'attribute' => 'race', 'name' => 'Thallandmenschen',    'name_short' => 'Thalland');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'de', 'attribute' => 'race', 'name' => 'Gondormensch',        'name_short' => 'Gondor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 13, 'language' => 'de', 'attribute' => 'race', 'name' => 'Riddermark',          'name_short' => 'Rohirrim');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'de', 'attribute' => 'race', 'name' => 'Hobbit',              'name_short' => 'Hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'de', 'attribute' => 'race', 'name' => 'Falbhauthobbits',     'name_short' => 'Falbhaut');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'de', 'attribute' => 'race', 'name' => 'Harfusshobbits',      'name_short' => 'Harfuss');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'de', 'attribute' => 'race', 'name' => 'Starrenhobbit',       'name_short' => 'Starren');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'de', 'attribute' => 'race', 'name' => 'Flusshobbit',         'name_short' => 'Flusshobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'de', 'attribute' => 'race', 'name' => 'Elb',                 'name_short' => 'Elb');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 31, 'language' => 'de', 'attribute' => 'race', 'name' => 'Nandor Elben',        'name_short' => 'Nandor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 32, 'language' => 'de', 'attribute' => 'race', 'name' => 'Lorien Elben',        'name_short' => 'Lorien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 33, 'language' => 'de', 'attribute' => 'race', 'name' => 'Waldelben',           'name_short' => 'Düsterwald Elben');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 34, 'language' => 'de', 'attribute' => 'race', 'name' => 'Rivendell Elben',     'name_short' => 'Rivendell');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'de', 'attribute' => 'race', 'name' => 'Zwerg',               'name_short' => 'Zwerg');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 41, 'language' => 'de', 'attribute' => 'race', 'name' => 'Blaue Zwerge',        'name_short' => 'Blauer Zwerge');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 42, 'language' => 'de', 'attribute' => 'race', 'name' => 'Graue Zwerge',        'name_short' => 'Graue Zwerge');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 43, 'language' => 'de', 'attribute' => 'race', 'name' => 'Eisenzwerge',         'name_short' => 'Eisenzwerg');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 44, 'language' => 'de', 'attribute' => 'race', 'name' => 'Smaugzwergen',        'name_short' => 'Einsamer Berg Zwergen');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 45, 'language' => 'de', 'attribute' => 'race', 'name' => 'Weisse Zwergen',      'name_short' => 'Weisse Zwergen');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'de', 'attribute' => 'race', 'name' => 'Beorninger',          'name_short' => 'Beorninger');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'de', 'attribute' => 'race', 'name' => 'Hochelb',             'name_short' => 'Hochelb');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'de', 'attribute' => 'race', 'name' => 'Starkaxt-Zwerg',      'name_short' => 'Starkaxt');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 50, 'language' => 'de', 'attribute' => 'race', 'name' => 'Böse Seite',          'name_short' => 'Böse Seite');

		// fr
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Humain',                  'name_short' => 'Humain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Hobbit',                   'name_short' => 'Hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Hobbits Pâles',            'name_short' => 'Hobbits Pâles');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Hobbits Pieds Velus',      'name_short' => 'Hobbits Pieds Velus');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Hobbits Forts',            'name_short' => 'Hobbits Forts');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Hobbit des Rivières',      'name_short' => 'Hobbit des Rivières');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Elfe',                     'name_short' => 'Elfe');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 31, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Elfe d\'Edhollond',        'name_short' => 'Elfe d\'Edhollond');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 32, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Elfe de Lorien',           'name_short' => 'Elfe de Lorien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 33, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Elfe de la forêt Noire',   'name_short' => 'Forêt Noire');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 34, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Elfe de Rivendell',        'name_short' => 'Rivendell');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Nain',                     'name_short' => 'Nain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 41, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Nains bleus',              'name_short' => 'Nains bleus');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 42, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Nains gris',               'name_short' => 'Nain Gris');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 43, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Nains de fer',             'name_short' => 'Nains de Fer');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 44, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Nains seuls',              'name_short' => 'Nains seuls');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 45, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Nains blancs',             'name_short' => 'Nains blancs');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Beornide',                 'name_short' => 'Beornide');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Haut Elfe',                'name_short' => 'Haut Elfe');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'fr', 'attribute' => 'race', 'name' => 'Nain robuste',             'name_short' => 'Nain robuste');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 50, 'language' => 'fr', 'attribute' => 'race', 'name' => 'Serviteurs de l\'Oeil',    'name_short' => 'Serviteurs de l\'Oeil');

		// it
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'it', 'attribute' => 'race', 'name' => 'Unknown',              'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'it', 'attribute' => 'race', 'name' => 'Man',                   'name_short' => 'Man');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'it', 'attribute' => 'race', 'name' => 'Man of Dalelands',      'name_short' => 'Dalelands');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'it', 'attribute' => 'race', 'name' => 'Man of Gondor',         'name_short' => 'Gondorian');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 13, 'language' => 'it', 'attribute' => 'race', 'name' => 'Man of Rohan',          'name_short' => 'Rohirrim');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'it', 'attribute' => 'race', 'name' => 'Hobbit',                'name_short' => 'Hobbit');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 21, 'language' => 'it', 'attribute' => 'race', 'name' => 'Fallohide Hobbit',      'name_short' => 'Fallohide');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 22, 'language' => 'it', 'attribute' => 'race', 'name' => 'Harfoot Hobbit',        'name_short' => 'Harfoot');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 23, 'language' => 'it', 'attribute' => 'race', 'name' => 'Stoor Hobbit',          'name_short' => 'Stoor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 24, 'language' => 'it', 'attribute' => 'race', 'name' => 'Hobbit del Fiume',      'name_short' => 'Hobbit del Fiume');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'it', 'attribute' => 'race', 'name' => 'Elf',                   'name_short' => 'Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 31, 'language' => 'it', 'attribute' => 'race', 'name' => 'Nandor Elf',            'name_short' => 'Nandor');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 32, 'language' => 'it', 'attribute' => 'race', 'name' => 'Lorien Elf',            'name_short' => 'Lorien');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 33, 'language' => 'it', 'attribute' => 'race', 'name' => 'Mirkwood Elf',          'name_short' => 'Mirkwood');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 34, 'language' => 'it', 'attribute' => 'race', 'name' => 'Rivendell Elf',         'name_short' => 'Rivendell');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'it', 'attribute' => 'race', 'name' => 'Dwarf',                 'name_short' => 'Dwarf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 41, 'language' => 'it', 'attribute' => 'race', 'name' => 'Blue Mountains Dwarf',  'name_short' => 'Blue Mountains');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 42, 'language' => 'it', 'attribute' => 'race', 'name' => 'Grey Mountain Dwarf',   'name_short' => 'Grey Mountains');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 43, 'language' => 'it', 'attribute' => 'race', 'name' => 'Iron Hill Dwarf',       'name_short' => 'Iron Hills');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 44, 'language' => 'it', 'attribute' => 'race', 'name' => 'Lonely Mountain Dwarf', 'name_short' => 'Lonely Montain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 45, 'language' => 'it', 'attribute' => 'race', 'name' => 'White Mountain Dwarf',  'name_short' => 'White Mountain');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'it', 'attribute' => 'race', 'name' => 'Beorning',              'name_short' => 'Beorning');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'it', 'attribute' => 'race', 'name' => 'High Elf',              'name_short' => 'High Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'it', 'attribute' => 'race', 'name' => 'Stout-axe Dwarf',       'name_short' => 'Stout-axe');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 50, 'language' => 'it', 'attribute' => 'race', 'name' => 'Servant of the Eye',    'name_short' => 'Servant of the Eye');

		$this->db->sql_multi_insert($this->table('bb_language_table'), $sql_ary);
	}

	/**
	 * Installs LOTRO class trait line specializations (issue #6).
	 *
	 * Skipped if bb_specializations_table isn't wired in (older core
	 * installs that haven't run migration v200b4 yet).
	 */
	protected function install_specs(): void
	{
		if (!isset($this->table_names['bb_specializations_table']))
		{
			return;
		}

		$rows = [];
		foreach (lotro_provider::spec_catalog() as $class_id => $specs)
		{
			foreach ($specs as $spec)
			{
				$rows[] = [
					'game_id'    => $this->game_id,
					'class_id'   => (int) $class_id,
					'role_id'    => (int) $spec['role_id'],
					'spec_name'  => (string) $spec['spec_name'],
					'spec_icon'  => (string) $spec['spec_icon'],
					'spec_order' => (int) $spec['spec_order'],
				];
			}
		}
		if (!$rows)
		{
			return;
		}
		$this->db->sql_multi_insert($this->table('bb_specializations_table'), $rows);
	}
}
