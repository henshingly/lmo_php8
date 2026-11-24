# Player statistics

1. [Configuration](#1-configuration)

![User view](./assets/media/spielerstatistik01.png)

With this add-on you can record and publish player statistics for the Liga Manager Online. The flexible configuration makes it usable for many different sports.

You can create three kinds of columns: **text**, **numbers** and **formulas**. Unfortunately the order of the columns cannot be changed afterwards, so think carefully before you start. After creating the players, the line-up appears below, where you enter the matching values for each player. In formula columns you can calculate with the number columns (e.g. average goals).

**Including player photos**
Photos belong in the directory `img/spieler/small/`, named after the respective player. Pay attention to a sensible file size.

**Including player links**
To link players, create a column **"Player link"** (or the equivalent from `lang/lmo-[language].txt`) in the admin area. A link can be stored for each player; if it is missing, nothing is linked.

**Including column graphics**
Instead of text headings you can also use icons for columns. To do so, save a **GIF** image named after the column in the directory `img/spieler/`. Examples are already included.

**Statistics of several clubs with crests**
If you use **"Club"** (or the equivalent from `lmo-[language].txt`) as a column heading, club support is activated: dropdown selection, club crests (if available) and links to club homepages.

---

## 1. Configuration

### Visitor view

| Setting | Meaning |
|---|---|
| Display per page | Number of entries shown; `0` = no limit |
| Pre-sorting | Column by which to sort first |
| Sorting | Order of the pre-sorting |
| Extra sort column | Shows a separate sort column; otherwise sorting is done via the table heads |
| Display by club | Activates the split by clubs |
| Show zero values | Also shows empty fields; strings are always shown |

### Admin view

| Setting | Meaning |
|---|---|
| Pre-sorting admin | Column by which to sort first |
| Helper admin | Gives helper admins access to the player statistics |
| Helper admin (columns) | Also gives helper admins access to the column management |
