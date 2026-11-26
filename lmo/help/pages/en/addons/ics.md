# ICS calendar

1. [Overview](#1-overview)
2. [Opening the ICS page](#2-opening-the-ics-page)
3. [Download or subscription?](#3-download-or-subscription)
4. [Subscribing in calendar apps](#4-subscribing-in-calendar-apps)
5. [FAQ](#5-faq)

The ICS addon lets visitors add a team's fixtures to their own calendar (Google Calendar, Apple Calendar, Outlook, Thunderbird and many more). If the calendar is **subscribed**, new kick-off times and postponements update automatically.

> **Note:** The ICS addon is not part of the LMO package but a **separate download**: [Latest release on GitHub](https://github.com/henshingly/ics-calendar/releases/latest). Extract it into your LMO directory (it creates `addon/ics/`, `lang/ics/` and `config/ics/`).

---

## 1. Overview

| File | Purpose |
|---|---|
| `addon/ics/lmo-ics.php` | the ICS page: choose league, choose team, create file |
| `lang/ics/lang-<language>.txt` | texts in 14 languages |
| `config/ics/cfg.txt` | settings (match duration, reminder, URL in the entry, shortening club names) |

On the page you set the team, the URL in the calendar entry, the match duration (minutes) and a reminder before kick-off. Then the **download link** and the **subscription link** appear.

---

## 2. Opening the ICS page

* **From the table:** If **Link ICS calendar** is enabled in the league's basic settings under *Display → Links*, a small calendar icon appears behind each team. Clicking it opens the ICS page for that team.
* **Directly:** open `addon/ics/lmo-ics.php` and choose league and team.

---

## 3. Download or subscription?

| | Download (`.ics` file) | Subscription (`webcal://`) |
|---|---|---|
| Effect | one-time import of today's fixtures | calendar stays connected to the LMO |
| Changes in the LMO | do **not** arrive | are picked up automatically |
| Best for | one-time import, devices without subscriptions | usually the better choice |

The subscription link starts with `webcal://`, which is just another way to write `https://`. For programs that don't know `webcal://`, replace it with `https://` (or `http://` if the site has no HTTPS).

---

## 4. Subscribing in calendar apps

First copy the subscription link from the ICS page. On smartphones, tapping the link is often enough; the calendar app then asks whether to subscribe.

### Google Calendar (computer)

1. Open [calendar.google.com](https://calendar.google.com).
2. Next to **Other calendars** click **+** and choose **From URL**.
3. Paste the link, with `webcal://` replaced by `https://`.
4. Click **Add calendar**.

The calendar then also shows up in the Google Calendar app on Android with the same account. Google refreshes subscribed calendars rarely; changes can take up to a day.

### Apple Calendar (iPhone and iPad)

1. **Settings → Calendar → Accounts → Add Account → Other → Add Subscribed Calendar**.
2. Paste the link, tap **Next** and **Save**.

Alternatively tap the `webcal://` link and choose **Subscribe**.

### Apple Calendar (Mac)

1. In Calendar: **File → New Calendar Subscription**.
2. Paste the link and click **Subscribe**.
3. Set a name and the refresh interval (e.g. hourly or daily).

### Microsoft Outlook (Windows, classic)

1. **File → Account Settings → Account Settings**.
2. Tab **Internet Calendars → New**.
3. Paste the link, click **Add** and name the calendar.

### Outlook on the web and new Outlook

1. **Calendar → Add calendar → Subscribe from web**.
2. Paste the link (use `https://` instead of `webcal://` if needed), name it, **Import**.

Updates can take a few hours.

### Mozilla Thunderbird

1. Switch to the calendar view and choose **New Calendar** (plus icon next to "Calendar").
2. Choose **On the Network** and **Next**.
3. Select format **iCalendar (ICS)**, paste the link into **Location**, click **Next** and name it.
4. Right-click the calendar → **Properties** to set the refresh interval (e.g. every 30 minutes).

### Android without a Google account (and Samsung Calendar)

Many Android calendars cannot add subscriptions. The free app **ICSx⁵** (F-Droid or Play Store) subscribes to ICS links and makes them available to the device's calendar: open the app, tap **+**, paste the link, save.

### Other programs

Nextcloud, GMX, web.de, IONOS and many other services offer something like *subscribe to calendar*, *add calendar by URL* or *internet calendar*. Enter the link there, if in doubt with `https://` at the start.

---

## 5. FAQ

**The calendar shows new kick-off times late.**
The calendar app decides, not the LMO. Google and Outlook on the web refresh rarely; Apple and Thunderbird can be set to refresh more often.

**I see no matches.**
The calendar only contains matches that have a date. Below the list the page shows how many matches without a date are missing.

**The times are shifted.**
Times are calculated with the time zone set in the LMO and passed to the calendar in UTC. Check the time zone in the LMO options and in your calendar.

**The subscription does not work.**
The link must be reachable from outside (no password protection, no intranet-only server). Test it in the browser with `https://` instead of `webcal://`: an `.ics` file should download.

**I want to change the match duration or reminder.**
Change the values on the ICS page and choose **Create ICS file**. The subscription link contains these settings. An existing subscription must be subscribed again with the new link.
