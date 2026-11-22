<?php
/** Liga Manager Online 4
  *
  * https://www.liga-manager-online.org/lmo/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  *
  * Live-Vorschau des Designeditors: liefert das Stylesheet so, wie es mit den
  * (noch nicht gespeicherten) Werten des Formulars aussehen würde.
  * Es wird nichts gespeichert. Nur für den Voll-Admin verfügbar.
  */

require_once(__DIR__ . '/init.php');

if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] != 2 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo '/* forbidden */';
    exit();
}

require_once(__DIR__ . '/lmo-designlib.php');
lmo_design_apply($_POST, 'xlmo_');

header('Cache-Control: no-store');
ob_start();    // beide Stylesheets senden selbst einen Content-Type-Header
require(__DIR__ . '/lmo-style-nc.php');
require(__DIR__ . '/lmo-style.php');
ob_end_flush();
