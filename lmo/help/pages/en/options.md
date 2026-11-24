# Options

1. [Global options](#1-global-options)
2. [Add-on management](#2-add-on-management)
3. [The design editor](#3-the-design-editor)
4. [User management](#4-user-management)
5. [League archive](#5-league-archive)

---

## 1. Global options

The menu command **Options** takes you to the options area. Here you set the global script settings. Helper admins have no access.

**Basic settings:** default language, league directory, default kick-off time, format of kick-off dates, webmaster's e-mail, e-mail sending (PHP `mail()` or SMTP) and the order of league sorting in the league selection.

**Table options:** position of the points column and type of table display.

**Display/Appearance:** here you decide which components of the LMO are displayed.

### E-mail sending (SMTP)

All e-mails of the LMO (sending leagues by e-mail; in the betting game registration, activation, password mails, newsletters and tip reminders) use the settings in the area **E-mail sending**. You find it in the basic settings directly below the webmaster's e-mail. Only the full administrator sees and changes these settings.

| Setting | Meaning |
|---|---|
| Sending method | **PHP mail()** is the default and works if your server is allowed to send mail itself. If mails do not arrive or end up in spam, choose **SMTP server**. If SMTP fails, the LMO tries once more with `mail()` as a fallback. |
| Server, port, encryption | You get the data from your mail provider. Usual are STARTTLS with port 587 or SSL/TLS with port 465. Choose *none (unencrypted)* only in exceptional cases. |
| User name, password | Credentials of the mailbox, usually the e-mail address. The password is never shown again after saving. Leave the field empty to keep it unchanged, or delete it with the checkbox. It is best to use a separate mailbox just for sending. |
| Sender address | Optional. If empty, the webmaster's e-mail is used. Many providers only allow senders matching the SMTP account. |
| Send test mail | Sends a test mail with the values currently entered (even unsaved) to the webmaster's e-mail, which must be saved for this. The test mail goes via SMTP only, without fallback to `mail()`, so that errors become visible. The result appears next to the button. |

**Where is the password stored?** Encrypted in `config/smtp/cfg.php`, the key is in `config/smtp/key.php`. Both files are protected against direct access by a guard line. Note that the key is on the same server: the encryption protects against the configuration file accidentally becoming readable (e.g. in a backup), but not against someone with access to the whole server directory. Open the admin area via HTTPS whenever possible. On an HTTP connection the LMO shows a warning.

---

## 2. Add-on management

The add-on management controls the add-ons that extend the LMO with additional functions. It is meant for experienced users. Change values here only if the add-on has no configuration interface of its own.

Choose the add-on in the selection menu and change the configuration variables directly. **The input is not checked**; wrong values can make the LMO unusable in the worst case.

---

## 3. The design editor

With the design editor you adapt colours and fonts to your homepage. You find it under **Options → Design editor**. It is only available to the full administrator. On the left you set the values, on the right you immediately see how one of your leagues looks with them. Nothing is applied until you click **Save changes**.

### Layout of the editor

The settings are organised in tabs. All tabs belong to **one** form: your input is kept when you switch between tabs, and one click on *Save changes* saves everything.

| Tab | Content |
|---|---|
| Outer frame | Page background, base font, heading, main and sub menu of the outer area |
| Middle frame | Area around each view with its own heading plus main and sub menu |
| Inner frame | Tables: normal cells, highlights (e.g. table heads) and links |
| Table | Colours of the table positions (champion, Champions League, Europa League, relegation play-off, relegated) and home/away tables |
| Tournament area | Colours for winners and losers in tournament plans (knockout rounds) |
| Other options | Cross table, calendar, weekends, form curves, font sizes, underlining of links |
| Forms | Input fields and buttons |

### The live preview

On the right you see a real league of your installation (at least one league must exist). Every change is shown immediately, even without saving. With the selection fields above you choose

- the **league** to test with,
- the **view** (table, results, schedules, cross table, calendar) and
- the **width** (desktop, tablet, smartphone). The LMO layout does not adapt automatically to the screen width, so the narrow preview may scroll sideways.

**Click instead of search:** if you move the mouse over an area in the preview, it gets an orange outline and its name (e.g. "Middle frame: Main menu"). A click opens the matching tab and highlights the field. Links in the preview are not triggered.

### Setting colours and fonts

You set each colour in two ways: by typing a hex code (`#1b6b2f`, short `#0a0`) or an English colour name (`red`), or by clicking the colour box, which opens your browser's colour picker.

For many fields two colours belong together: first the background, then the font colour. An empty field sets no colour and the browser uses its default. There are also border values (e.g. `1px solid #000000`), the font family (e.g. `Verdana, sans-serif`) and the font size (e.g. `13px` or `94%`).

> **Contrast warning:** If background and font colour are too similar, the editor marks the row and the tab with a warning symbol ⚠. A contrast of at least 4.5 to 1 is recommended. The warning is only a hint; you can still save.

**Input check:** When saving, all values are checked. Invalid values are ignored and the previous value is kept. This way typing errors cannot damage the stylesheet.

### Colour schemes

Above the form you choose a **colour scheme** (Default, Lawn green, Red, Sky blue, Orange, Anthracite, Purple, Turquoise, Burgundy). One click switches frames, menus, cross table and forms to the chosen main colour in one go.

- **Dark:** uses the dark variant of the scheme.
- **Custom colour:** opens a palette with 108 colours. There you pick a colour, use the browser's colour picker for any colour, or type a hex code (confirm with Enter).
- **Default** restores the original LMO colours.

A scheme deliberately does not change the colours of the table (champion, promotion/relegation) and the tournament area, because they carry a fixed meaning. Afterwards you can fine-tune every colour by hand. A scheme, too, only takes effect after *Save changes*.

### Saved designs

Below the form you manage your own designs on the server, e.g. a summer and a winter design.

- **Save as …** stores the current values under a name of your choice (letters, digits, spaces, `-` and `_`). If the name already exists you are asked before overwriting.
- **Load** takes the chosen design into the form and the preview. It becomes visible to visitors only after *Save changes*.
- **Delete** removes the chosen design.

The designs are stored as text files in `config/design/`. The folder `config` must be writable for this; the subfolder is created automatically when needed.

### Export and import

**Export** downloads the current design (including unsaved changes) as a file `lmo-design-YYYYMMDD.json`, **Import** loads such a file into the form. This way you back up a design, transfer it to another installation or share it with other LMO operators. On import only known fields with valid values are taken over.

There are also two helper functions: **Default values** resets all fields to the original values (after confirmation), **Discard changes** undoes everything since the last save.

### Your own additions with style.css

If the design editor is not enough, edit the file `template/style.css`. Its CSS rules are loaded automatically, override the design editor settings and are also visible in the live preview. All editor settings are stored in `config/cfg.txt` (variables `lmo_…`) and converted into a stylesheet when the LMO is called.

---

## 4. User management

You reach the user management via **Options → User management**. First you see all configured admins and helper admins. To change one, select the account, change the data and click **Save**. **Delete** removes an account irreversibly.

For helper admins you additionally set under **Released leagues** which leagues they may access.

You create a new account in the area **Add new admin**. The fields are pre-filled, and the password is a random password you can accept. Afterwards assign the new administrator his or her rights.

### Helper admins

Helper admins enter results but have no access to the sensitive league settings or the global options. Handy if helpers enter the current results for you.

### Extended helper admins

If the rights of a helper admin are not sufficient, you can extend them. An extended helper admin is a full administrator, but only for his or her leagues:

- He or she can fully manage the leagues assigned to him or her.
- He or she has no access to the global options.

---

## 5. League archive

You can store expired leagues in the integrated archive without making the league selection too long. Create a directory with a meaningful name (e.g. `Bundesliga`) in the folder `ligen/` and move the leagues into it. Directories can be nested as deeply as you like.

If the corresponding setting in the global options is active, your visitors see the archive with a link for each subdirectory. For a description, create the text file `dir-descr.txt` in a directory (e.g. "All Bundesliga seasons from 1963 to 2000"). After clicking the directory link, visitors choose the leagues as usual. You can still edit archived leagues in the admin area.
