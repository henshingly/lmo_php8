# Mini tables

1. [Control parameters](#1-control-parameters)
2. [Integration](#2-integration)
3. [Templates](#3-templates)

![User view](./assets/media/minitabs01.png)

The LMO makes it possible to show tables or table excerpts on external pages. For example, you can include a compact version of the current table on your start page. Which details are shown and what the table looks like can be freely designed via [templates](#3-templates).

---

## 1. Control parameters

As with the ticker, the mini tables have various control parameters.

| Parameter | Meaning |
|---|---|
| `mini_liga` | File name of the league (with the `.l98` extension) |
| `mini_platz` | Around which table position should the excerpt be centred? Leave empty for the favourite team. |
| `mini_ueber` | How many teams above the selected one to show? |
| `mini_unter` | How many teams below the selected one to show? |
| `mini_template` | Name of the template (without file extension). If omitted, `standard` is used. |

---

## 2. Integration

There are two ways to include mini tables. The first is preferable; the second is only meant for servers without PHP support or `.html` files.

### Including via include

The parameters are set directly as PHP variables, *inside a PHP block* (open it with `<?php` if necessary):

```php
$mini_liga="liga1.l98";
$mini_ueber=3;          // 3 teams above the favourite team
$mini_unter=2;          // 2 teams below the favourite team
$mini_template="all";   // use template "all.tpl.php"
```

Note the `$` before the parameter name, the quotation marks around strings and the closing semicolon. Only the league name is mandatory. Then include the mini table:

```php
include("PathToLMO/addon/mini/lmo-minitab.php");
```

`PathToLMO` is the absolute or relative path to the LMO directory.

> **Attention:** Never use a URL, no `include("http://www.../minitab.php");`, because that does not work! Always specify a **file path**.

### Including via iframe

Only if the include method does not work. Iframes have drawbacks (browser compatibility, usability). The parameters are part of the source URL:

```html
<iframe src="URLToLMO/addon/mini/lmo-minitab.php?mini_liga=liga1.l98&mini_ueber=3&mini_unter=2&mini_template=all"
  style="border:0" width="width" height="height" scrolling="no"></iframe>
```

`URLToLMO` is the web address of your LMO. For `width` and `height` you have to experiment. The first parameter is separated with `?`, further ones with `&`.

---

## 3. Templates

As with the LMO itself, you can freely adapt the structure and design of the mini tables. The templates are in the subdirectory `mini` of the folder `template`. Without control parameters `standard.tpl.php` is used. You can create any number of templates (extension `.tpl.php`).

The following placeholders are available:

| Placeholder | Meaning |
|---|---|
| `<!--Link-->` | Link to the full table in the LMO |
| `<!-- BEGIN Inhalt -->` | Start of the block repeated for each team. **Note the spaces before BEGIN and after Inhalt!** |
| `<!-- END Inhalt -->` | End of the repeated block. **Note the spaces before END and after Inhalt!** |
| `<!--Style-->` | Activates the highlighting of champion, relegated teams etc. according to the league setting |
| `<!--Team-->` | Short name of the team |
| `<!--TeamLang-->` | Full name of the team |
| `<!--TeamMittel-->` | Medium-length name of the team |
| `<!--TeamBild-->` | Team icon (if available) |
| `<!--Teamnotiz-->` | Note of the team |
| `<!--Spiele-->` | Number of games |
| `<!--Punkte-->` | Points; with negative points in the form **+P:-P** |
| `<!--PlusTore-->` | Goals scored |
| `<!--MinusTore-->` | Goals conceded |
| `<!--Tordifferenz-->` | Goal difference |
| `<!--Siege-->` | Number of wins |
| `<!--Unentschieden-->` | Number of draws |
| `<!--Niederlagen-->` | Number of defeats |

Adapt the HTML code as you like, but make sure it is correct HTML/CSS. In the template `all.tpl.php` you find all placeholders as an example.
