# Betting game (Tippspiel)

1. [Evaluation](#1-evaluation)
2. [Newsletter/Reminder](#2-newsletter-reminder)
3. [User management](#3-user-management)
4. [Entering tips retroactively](#4-entering-tips-retroactively)
5. [Backup manager](#5-backup-manager)
6. [Options](#6-options)

![Tip overview](./assets/media/tippspiel01.png)

The LMO 4 includes a comprehensive and flexible betting game, based on the betting game add-on for LMO 3 by Frank Albrecht.

---

## 1. Evaluation

Here you evaluate the leagues that can be tipped, i.e. every tipper is credited with the points he or she has earned. You can evaluate each league and each match day individually or all match days of a league at once.

If several leagues are tipped, you can also update the **overall ranking** here.

Here you also create and update the **tip overviews**, which let your players see how the others tipped. Depending on the [setting in the options](#6-options), the overview is only released after the match day has ended.

---

## 2. Newsletter/Reminder

Here you can send your tippers various messages: a **newsletter to everyone**, **personal mails** to individual players or a **tip reminder** that reminds them to submit their tips.

All mails of the betting game (including registration confirmation, activation and password mail) are sent with the sending method you set in the [global options](#options/e-mail-sending-smtp) (PHP `mail()` or SMTP). If mails do not arrive, set up an SMTP server there and check it with the test mail.

The following placeholders are available when sending mail:

| Placeholder | Meaning |
|---|---|
| `[nick]` | Nickname of the tipper |
| `[pass]` | Link to reset the password. Passwords are stored only as a hash and cannot be sent in plain text. The tipper sets a new password via the link. |
| `[name]` | Real name of the tipper |
| `[spiele]` | Only in the tip reminder: lists all open games in the given period |

---

## 3. User management

Here you manage the participants of the betting game: you can **create new tippers**, **edit tippers** and **delete tippers**. For each tipper the following details can be changed:

**Personal data**
Password, name, address, e-mail; blocked/activated status.

**Mail subscriptions**
Should the tipper receive the newsletter or the reminder?

**Team**
Which team does the tipper play in? (only with the team option enabled)

**Subscribed leagues**
Which leagues can the tipper tip?

---

## 4. Entering tips retroactively

Only the **full admin** can enter or change tips for a tipper after the start or end of a game, for example if someone could not submit his or her tips in time.

1. In the betting game admin choose **Enter tips retroactively**.
2. Select the league. All tippers who have a tip file for this league are shown.
3. Click **Edit tips** for the desired tipper. The tipper's normal tip entry opens, a red notice shows the admin mode.
4. Choose the match day, enter the tips and save.
5. Then run the [evaluation](#1-evaluation) again.

This works for all league types (league, tournament/KO) and all tip modes (result, tendency, also with joker). The time lock is lifted only for the admin in this mode; tippers themselves can still only tip within the tip deadline.

**Log:** Every retroactive entry is recorded in `config/tipp/nachtrag.php` (date, admin, tipper, league, match day). You can also see the entries directly in the betting game admin menu under *Enter tips retroactively*.

---

## 5. Backup manager

Only the **full administrator** can create and restore backups of the prediction game. A backup contains the **tip folder** (tips, evaluations, tip overviews, club ranking), the **file with the tipper data** (`addon/tipp/lmo-tipperauth.php`) and the **scoring rules** (`config/tipp/cfg.txt`) as a ZIP file. Which folder is the tip folder is set in the options under *Paths* (default `addon/tipp/tipps/`). The backup manager always uses that setting.

**Creating a backup**

1. In the prediction game admin choose **Backup manager**.
2. Click **Create backup**. The backup appears in the list immediately, with date, type, number of files and size.
3. **Download** saves the ZIP file to your computer, **Delete** removes it from the server.

Backups are stored in the protected folder `config/tipp/backup/` and can only be downloaded through the backup manager. The ZIP file contains `tippordner/`, `tipperdatei/`, `punkteregeln/`, an `info.txt` and a `manifest.json` with checksums.

**Automatic backup**

Under *Settings* you can have a backup (type *Automatic*) created automatically before every evaluation in the admin area, and choose how many automatic backups are kept (0 = all). Older automatic backups are then deleted, manual backups never. The automatic evaluation when results are entered does not trigger a backup.

**Restoring a backup**

1. Click **Restore** next to the backup in the list. The backup is checked completely (structure, file names, checksums).
2. Choose what to restore (tip folder, tipper file, scoring rules) and how:
   - **Add and overwrite (recommended):** files that are not in the backup are kept.
   - **Exactly as in the backup:** tip, evaluation, insight and club files that are not in the backup are deleted.
3. The preview shows how many files are new, overwritten, unchanged or deleted.
4. To confirm, type the word **RESTORE** and click **Restore**.

Before overwriting, the backup manager automatically creates a backup of the current state (type *Before restore*). If that fails, or if the backup is damaged, nothing is changed. This also lets you undo a restore. Files are first written and checked, then swapped in.

**Uploading a backup:** on a new server you can upload a downloaded ZIP file again. It is checked completely before it is accepted; other files are rejected.

All actions (create, download, delete, upload, restore) are listed in the **log** at the end of the page. Under *Settings* you set after how many days log entries are deleted automatically (0 = never). **Delete log** removes the whole log.

**Important:** the tipper file contains access data and e-mail addresses. Treat downloaded backups confidentially. PHP needs the **Zip** extension and write permission for `config/tipp/` and the tip folder. If either is missing, the backup manager says so. On Nginx the `.htaccess` in the backup folder has no effect, so block `config/` in the server configuration.

---

## 6. Options

This is the most extensive and most important area of the betting game. It is best to set up the options completely once before the start and not to change them significantly during the running game.

**Tip mode**
Choose whether an exact result or only the tendency (win/draw/loss) is tipped.

**Paths**
Here you find the path where the betting game stores its data. The default is `/tipps`; do not change it without good reason. The tippers' access data (nicknames, password hashes, addresses) is in `addon/tipp/lmo-tipperauth.php`. The file begins with a guard line (`<?php exit; ?>`) that you must not remove, and needs write permission (666).

**Points distribution**
Here you configure the awarding of points. Depending on the tip mode, different options are available; in tendency mode there are naturally fewer settings.

**Display**
All items activated here appear in the betting game's navigation bar.

**Rules**
Set the **tip deadline**, determine **maximum team sizes** and how many **days in advance** tips may be submitted. You can also activate the **joker tip**: with it, tippers can choose one game per match day where a tip earns more points. You set the **multiplication factor** here.

**Registration**
Determine which **details** are required at registration, whether an **e-mail verification** takes place, whether you receive a **notification** for new registrations and whether new tippers must first be **activated** by you.

**Tip submission**
Configure the appearance of tip submission. In result mode you can show **arrow buttons** (as in the results editor). To give tippers some orientation, you can show **tipped tendencies** and **average tips**.

> There are two variants of tip submission: **by league** (per league and match day) or **by date** (all games of several leagues in a period). *If you deactivate both variants, no tip submission is possible.*

You can also decide whether the tip overviews are **updated automatically** on tip submission.

**Tip overview**
Choose when the tip overview is shown: immediately after entry, after the tip deadline or only after the result is entered. You also determine how many tippers are shown per page.

**Tip table**
The betting game calculates a table for each participant from the tips submitted. You can publish a table of all tippers or one by points contributed.

**Standings tables**
Configure the standings display: overall ranking only or additionally individual rankings per league. You also decide which personal data (real name, nickname, e-mail address) is visible and how detailed the points breakdown appears.

**What counts when points are equal?**
Here you set so-called tie-breakers: for tippers level on points, up to three further criteria are used in descending priority.

**Additional evaluations**
> Decide what is additionally evaluated automatically when league results are entered. If you activate this, the manual update is no longer needed; with a very large number of participants, however, runtime problems may occur because this step is computationally intensive.

**Tippable leagues**
Release here which leagues can be played, either all or only selected ones. *Only released leagues can be subscribed to by tippers.*
