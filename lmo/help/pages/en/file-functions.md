# File Functions

1. [Deleting a league](#1-deleting-a-league)
2. [Uploading a league](#2-uploading-a-league)
3. [Download/E-mail a league](#3-download-e-mail-a-league)

---

## 1. Deleting a league

If a league is outdated or you want to replace it with a backup copy, choose **Delete** in the menu and click the league in the list. After a confirmation prompt it is **permanently deleted**. So be careful.

---

## 2. Uploading a league

With **Upload** you transfer a league from your hard disk directly into your league directory. Choose a league (`*.l98`) via **Browse …** and start with **Start upload** (click only once). Existing leagues are not overwritten: if the file name already exists, a number is added, so `liga.l98` becomes `liga_1.l98`.

---

## 3. Download/E-mail a league

For a backup, offline editing or to pass a league on, choose **Download**. The screen shows the league list twice:

- **Left:** A click downloads the league to your hard disk. With **Download all leagues at once** you get a ZIP file with all listed leagues.
- **Right:** A click opens an input window for the recipient's e-mail address. The league (or all of them) is packed into a ZIP file and sent by e-mail. The sender is the sender address set in the options or the webmaster's e-mail. The sending method is the one set there (PHP `mail()` or SMTP, see [E-mail sending](#options/e-mail-sending-smtp)).
