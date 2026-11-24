# Viewer

1. [Templates](#1-templates)

![User view](./assets/media/viewer01.png)

The Viewer is an add-on for LMO 4. It shows the matches of any and any number of teams for the previous/next XX days from the current date, across leagues. Although it is mostly configured in the admin area, the Viewer is a standalone script that you can include anywhere on your website. Via [templates](#1-templates) the output can be designed freely.

---

## 1. Templates

As with the LMO, you can freely adapt the structure and design of the Viewer. The templates are in the directory `template/viewer`, where you also find examples.

### Global variables

| Placeholder | Meaning |
|---|---|
| `<!--Titelzeile-->` | Configured title line |
| `<!--VERSION-->` | Copyright notice with version information, **must not be changed or removed!** |

### League block

| Placeholder | Meaning |
|---|---|
| `<!-- BEGIN Liga -->` / `<!-- END Liga -->` | Content block of a league. **Note the spaces before BEGIN and after Liga!** |

The following placeholders only make sense inside `<!-- BEGIN/END Liga -->`:

| Placeholder | Meaning |
|---|---|
| `<!--Ligadatum-->` | Save date of the league |
| `<!--Liganame-->` | Name of the league |
| `<!--ErgebnisLink-->` | Link to the league's results overview |
| `<!--Anfangsspieltag-->` / `<!--Endespieltag-->` | First and last match day output (only with match-day-based display) |
| `<!--Spieltageminus-->` / `<!--Spieltageplus-->` | Number of match days output backwards/forwards (only with match-day-based display) |
| `<!--Anfangsdatum-->` / `<!--Enddatum-->` | Number of days output backwards/forwards (only with date-based display) |

### Match day block

| Placeholder | Meaning |
|---|---|
| `<!-- BEGIN Spieltag -->` / `<!-- END Spieltag -->` | Content block of a single match day (only with match-day-based display). **Note the spaces before BEGIN and after Spieltag!** |

The following placeholders only make sense inside `<!-- BEGIN/END Spieltag -->`:

| Placeholder | Meaning |
|---|---|
| `<!--AktSpieltag-->` | This match day |
| `<!--AktSpieltagLink-->` | Link to the results overview of this match day |

### Content block (game)

| Placeholder | Meaning |
|---|---|
| `<!-- BEGIN Inhalt -->` / `<!-- END Inhalt -->` | Content block of a single game. **Note the spaces before BEGIN and after Inhalt!** |

The following placeholders only make sense inside `<!-- BEGIN/END Inhalt -->`:

| Placeholder | Meaning |
|---|---|
| `<!--Heim-->` / `<!--Gast-->` | Team names in the configured length |
| `<!--HeimLang-->` / `<!--GastLang-->` | Long team name |
| `<!--HeimMittel-->` / `<!--GastMittel-->` | Medium-length team name |
| `<!--HeimKurz-->` / `<!--GastKurz-->` | Short team name |
| `<!--ToreHeim-->` / `<!--ToreGast-->` | Goals of the teams (separately) |
| `<!--Tore-->` | Game result as `x:y` |
| `<!--Datum-->` | Game date |
| `<!--Uhrzeit-->` | Kick-off time |
| `<!--Spieltag-->` | Match day of the game |
| `<!--Iconheim-->` / `<!--Icongast-->` | Team icons (small) |
| `<!--IconMiddleheim-->` / `<!--IconMiddlegast-->` | Team icons (medium) |
| `<!--IconBigheim-->` / `<!--IconBiggast-->` | Team icons (large) |
| `<!--IconBigheimalt-->` / `<!--IconBiggastalt-->` | Team icons (large, alternative) |
| `<!--Notiz-->` | Game note |
| `<!--Tabellenlink-->` | Link to the table |
| `<!--Spieltaglink-->` | Link to the results view of the match day |
| `<!--Spielbericht-->` | Link to the match report |
| `<!--Zeilenklasse-->` | Highlighting of today's date (`vRow` normal, `vRowHighlight` today) |
| `<!--Ligadatum-->` | Save date of the league |
| `<!--Liganame-->` | Name of the league |
