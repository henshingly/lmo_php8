# JSON API and league view

1. [Overview](#1-overview)
2. [JSON API](#2-json-api)
3. [League view](#3-league-view)

The API extension makes the data of your leagues usable for other sites and programs: as a (read-only) **JSON interface** and as a ready-made, **server-rendered league view** with switchable designs. Both use the same calculation logic as the regular LMO interface; there is no second, separately maintained calculation.

> **Note:** The API extension is not part of the LMO package but a **separate download**. Unpack it into your LMO directory (it creates `addon/api/` and `template/api/`).

---

## 1. Overview

| File | Purpose |
|---|---|
| `addon/api/lmo-api.php` | JSON interface (read-only) |
| `addon/api/init-api.php` | Lightweight initialisation of the interface (no session) |
| `template/api/lmo-liga.php` | Complete league view in one file, with designs (themes) |
| `template/api/themes/` | Designs `karten` and `stadium` |

---

## 2. JSON API

Call: `addon/api/lmo-api.php?file=XXX.l98&resource=...`

The interface is **read-only**, needs no login, sets no cookies and allows requests from other domains (CORS). Responses are cached for 60 seconds.

| Parameter | Meaning |
|---|---|
| `file` | File name of the league with extension `.l98` (required, no sub-folders) |
| `resource` | Requested resource (see below), default `info` |
| `st` | Match day, only for `results` |
| `team` | Team number as a filter, only for `program` |
| `team1`, `team2` | Team numbers, only for `h2h` |
| `lang` | Language, e.g. `Englisch` (name of the LMO language file); otherwise the default language |

| Resource | Content |
|---|---|
| `info` | League metadata |
| `table` | Table (incl. sport-specific extra fields) |
| `results` | Results of a match day |
| `program` | Schedule, optionally for one team |
| `cross` | Cross table (all pairings as a matrix) |
| `graph` | Table position history per match day (form curve) |
| `h2h` | Head-to-head of two teams |

Example:

```
addon/api/lmo-api.php?file=1l_2024-25.l98&resource=table
```

---

## 3. League view

Call: `template/api/lmo-liga.php?file=XXX.l98&view=...&theme=...`

**Live example:** [https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php](https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php)

This file replaces the individual HTML pages and renders the view directly on the server. The league may be in a sub-folder (e.g. `file=dfb/04er-liga.l98`). Without `file` it shows a clickable selection of all leagues and sub-folders.

| Parameter | Meaning |
|---|---|
| `file` | League, optionally with sub-folder |
| `dir` | Sub-folder whose leagues should be listed |
| `view` | `uebersicht` (default), `tabelle`, `ergebnisse`, `spielplan`, `kreuztabelle`, `fieberkurve`, `direkte-duelle` |
| `theme` | Design: `karten` or `stadium` |
| `st`, `team`, `team1`, `team2` | as in the JSON API |
| `lang` | Language |

**Your own design:** Create a new folder in `template/api/themes/` with a `theme.php` (structure like `stadium/theme.php`, whose header lists the available variables). Optionally a `meta.php` provides the display name for the design switcher.
