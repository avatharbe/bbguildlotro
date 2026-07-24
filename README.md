# bbGuild - Lord of the Rings Online
[![Tests](https://github.com/avatharbe/bbguildlotro/actions/workflows/tests.yml/badge.svg)](https://github.com/avatharbe/bbguildlotro/actions/workflows/tests.yml)

Game plugin that adds Lord of the Rings Online support to [bbGuild](https://github.com/avatharbe/bbguild).

## Features

- **LOTRO Classes** - 16 classes including Free Peoples (Burglar, Captain, Champion, Guardian, Hunter, Lore-master, Minstrel, Rune-keeper, Warden) and Monster Play (Reaver, Defiler, Weaver, BlackArrow, Warleader, Stalker) with color codes
- **LOTRO Races** - 24 race variants across Man, Hobbit, Elf, Dwarf, Beorning, and Monster factions with sub-race specializations (e.g. Man of Gondor, Lorien Elf, Iron Hill Dwarf)
- **Factions** - Free Peoples and Servants of the Eye
- **Localization** - Class and race names in English, German, French, and Italian
- **Allakhazam Links** - Boss and zone database URLs linked to LOTRO Allakhazam

## Requirements

- phpBB >= 3.3.0
- PHP >= 8.1.0
- **bbGuild core** (`avathar/bbguild`) must be installed and enabled

## Installation

1. Ensure bbGuild core (`avathar/bbguild`) is installed and enabled.
2. Copy the `bbguildlotro` folder to `/ext/avathar/bbguildlotro/`.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `bbGuild - LOTRO` under Disabled Extensions and click `Enable`.
5. Go to ACP > bbGuild > Games and install the **Lord of the Rings Online** game.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Find `bbGuild - LOTRO` under Enabled Extensions and click `Disable`.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/avathar/bbguildlotro` folder.

**Note:** Disabling the extension does not delete existing guild or player data. Your roster and player records remain intact in bbGuild core.

## Game Data

### Factions

| ID | Faction |
|----|---------|
| 1 | Free Peoples |
| 2 | Servants of the Eye |

### Free Peoples Classes (10)

| ID | Class | Armor |
|----|-------|-------|
| 0 | Unknown | Mail |
| 1 | Burglar | Mail |
| 2 | Captain | Plate |
| 3 | Champion | Plate |
| 4 | Guardian | Plate |
| 5 | Hunter | Mail |
| 6 | Lore-master | Cloth |
| 7 | Minstrel | Cloth |
| 8 | Rune-keeper | Cloth |
| 9 | Warden | Mail |

### Monster Play Classes (6)

| ID | Class | Armor |
|----|-------|-------|
| 20 | Reaver | Mail |
| 21 | Defiler | Cloth |
| 22 | Weaver | Cloth |
| 23 | BlackArrow | Mail |
| 24 | Warleader | Plate |
| 25 | Stalker | Mail |

### Races (24)

**Man:** Man, Man of Dalelands, Man of Gondor, Man of Rohan
**Hobbit:** Hobbit, Fallohide Hobbit, Harfoot Hobbit, Stoor Hobbit
**Elf:** Elf, Nandor Elf, Lorien Elf, Mirkwood Elf, Rivendell Elf, High Elf
**Dwarf:** Dwarf, Blue Mountains Dwarf, Grey Mountain Dwarf, Iron Hill Dwarf, Lonely Mountain Dwarf, White Mountain Dwarf, Stout-axe Dwarf
**Beorning:** Beorning
**Monster:** Servant of the Eye

## License

[GNU General Public License v2](http://opensource.org/licenses/gpl-2.0.php)

## Links

- [bbGuild Core](https://github.com/avatharbe/bbguild)
- [LOTRO Allakhazam](http://lotro.allakhazam.com/)
- [Issue Tracker](https://github.com/avatharbe/bbguildlotro/issues)
