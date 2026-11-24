# TopTipper

1. [System requirements](#1-system-requirements)
2. [Files explained](#2-files-explained)
3. [Download](#3-download)

![TopTipper view](./assets/media/toptipper.png)

The TopTipper add-on shows the current standings of the betting game in a compact and clear way.

---

## 1. System requirements

- A working LMO 4 from Beta 3 with the betting game activated

---

## 2. Files explained

The download contains 4 files.

**`toptipper.php`**
Located in the folder `addon/tipp/`.

**`kal.tip`**
Located in the folder `config/tipp/`. This is the configuration file. You can rename it as long as the extension `*.tip` is kept and the new name is taken into account when including it.

Content of the file:

```
[config]
modus=1              // leave mode at 1, may still be useful
anzahl_tipper=10     // number of tippers in the display
all=0                // 0 or 1: 0 shows the file, 1 overall
file=erg_dfb.l98     // your league
template=standard    // template name without the extension *.tpl.php
```

**`standard.tpl.php`**
Located in the folder `template/tipp/`. You can design the template freely. Available placeholders:

| Placeholder | Meaning |
|---|---|
| `<!--Link-->` | Link to the betting game |
| `<!--Lmo-->` | Link to the LMO |
| `<!--Platz-->` | Position of the tippers |
| `<!--Name-->` | Name of the tippers |
| `<!--Punkte-->` | Points of the tippers |

**`tipp.php`**
Located directly in the root directory of your LMO. It serves to include the script; adapt the content accordingly.

Example:

```php
<?php
$multi="kal";  // Your adapted file kal.tip is included.
require(dirname(__FILE__) . '/init.php');
include(PATH_TO_ADDONDIR . "/tipp/toptipper.php");
?>
```

---

## 3. Download

- [TopTipper](https://www.liga-manager-online.org/forum/viewtopic.php?t=94)

> Detailed installation instructions are included with every version.
