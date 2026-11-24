# Mininext

1. [Configuration](#1-configuration)
2. [Integration](#2-integration)
3. [Templates](#3-templates)

![Mininext screenshot](./assets/media/mininext.png)

The Mininext script shows the upcoming match of a team in a compact block that is easy to include in any existing page. In addition, earlier meetings of the teams involved are shown from the archive in descending order by date.

---

## 1. Configuration

The Mininext add-on is configured via the LMO's add-on management. Additional parameters can be passed for each individual inclusion.

### Add-on management

In the add-on management click the item **mini**. The following basic parameters can be controlled:

| Parameter | Meaning |
|---|---|
| `mininext_withArchiv` | Archive search on/off |
| `mininext_unGreedy` | Fuzzy search on/off; merges similar-sounding team names |
| `mininext_barWidth` | Width of the bar for W/D/L |
| `mininext_standardTemplate` | Default template if none is passed |

### Parameters

Via URL (iframe) or as include variables you can pass the following values:

| Parameter | Meaning |
|---|---|
| `file` | File name of the league, e.g. `bundesliga.l98` |
| `folder` | Archive folder for searching earlier matches. Tip: create a separate subfolder per league instead of putting everything directly into the archive folder. |
| `a` | Number of team A. Only needed if no favourite team is set in the league file. |
| `b` | Number of the opponent. Not needed for the next match, only if a specific pairing should be shown. |
| `mininext_template` | Template to use. If omitted: default template. |

---

## 2. Integration

There are two ways. The first is preferable; the second is only meant for servers without PHP support or `.html` files.

### Including via include

Set the parameters directly as PHP variables, *inside a PHP block* (open it with `<?php` if necessary):

```php
$file="liga1.l98";
$folder="archiv/First_Team";
```

Note the `$` before the name, the quotation marks around strings and the semicolon at the end. Only the league name is mandatory. Then include the add-on:

```php
include("PathToLMO/addon/mini/lmo-mininext.php");
```

`PathToLMO` is the absolute or relative path to the LMO directory.

> **Attention:** Never use a URL, no `include("http://www.../lmo-mininext.php");`! Always specify a **file path**.

> **Note:** If you do not use sessions on your page, add `<?php session_start(); ?>` as the very first line of the file.

### Including via iframe

Only if the include method does not work. The parameters are part of the source URL:

```html
<iframe src="URLToLMO/addon/mini/lmo-mininext.php?file=liga1.l98&folder=archiv/First_Team"
  style="border:0" width="width" height="height" scrolling="no"></iframe>
```

`URLToLMO` is the web address of your LMO. For `width` and `height` you have to experiment. The first parameter is separated with `?`, further ones with `&`.

---

## 3. Templates

As with the LMO, you can adapt the structure and design of Mininext. The templates are in the subdirectory `mini` of the folder `template`. The default is `mininext.tpl.php` (changeable in the add-on management). You can create any number of templates (extension `.tpl.php`).

### The upcoming game

| Placeholder | Meaning |
|---|---|
| `<!--gameTxt-->` | Heading |
| `<!--gameDate-->` | Date of the upcoming game |
| `<!--gameTime-->` | Time of the upcoming game |
| `<!--countDown-->` | Countdown to the next match |
| `<!--homeName-->` | Name of the home team |
| `<!--homeNameMiddle-->` | Medium-length name of the home team |
| `<!--homeNameShort-->` | Short name of the home team |
| `<!--homeTore-->` | Goals of the home team (since LMO 4.0.2) |
| `<!--imgHomeBig-->` | Large icon of the home team |
| `<!--imgHomeSmall-->` | Small icon of the home team |
| `<!--guestName-->` | Name of the away team |
| `<!--guestNameMiddle-->` | Medium-length name of the away team |
| `<!--guestNameShort-->` | Short name of the away team |
| `<!--guestTore-->` | Goals of the away team (since LMO 4.0.2) |
| `<!--imgGuestBig-->` | Large icon of the away team |
| `<!--imgGuestSmall-->` | Small icon of the away team |
| `<!--gameNote-->` | Game note |
| `<!--ligaDatum-->` | Date of the last change in the league |
| `<!--copy-->` | Copyright notice, **must not be changed or removed!** |

### Previous meetings

**Outside of `<!-- BEGIN/END matches -->`:**

| Placeholder | Meaning |
|---|---|
| `<!--matchesText-->` | Heading for previous games |
| `<!--winCount-->` / `<!--drawCount-->` / `<!--lostCount-->` | Number of home wins / draws / away wins |
| `<!--winTxt-->` / `<!--drawTxt-->` / `<!--lostTxt-->` | Labels for wins/draws/defeats (e.g. W, D, L) |
| `<!--winWidth-->` / `<!--drawWidth-->` / `<!--lostWidth-->` | Bar width for wins/draws/defeats |
| `<!-- BEGIN matches -->` | Start of the repeated block. **Note the spaces before BEGIN and after matches!** |
| `<!-- END matches -->` | End of the repeated block. **Note the spaces before END and after matches!** |

**Only inside `<!-- BEGIN/END matches -->`:**

| Placeholder | Meaning |
|---|---|
| `<!--class-->` | Colour highlighting of the match |
| `<!--date-->` | Date of the match |
| `<!--time-->` | Time of the match |
| `<!--hTore-->` | Home goals |
| `<!--gTore-->` | Away goals |
| `<!--where-->` | Home or away game |
| `<!--matchingName-->` | With fuzzy search active: the team name found |

### The previous game

| Placeholder | Meaning |
|---|---|
| `<!--previous_gameTxt-->` | Heading |
| `<!--previous_gameDate-->` | Date of the previous game |
| `<!--previous_gameTime-->` | Time of the previous game |
| `<!--previous_homeName-->` | Name of the home team |
| `<!--previous_homeNameMiddle-->` | Medium-length name of the home team |
| `<!--previous_homeNameShort-->` | Short name of the home team |
| `<!--previous_imgHomeBig-->` | Large icon of the home team |
| `<!--previous_imgHomeSmall-->` | Small icon of the home team |
| `<!--previous_guestName-->` | Name of the away team |
| `<!--previous_guestNameMiddle-->` | Medium-length name of the away team |
| `<!--previous_guestNameShort-->` | Short name of the away team |
| `<!--previous_imgGuestBig-->` | Large icon of the away team |
| `<!--previous_imgGuestSmall-->` | Small icon of the away team |

Adapt the HTML code freely, but make sure it is correct HTML/CSS.
