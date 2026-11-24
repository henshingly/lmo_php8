# Getting Started

1. [Introduction](#1-introduction)
2. [System requirements](#2-system-requirements)
3. [Installation](#3-installation)
4. [Fixing file permissions](#4-fixing-file-permissions)
5. [Update installation](#5-update-installation)
6. [Login/Logout](#6-login-logout)
7. [Legal notice](#7-legal-notice)

---

## 1. Introduction

Welcome to the Liga Manager Online! With this script you offer your visitors a results service for your favourite leagues. All management happens directly on the server: you only enter the results, and your visitors immediately see the current tables, statistics and schedules.

The admin area is reached via `lmoadmin.php`. It is a good idea to bookmark it, because for security reasons there is no link to it in the visitor area. Your visitors start the LMO via the file `lmo.php`. How to integrate it into your homepage is described under [Customization](#customization/4-integrating-the-lmo-into-existing-homepages).

Every link has a tooltip, so further explanations of how to use it are usually not necessary.

---

## 2. System requirements

- **Web server:** Apache, Nginx or another web server with PHP (Linux or Windows)
- **PHP:** version **8.2 or higher**
- **Database:** not needed, the LMO stores everything in files (flat files)
- **PHP extensions:** `mbstring`, `session` and `json` (pre-installed by almost every host). Optional: **Zip** for downloading all leagues and zip attachments in e-mails, **OpenSSL** for sending e-mail via SMTP with encryption (TLS/SSL). The form curves (league and prediction game) are drawn in the browser and need no GD library.
- **Write permissions:** PHP must be able to write to the directories for leagues, configuration and output. The installer checks this and sets the permissions where possible.
- **Browser:** a current browser with JavaScript enabled

> **Note for Apache 2:** Remove all special characters from the file names of team icons. Only letters and digits are allowed.

---

## 3. Installation

Setup runs entirely in the browser; you do not have to enter any FTP credentials.

1. Unpack the ZIP archive and upload the **entire content** to your server, keeping the directory structure.
2. Open the LMO in your browser, e.g. `https://www.your-site.com/lmo/lmoadmin.php`. **The installation starts automatically** and sets up paths, configuration and access data.
3. After a successful installation the button **Delete installation folder now** appears. Click it so that the `install` folder does not remain on the server.
4. Log in and change the password immediately (see [Login/Logout](#6-login-logout)).

Normally the LMO is ready to use afterwards. If the installation aborts, check the [file permissions](#4-fixing-file-permissions) first.

### Manual installation

> **Only necessary if the automatic installation does not work.**

1. Copy the content of the `install` folder into your LMO directory and then delete the file `install/install.php`.
2. Create (or open) the file `config/init-parameters.php` and enter the two paths:

   ```php
   <?php
   $lmo_dateipfad = '/absolute/path/to/lmo'; // file path to the LMO
   $lmo_url = 'https://www.your-site.com/lmo'; // absolute URL of the LMO
   ```

   If you do not know either of them, ask your provider.
3. Set the file permissions as described in the next section.

---

## 4. Fixing file permissions

The LMO must be able to write to some folders and files. If it reports that something is not writable, set the permissions (chmod) as follows:

![Setting permissions (chmod)](./assets/media/manual_chmod.png)

**Directories (777):**

- `ligen` and all subdirectories
- `output`
- `config` and its subdirectories `config/viewer` and `config/smtp`
- `addon/spieler/stats`
- `addon/tipp/tipps` and all subdirectories

**Files (666):**

- `config/lmo-auth.php`
- `addon/tipp/lmo-tipperauth.php`
- `config/smtp/cfg.php` and `config/smtp/key.php` (if present)
- all `cfg.txt` files in the `config` directory and its subdirectories
- all leagues in the `ligen` directory and its subdirectories
- all files in `output`, `addon/spieler/stats` and `addon/tipp/tipps` (if present)

---

## 5. Update installation

When updating an existing installation, your configuration files and leagues are not overwritten.

1. Back up your entire LMO directory first (at least `ligen`, `config` and `addon/tipp/tipps`).
2. Copy the new files over the existing ones. Your own customizations (e.g. in `template/` or `img/teams/`) are kept as long as you do not replace the same files.
3. Open the admin area. The LMO reports **Update detected**. Click **Start update installation**.
4. The update adjusts the configuration. Among other things, the passwords of the tippers in the betting game are converted to secure (hashed) storage.
5. Afterwards, delete the `install` folder with the button **Delete installation folder now**.

> **Note:** If the folder `config/smtp` is not writable, the LMO tells you so. SMTP settings can then only be saved after the permissions are set.

---

## 6. Login/Logout

Opening `lmoadmin.php` shows the login form. After a new installation the user name `admin` and the password `lmo` (lowercase L, M, O) are preset. **Change the password as soon as possible** under [Options → User management](#options/4-user-management) so that no unauthorized person gets access.

When you are logged in, you will find the entry **Logout** in the menu. Use it at the end of every session.

---

## 7. Legal notice

> This script is published under the terms of the [GPL](https://www.gnu.org/licenses/gpl.txt). This means you may use, distribute and modify the script, but no warranty is given. **Copyright notices must be retained in all cases and may neither be removed nor changed.**

Although the software was developed with care, no liability can be accepted for errors or damage resulting from its use.
