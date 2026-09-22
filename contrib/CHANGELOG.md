# Changelog

## Unreleased
  - [NEW] Game data audit (#7): added the Brawler (class_id 11, Fate of Gundabad, Nov 2021) and Mariner (class_id 12, Corsairs of Umbar, Oct 2023) classes, and the River Hobbit race (race_id 24, Update 37, Aug 2023) — all three were missing from the seeded class/race data entirely, verified against current live LOTRO. Full en/de/fr/it translations added for all three (de/fr/it are descriptive translations, not verified against LOTRO's actual in-game localization strings for this very recent content). README class/race tables and counts updated to match (18 classes, 25 races) — the Free Peoples table was also missing Beorning (class_id 10) even before this fix, now included. **Known follow-up gaps, not fixed here:** no icon assets exist yet for these three (`lotro_brawler`/`lotro_mariner`/`lotro_hobbit_river` — flagged on #3, the existing icon-asset tracking issue) and Brawler/Mariner have no trait-line specializations seeded in `lotro_provider::spec_catalog()` (#6's scope, not #7's).

## 2.0.0-rc2 26/07/2026
  - [CHG] Require bbGuild core >= 2.0.0-rc5 — aligns this plugin with the rc2 game-plugin set; earlier core releases can no longer install it

## 2.0.0-rc1 24/07/2026
  - [FIX] Migration dependency pointed at a since-removed bbguild core migration path (`basics\schema`, squashed into `v200b3` in an earlier core release) — this plugin could not install at all against current core
  - [FIX] `get_table_names()` was missing `bb_specializations_table`, which would have silently blocked any future specialization seeding (issue #331 Phase 4)
  - [FIX] `license.txt` file mode corrected to 644
  - [FIX] Stripped ICC color profiles from 21 PNG icons (EPV compliance)
  - [CHG] Namespace/composer/repo dropped to no-separator form (`bbguildlotro`); DB-stored config keys (`bbguild_lotro_version`) preserved with the original underscore form
  - [CHG] Version tracking moved out of `phpbb_config` into `ext::BBGUILDLOTRO_VERSION`
  - [CHG] Soft-requires `avathar/bbguild >= 2.0.0-rc3`
  - [CHG] Provider return types use FQCN; removed unused `use` statements
  - [CHG] CI: unit tests now check out bbguild core alongside so plugin classes resolve core interfaces
  - [DOCS] README: fixed wrong GitHub org (bbGuild Core / Issue Tracker links pointed at `avandenberghe/bbguild` instead of `avatharbe/bbguildlotro`), stale PHP >= 7.4.0 requirement (actual has been 8.1.0), stale race count — installer actually has 24 race variants (Beorning, High Elf, Stout-axe Dwarf were undocumented)

## 2.0.0-a1 02/03/2026
  - [NEW] Initial release as standalone phpBB extension
  - [NEW] Extracted from bbGuild core as part of the game plugin architecture
  - [NEW] Implements `game_provider_interface` — registers LOTRO with bbGuild via tagged services
  - [NEW] `lotro_installer` extends `abstract_game_install` with clean array-based table names
  - [NEW] `lotro_provider` supplies game metadata (factions, Allakhazam URLs)
  - [NEW] Game images served from plugin directory
  - [CHG] Installer uses `$this->table()` helper instead of direct property access
