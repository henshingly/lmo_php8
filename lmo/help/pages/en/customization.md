# Customizing the LMO

1. [Team icons](#1-team-icons)
2. [Custom CSS](#2-custom-css)
3. [Templates](#3-templates)
4. [Integrating the LMO into existing homepages](#4-integrating-the-lmo-into-existing-homepages)

Besides the [design editor](#options/3-the-design-editor) you can adapt the LMO via team icons, your own CSS and a simple template system.

---

## 1. Team icons

Small club crests make the LMO look better. The LMO finds the files automatically:

- Copy the icons into `img/teams/small/`.
- The file name must match the team name (including dots or spaces). Only the character `/` is not allowed; simply leave it out of the file name.
- Some add-ons show enlarged icons. Put these into `img/teams/big/`.
- Allowed formats are PNG, GIF and JPG.

> **Apache 2:** Remove all special characters from the file names; only letters and digits are allowed.

---

## 2. Custom CSS

If the settings of the design editor are not enough, edit the file `template/style.css`. It is loaded automatically and overrides the design editor. Edit it with a text editor and, if needed, check it with the [W3C CSS validator](https://jigsaw.w3.org/css-validator/).

---

## 3. Templates

A template is an HTML file supplemented with HTML comments of the form `<!--Name-->`. The LMO replaces each comment with the corresponding part of its output. The position of the comments decides where something appears. If you leave a comment out, that part is omitted. You can also use several templates for the same LMO.

The templates are in the folder `template/` (`lmo-standard-komplett.tpl.php` and `lmo-standard.tpl.php`). There are further templates for add-ons, e.g. in `template/mini/` and `template/viewer/`.

| Comment | Content |
|---|---|
| `<!--Titel-->` | Title text of the LMO |
| `<!--Stylesheet-->` | The stylesheet |
| `<!--Newsticker-->` | The integrated news ticker |
| `<!--Kalender-->` | Navigation link to the calendar |
| `<!--Ergebnisse-->` | Navigation link to the results |
| `<!--Tabelle-->` | Navigation link to the table |
| `<!--Spielplan-->` | Navigation link to the schedule |
| `<!--Kreuztabelle-->` | Navigation link to the cross table |
| `<!--Fieberkurve-->` | Navigation link to the form curve |
| `<!--Ligastatistik-->` | Navigation link to the league statistics |
| `<!--Spielerstatistik-->` | Navigation link to the player statistics |
| `<!--Tippspiel-->` | Navigation link to the betting game |
| `<!--Info-->` | Navigation link to the info page, **please do not remove** |
| `<!--Hauptteil-->` | Main part of the LMO |
| `<!--Savehtml-->` | Links for the print versions below results or table |
| `<!--Sprachauswahl-->` | Language selection |
| `<!--Ligenuebersicht-->` | Link to the league overview |
| `<!--LetzteAuswertung-->` | Date of the last evaluation of the chosen league |
| `<!--Berechnungszeit-->` | Calculation time |
| `<!--Infolink-->` | Copyright notice, **must not be removed** (see [Legal notice](#getting-started/7-legal-notice)) |

Make sure that valid HTML is produced. You can check this with the [W3C HTML validator](https://validator.w3.org/).

Depending on how you integrate the LMO, you need one of two templates: a **complete HTML document** for direct calls, or a template with **only the HTML part** for inclusion via `include`.

---

## 4. Integrating the LMO into existing homepages

You can call the LMO directly or include it in your pages via `include`.

### Direct call

Call the LMO via `lmo.php`. Which template is used is set in this file. The default is `lmo-standard-komplett.tpl.php`, a complete HTML document.

The direct call is also suitable for an **iframe**:

```html
<iframe src="URL-to-LMO/lmo.php" width="width" height="height" style="border:0"></iframe>
```

You unfortunately have to experiment with width and height; that is one of the drawbacks of iframes.

With parameters in the URL you start directly in a certain view, e.g. `lmo.php?file=liga.l98` to start with a league.

For a second template, copy `lmo.php`, rename it (e.g. `lmoneu.php`) and change the template call in it. You then reach the "new" LMO under `lmoneu.php`.

### Include

More convenient is inclusion via `include` in an existing PHP page:

```php
<?php include("PathToLMO/lmo.php"); ?>
```

Please note the following:

- **`PathToLMO` is a file path, not a URL.** `include("http://www.mysite.com/lmo/lmo.php");` does not work.
- A league that should open immediately instead of the league overview is given **before** the include: `$file = "NameOfLeague.l98";`
- By default `lmo-standard.tpl.php` (without "komplett") is loaded. It is not a complete HTML document; the other parts come from your page.
- At the very top of your page (the very first line) this must appear:

  ```php
  <?php if (session_id() == "") session_start(); ?>
  ```

- If your page does not use `<!DOCTYPE html>` yet, add it. Also specify the character set in the `<head>`: `<meta charset="utf-8">`
- Include the LMO stylesheet in the `<head>`:

  ```html
  <link rel="stylesheet" href="PathToLMO/lmo-style-nc.php">
  <style>@import url('PathToLMO/lmo-style.php');</style>
  ```

You can use several templates with the same method.
