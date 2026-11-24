# Team schedule

1. [System requirements](#1-system-requirements)
2. [Configuration](#2-configuration)
3. [Integration](#3-integration)
4. [Download](#4-download)
5. [Version history](#5-version-history)

![Team schedule view](./assets/media/teampl01.png)

The add-on makes it possible to output the schedule of a selected team as a PDF document, directly via the "Schedules" link in the LMO.

---

## 1. System requirements

- A working LMO 4
- Installed Classlib add-on by Tim Schumacher (available in the add-on archive), including the PDF class by [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (contained in the Classlib)

---

## 2. Configuration

The Team schedule add-on is configured via the LMO's add-on management.

### Add-on management

In the add-on management click the item **pdf**. The following parameters are available:

| Parameter | Description |
|---|---|
| `linktarget` | Opens the PDF in a new window (e.g. `_blank`) |
| `show_adobe_link` | Hint to the PDF reader with image: **0** = off / **1** = on |
| `homepage` | Shows a text in the margin, e.g. your homepage address |
| `anzeige` | Sorting by match day / date: **0** / **1** |
| `format` | Output format A4 landscape / portrait: **0** / **1** |
| `teamfett` | Highlight the selected team: **0** = off / **1** = on |
| `teamnamen` | Team name long / short / medium: **0** / **1** / **2** |
| `serie` | First/second leg on 1 page / 2 pages: **0** / **1** |

---

## 3. Integration

### Including it in the LMO

> Set the access rights (chmod):
> **Files:** `666` for all `cfg.txt` files in the directory `config` and its subdirectories

Open the file `lmo-showprogram.php` and insert the following code below the last line (`} ?>`):

```php
<?
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>
```

After installation the new link **Schedule as PDF document** appears below the "Schedules" selection window.

> **Note:** The copyright notice with version information must **not** be changed or removed!

---

## 4. Download

- [Team schedule](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?t=5489)

---

## 5. Version history

**1.0**

- Schedule output in PDF format

**2.0**

- Sorting of the output
- Highlighting of the selected team
- Team name and format selectable
- Separate output for first and second leg
