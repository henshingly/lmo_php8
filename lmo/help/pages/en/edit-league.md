# Edit League

1. [Creating a league](#1-creating-a-league)
2. [Opening a league](#2-opening-a-league)
3. [The results editor](#3-the-results-editor)
4. [Basic settings](#4-basic-settings)
5. [Manual table sorting](#5-manual-table-sorting)
6. [The team editor](#6-the-team-editor)

---

## 1. Creating a league

Click **New** in the menu to create a new league. The process has 4 steps:

**Step 1:** Set the league's **file name**, without path and file extension, which are preset. The input may be at most 28 characters long. Give the league a meaningful **name**, which appears in the listings and as a heading in the visitor area. Besides the title you should also mention the season, e.g. `1st County League Springfield 2001/02`. Also choose whether you create a **league** (with points, table etc.) or a **knockout tournament** (playoff or similar). Click **Next**.

**Step 2:** Set the **number of teams**. For a league you also enter the **number of match days** and the **games per match day**. For knockout tournaments this is omitted, as these values follow from the number of teams. Click **Next**.

**Step 3:** For leagues, **schedule creation** follows. You can take over a schedule from another league (only possible for leagues with the same number of teams, games and match days), generate a **random schedule** (the system known from LM98Free; only possible for a "normal" league in which every team plays one home and one away game against every opponent, as in the Bundesliga) or skip it entirely. For knockout tournaments you set the **game mode** of the individual rounds here. Click **Next**.

**Step 4:** The **league is saved!** Next you should edit the [teams](#6-the-team-editor), which are initially only numbered. If you took over the schedule from another league, first have a look at the visitor area to find out the correct assignment of the teams.

---

## 2. Opening a league

After [logging in](#getting-started/6-login-logout) you directly see an overview of all available leagues. Alternatively click **Open** in the menu. Choose the league you want to edit. [Helper admins](#options/helper-admins) only see the leagues released for them.

---

## 3. The results editor

After [opening a league](#2-opening-a-league) you land automatically in the results editor with the current match day. With the selection menu below the menu you can also call up other match days.

**Date:** At the very top you can set the **start and end date** of the match day. The format is `DD.MM.YYYY`. Make sure the date is entered with a two-digit day and month and a four-digit year, separated by dots. Next to the date fields a button opens a pop-up calendar where you pick the date with a click. These dates are only shown to visitors if the [setting](#4-basic-settings) **Match day date** is active.

**Kick-off dates:** Each game can be assigned a **kick-off date**, also in the format `DD.MM.YYYY`, and here too there is a button for the pop-up calendar. If you enter a date but no time, the [default kick-off time](#options/1-global-options) is used. Please enter times in the format `HH:MM` (two-digit hour and minute, separated by `:`).

**Teams:** You choose the teams via the combo boxes.

**Entering results:** The easiest way is the arrow buttons next to the result fields. You can also type numbers directly or use the arrow keys while the cursor is in the field. With decimal places enabled you still enter results as whole numbers; the conversion only happens on output.

**Game end:** For leagues with [open game end](#4-basic-settings) or knockout tournaments you specify how the game ended: normal (\_), after extra time/overtime (a.e.t.) or in a penalty shoot-out (pen.).

> **Note:** For sports tribunal decisions that affect both points and goals (e.g. forfeiting a win), you do not need the following field.

**Green-table decision:** This field is normally not needed. But there are always sports tribunal decisions that turn results upside down. Regardless of the result entered, you can set a decision on the winner here. The goals count for the table as entered, but the points follow this setting. Usually the tribunal then says, for example: 0:0 goals and team X wins. The option **mutual result** applies if the tribunal decides the game equally for both teams (e.g. 2:0 for both).

**Note:** Here you can enter a note on the game, e.g. the venue. A normal sports tribunal decision can also be mentioned here. The special cases of green-table decisions do not have to be mentioned again; they are inserted automatically as a note.

**Match report URL:** Optionally you can add a link to the match report. It is only shown if **Link match reports** is active in the [settings](#4-basic-settings).

**Betting game:** If you use the [betting game](#addon-betting-game), you can exclude individual games from scoring.

**Settings independent of the match day:** Below the games you find further settings you can adjust directly here.

**Current match day:** You only need to change something here if the match day you are editing should *not* be marked as the current match day, e.g. when you edit a postponed game or correct an older result. Then select the match day that should count as the current one. Otherwise please leave the field unchanged.

**News ticker:** Activate the ticker and enter messages, one per line, without blank lines.

Click **Save match day and ticker** to apply everything. Your changes are visible to visitors immediately, so better check once more!

> If [manual table sorting](#5-manual-table-sorting) is active: a previous manual sorting of this or later match days is discarded after saving.

---

## 4. Basic settings

Here you set all settings of the league. For knockout tournaments only the relevant options are shown.

**Basic values**
The **league name** appears in the listings and as a heading in the visitor area, including the season, e.g. `1st County League Springfield 2001/02`. You also set the **labels for points and goals** (adjustable to the sport) and can activate **decimal points/goals**. Also choose the **favourite team** and the **default teams for schedule, form curve and statistics**.

**Links**
Decide whether [team homepages](#6-the-team-editor) (in the table) and [match reports](#3-the-results-editor) (in results and schedules) are linked.

**Display/Appearance**
Here you decide what you want to offer your visitors. With **Start view** you determine what visitors see first when loading the league. You can activate **match day date** and **kick-off dates**; without both there is no calendar either. The **calendar** can also be deactivated separately. With kick-off dates active, choose the desired **display format**.

**Third-place game** and **Enable play-down** are only available for knockout tournaments. Here you decide whether a small final takes place and whether (as usual with play-downs) the loser can also advance a round.

The **cross table** and the **form curve** can be deactivated. The form curve is drawn in the browser and needs no server library. The cross table makes little sense if there are no return games (e.g. World Cup group games).

**Game system**
The game system contains all settings concerning the mode of the league.

- **Minus points** exist in 2-point leagues, no longer in 3-point leagues.
- **Open game end** only has to be activated if a draw is followed by extra time/overtime and possibly a penalty shoot-out.
- You only need to hide the table column **Draws** if there are generally no draws in your league.
- **Head-to-head** means that when teams are level on points, the direct comparison of the teams level on points is taken into account.
- You only activate **Goals scored count before goal difference** if in your league goals scored weigh more than goal difference, which is rather rare.
- You should enable **Manual table sorting** only in exceptional cases, e.g. for special rules this software does not take into account. Then you can [correct the table manually](#5-manual-table-sorting).

**Table**
Decide which entries of your table (and the form curve) are highlighted or shown:

- First-leg/second-leg tables
- Home/away tables
- Champion, promoted, relegated
- Other markings (e.g. UEFA Cup places)

A value of `0` deactivates the respective marking.

**Points system**
Here you configure the awarding of points. With minus points enabled, win points are at the same time negative defeat points and vice versa; draw points are counted for both sides.

**Number of match days and games**
You usually do not need this function. If you have to change the number of match days or games afterwards, you can do so here. But first make [a backup](#file-functions/3-download-e-mail-a-league)! Not available for knockout tournaments.

---

## 5. Manual table sorting

If you have enabled the [setting](#4-basic-settings) **Enable manual table sorting**, the option **Table** appears at the bottom of the [results editor](#3-the-results-editor). Click it to check the table and correct it manually if necessary.

Choose below the menu the match day whose table you want to edit. The table is shown as the software calculated it. If everything is correct, you do not have to do anything.

Otherwise assign new positions to the teams. Each position may occur only once (a JavaScript function normally prevents duplicates automatically).

Then click **Save manual table**. In the visitor area the table (and the form curve) is shown according to your corrections.

---

## 6. The team editor

Here you can enter and change **team names**. The **abbreviation** may be at most 5 characters long.

If the association awards penalty or bonus points and goals, you can enter them here; they are included in the table calculation. You can also set from which match day the change takes effect.

If you want to link team homepages, enter the URLs in the corresponding column. The links appear in the table if **Link team homepages** is active in the [settings](#4-basic-settings).

> **Caution:** For each team there are functions to **withdraw** it from the league and to **add** a new team **later**. *Make [a backup](#file-functions/3-download-e-mail-a-league) first!* If you use the betting game for this league, these functions can cause malfunctions. These options are not available for knockout tournaments.
