<?
header("Content-Type: text/css");
require("init.php");
@include(PATH_TO_TEMPLATEDIR."/style.css");
?>

.message{
  color: #080;
}

.error{
  color: #a00;
}

/** Auﬂenbereich*/
.lmoMain { 
  background-color: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
  font-size: <?=$lmo_main_fontsize1?>;
  font-family: <?=$lmo_main_fontfamily1?>;
}

/** Auﬂenbereich ‹berschrift*/
.lmoMain h1 { 
  background-color: <?=$lmo_main_background2?>; 
  color: <?=$lmo_main_color2?>; 
  font-size: <?=$lmo_main_fontsize2?>; 
  font-family: <?=$lmo_main_fontfamily2?>;
}

/** Auﬂenbereich Men¸ */
.lmoMain .lmoMenu { 
  font-weight: bold; 
  background-color: <?=$lmo_main_background4?>; 
  color: <?=$lmo_main_color4?>; 
}

.lmoMain .lmoMenu a { 
  background-color: <?=$lmo_main_background5?>; 
  color: <?=$lmo_main_color5?>; 
}

/** Auﬂenbereich Untermen¸ */
.lmoMain .lmoSubmenu { 
  font-weight: bold; 
  background-color: <?=$lmo_main_background6?>; 
  color: <?=$lmo_main_color6?>; 
}

.lmoMain .lmoSubmenu a { 
  line-height:140%;
  font-weight: normal; 
  text-decoration: none; 
  background-color: <?=$lmo_main_background7?>; 
  color: <?=$lmo_main_color7?>; 
}

/** Auﬂenbereich Fusszeilen */
.lmoMain .lmoFooter { 
  font-size: <?=$lmo_main_fontsize3?>; 
  font-weight: normal;
}

.lmoMain .lmoFooter a { 
  text-decoration: underline; 
  background-color: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
}

/** Ende Auﬂenbereich */

/** Mittelbereich */
.lmoMiddle { 
  background-color: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
  font-size: <?=$lmo_middle_fontsize1?>;
  font-weight: bold;
}

/** ‹berschrift im Mittelbereich */
.lmoMiddle h1{ 
  background-color: <?=$lmo_middle_background2?>; 
  color: <?=$lmo_middle_color2?>;
  font-size:<?=$lmo_middle_fontsize2?>;
}

/** Links im Mittelbereich */
.lmoMiddle a {  
  line-height:150%;
  text-decoration: none; 
  background-color: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-weight: normal;
}

.lmoMiddle .lmoMenu {
  font-weight: bold; 
  background-color: <?=$lmo_middle_background4?>; 
  color: <?=$lmo_middle_color4?>;
}

.lmoMiddle .lmoMenu a {
  line-height:140%;
  font-weight: normal; 
  text-decoration: none; 
  background-color: <?=$lmo_middle_background5?>; 
  color: <?=$lmo_middle_color5?>;
}

.lmoMiddle .lmoSubmenu {
  background-color: <?=$lmo_middle_background6?>; 
  color: <?=$lmo_middle_color6?>;
}

.lmoMiddle .lmoSubmenu a {
  background-color: <?=$lmo_middle_background7?>; 
  color: <?=$lmo_middle_color7?>;
}

/** Innerer Bereich */
.lmoInner {
  background-color: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>;
  font-size: <?=$lmo_inner_fontsize1?>;
  font-weight: normal;
}

.lmoInner a {  
  line-height:100%;
  text-decoration: none; 
  background-color: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-weight: normal;
}

.lmoInner caption {
  background-color: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-weight: bold;
}

.lmoInner caption a{
  background-color: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-weight: normal;  
}

.lmoInner .lmoFooter {
  background-color: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color2?>; 
}

.lmoInner .lmoFooter a { 
  line-height:150%;
  text-decoration: underline; 
  background-color: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color2?>;
}

.lmoKreuz table {
  font-size: <?=$lmo_kreuz_fontsize1?>;
}

.lmoBackMarkierung {
  background-color: <?=$lmo_kreuzkal_background1?>; 
}

.lmoBackMarkierung a { 
  line-height:190%;
  background-color: <?=$lmo_kreuzkal_background1?>; 
  font-weight: bold; 
}

.lmoFrontMarkierung { 
  color: <?=$lmo_kreuzkal_color1?>; 
  font-weight: bold; 
}

.lmoLeer {
  background-color: <?=$lmo_kreuzkal_background2?>;
}

.lmoTabelleMeister { 
  background-color: <?=$lmo_tabelle_background1?>; 
  color: <?=$lmo_tabelle_color1?>; 
}

.lmoTabelleMeister a {
  background-color: <?=$lmo_tabelle_background1?>;
  color: <?=$lmo_tabelle_color1?>; 
  text-decoration: none;
}

.lmoTabelleCleague { 
  background-color: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
}

.lmoTabelleCleague a {
  background-color: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
  text-decoration: none;
}

.lmoTabelleCleaguequali { 
  background-color: <?=$lmo_tabelle_background3?>; 
  color: <?=$lmo_tabelle_color3?>; 
}

.lmoTabelleCleaguequali a { 
  background-color: <?=$lmo_tabelle_background3?>; 
  color: <?=$lmo_tabelle_color3?>;
  text-decoration: none;
}

.lmoTabelleUefa { 
  background-color: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
}

.lmoTabelleUefa a { 
  background-color: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
  text-decoration: none; 
}

.lmoTabelleRelegation { 
  background-color: <?=$lmo_tabelle_background5?>; 
  color: <?=$lmo_tabelle_color5?>;
}

.lmoTabelleRelegation a { 
  background-color: <?=$lmo_tabelle_background5?>; 
  color: <?=$lmo_tabelle_color5?>;
  text-decoration: none; 
}

.lmoTabelleAbsteiger { 
  background-color: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
}

.lmoTabelleAbsteiger a { 
  background-color: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
  text-decoration: none; 
}

.lmoTabelleHeimbilanz { 
  background-color: <?=$lmo_tabelle_background7?>; 
  color: <?=$lmo_tabelle_color7?>;
}

.lmoTabelleGastbilanz { 
  background-color: <?=$lmo_tabelle_background8?>; 
  color: <?=$lmo_tabelle_color8?>; 
}

.lmoTurnierSieger { 
  background-color: <?=$lmo_turnier_background1?>; 
  color: <?=$lmo_turnier_color1?>;
}

.lmoTurnierSieger a { 
  background-color: <?=$lmo_turnier_background1?>; 
  color: <?=$lmo_turnier_color1?>;
  text-decoration: none;
}

.lmoTurnierSieger a:hover{ 
  background-color: <?=$lmo_turnier_color1?>; 
  color: <?=$lmo_turnier_background1?>; 
}

.lmoTurnierVerlierer { 
  background-color: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
}

.lmoTurnierVerlierer a { 
  background-color: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
  text-decoration: none;
}

.lmoTurnierVerlierer a:hover{ 
  background-color: <?=$lmo_turnier_color2?>; 
  color: <?=$lmo_turnier_background2?>; 
}

.lmotext { 
  text-align: justify; 
}
/*
.lmofett { 
  background-color: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  text-align: justify; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size:85%; 
  font-weight: bold; 
}
*/
.lmoMain li { 
}

a.colorpicker {
  display:none;
}

.sort-arrow {
	display:none;
}

.sort-arrow.descending {
	display:none;
}

.sort-arrow.ascending {
	display:none;
}
a span.popup, a:link span.popup{
	display: none;
}