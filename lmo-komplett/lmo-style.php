<?
header("Content-Type: text/css");
require("init.php");
@include(PATH_TO_TEMPLATEDIR."/style.css");
?>

.message{
  margin: 0;
  color: #080;
  background-color:transparent;
}

.error{
  margin: 0;
  color: #a00;
  background-color:transparent;
}

.nobr {
  white-space:nowrap;
}

form { 
  padding: 0; 
  margin: 0; 
}

acronym {
  cursor:help;
  border-bottom:1px dotted;
}


/** Auﬂenbereich*/
.lmoMain { 
  background: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
  border: 0<?=$lmo_main_border1?>; 
  margin:0.3em auto;
  padding:0.2em;
  font-size: <?=$lmo_main_fontsize1?>;
  font-family: <?=$lmo_main_fontfamily1?>;
}

.lmoMain p { 
  margin:0;
}

/** Auﬂenbereich ‹berschrift*/
.lmoMain h1 { 
  padding: 0.2em; 
  margin:0.2em;
  background: <?=$lmo_main_background2?>; 
  color: <?=$lmo_main_color2?>; 
  font-size: <?=$lmo_main_fontsize2?>; 
  font-family: <?=$lmo_main_fontfamily2?>;
}

/** Auﬂenbereich Men¸ */
.lmoMain .lmoMenu { 
  padding: 0.2em;
  font-weight: bold; 
  white-space:nowrap;
  background: <?=$lmo_main_background4?>; 
  color: <?=$lmo_main_color4?>; 
  border:0<?=$lmo_main_border4?>;
}

.lmoMain .lmoMenu a { 
  line-height:140%;
  padding:0.1em;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_main_background5?>; 
  color: <?=$lmo_main_color5?>; 
  border:0<?=$lmo_main_border5?>;
}

.lmoMain .lmoMenu a:hover { 
  background: <?=$lmo_main_color5?>; 
  color: <?=$lmo_main_background5?>; 
}

/** Auﬂenbereich Untermen¸ */
.lmoMain .lmoSubmenu { 
  padding: 0.2em;
  font-weight: bold; 
  white-space:nowrap;
  background: <?=$lmo_main_background6?>; 
  color: <?=$lmo_main_color6?>; 
  border:0<?=$lmo_main_border6?>;
}

.lmoMain .lmoSubmenu a { 
  line-height:140%;
  padding:0.1em;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_main_background7?>; 
  color: <?=$lmo_main_color7?>; 
  border:0<?=$lmo_main_border7?>;
}

.lmoMain .lmoSubmenu a:hover { 
  background: <?=$lmo_main_color7?>; 
  color: <?=$lmo_main_background7?>; 
}

/** Auﬂenbereich Fusszeilen */
.lmoMain .lmoFooter { 
  padding: 0;
  font-size: <?=$lmo_main_fontsize3?>; 
  font-weight: normal;
}

.lmoMain .lmoFooter a { 
  text-decoration: underline; 
  background: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
}

.lmoMain .lmoFooter a:hover { 
  background: <?=$lmo_main_color1?>; 
  color: <?=$lmo_main_background1?>; 
}

/** Ende Auﬂenbereich */

/** Mittelbereich */
.lmoMiddle { 
  padding: 0.2em; 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
  font-size: <?=$lmo_middle_fontsize1?>;
  border: 0<?=$lmo_middle_border1?>; 
  margin:0.5em auto 1.5em auto;
  font-weight: bold;
}

/** ‹berschrift im Mittelbereich */
.lmoMiddle h1{ 
  background: <?=$lmo_middle_background2?>; 
  color: <?=$lmo_middle_color2?>;
  font-size:<?=$lmo_middle_fontsize2?>;
  margin:0.1em;
  padding:0.1em;
}

/** Links im Mittelbereich */
.lmoMiddle a {  
  line-height:150%;
  text-decoration: none; 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-weight: normal;
}

.lmoMiddle a:hover { 
  background: <?=$lmo_middle_color1?>; 
  color: <?=$lmo_middle_background1?>; 
}

.lmoMiddle .lmoMenu {
  padding: 0.2em;
  font-weight: bold; 
  white-space:nowrap;
  background: <?=$lmo_middle_background4?>; 
  color: <?=$lmo_middle_color4?>;
  border: 0<?=$lmo_middle_border4?>;
}

.lmoMiddle .lmoMenu a {
  line-height:140%;
  padding:0.1em;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_middle_background5?>; 
  color: <?=$lmo_middle_color5?>;
  border: 0<?=$lmo_middle_border5?>; 
}

.lmoMiddle .lmoMenu a:hover {
  background: <?=$lmo_middle_color5?>; 
  color: <?=$lmo_middle_background5?>;
}

.lmoMiddle .lmoSubmenu {
  background: <?=$lmo_middle_background6?>; 
  color: <?=$lmo_middle_color6?>;
  border: 0<?=$lmo_middle_border6?>; 
}

.lmoMiddle .lmoSubmenu a {
  background: <?=$lmo_middle_background7?>; 
  color: <?=$lmo_middle_color7?>;
  border: 0<?=$lmo_middle_border7?>; 
}

.lmoMiddle .lmoSubmenu a:hover {
  background: <?=$lmo_middle_color7?>; 
  color: <?=$lmo_middle_background7?>;
}

/** Innerer Bereich */
.lmoInner {
  padding: 0.2em; 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>;
  font-size: <?=$lmo_inner_fontsize1?>;
  border: 0<?=$lmo_inner_border1?>; 
  font-weight: normal;
}

.lmoInner a {  
  line-height:80%;
  text-decoration: none; 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-weight: normal;
}

.lmoInner td {
  padding: 0.2em; 
}
.lmoInner td td{
  padding: 0; 
}

.lmoInner th {
  padding: 0.2em; 
  background-color: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color2?>; 
}

.lmoInner th a {
  background-color: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color2?>; 
}

.lmoInner th a:hover {
  background-color: <?=$lmo_inner_color2?>; 
  color: <?=$lmo_inner_background2?>; 
}

.lmoInner caption {
  margin: 0 auto;
  padding: 0.4em; 
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
  background: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color2?>;
}

.lmoInner .lmoFooter a:hover { 
  background: <?=$lmo_inner_color2?>; 
  color: <?=$lmo_inner_background2?>; 
}

.lmoKreuz table {
  font-size: <?=$lmo_kreuz_fontsize1?>;
}

.lmoKreuz table, 
.lmoKalender table{
  border-collapse:collapse;
  border-spacing:0;
}

.lmoKreuz td,
.lmoKreuz th,
.lmoKalender td,
.lmoKalender th {
  white-space:nowrap;
  border:1px solid <?=$lmo_kreuzkal_background2?>;
}
.lmoKreuz td ,
.lmoKalender td {
  padding:0;
}

.lmoKreuz small {
  border:1px solid;
}

.lmoBackMarkierung {
  background: <?=$lmo_kreuzkal_background1?>; 
}

.lmoBackMarkierung a { 
  display:block;
  height:100%;
  line-height:190%;
  padding:0;
  background: <?=$lmo_kreuzkal_background1?>; 
  font-weight: bold; 
}

.lmoFrontMarkierung { 
  color: <?=$lmo_kreuzkal_color1?>; 
  font-weight: bold; 
}

.lmoLeer {
  background-color: <?=$lmo_kreuzkal_background2?>;
  border:0;
}

.lmoTabelleMeister { 
  background: <?=$lmo_tabelle_background1?>; 
  color: <?=$lmo_tabelle_color1?>; 
}

.lmoTabelleMeister a {
  background: <?=$lmo_tabelle_background1?>;
  color: <?=$lmo_tabelle_color1?>; 
  text-decoration: none;
}

.lmoTabelleMeister a:hover { 
  background: <?=$lmo_tabelle_color1?>; 
  color: <?=$lmo_tabelle_background1?>;
}

.lmoTabelleCleague { 
  background: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
}

.lmoTabelleCleague a {
  background: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
  text-decoration: none;
}

.lmoTabelleCleague a:hover {
  background: <?=$lmo_tabelle_color2?>; 
  color: <?=$lmo_tabelle_background2?>; 
}

.lmoTabelleCleaguequali { 
  background: <?=$lmo_tabelle_background3?>; 
  color: <?=$lmo_tabelle_color3?>; 
}

.lmoTabelleCleaguequali a { 
  background: <?=$lmo_tabelle_background3?>; 
  color: <?=$lmo_tabelle_color3?>;
  text-decoration: none;
}

.lmoTabelleCleaguequali a:hover { 
  background: <?=$lmo_tabelle_color3?>; 
  color: <?=$lmo_tabelle_background3?>;
}

.lmoTabelleUefa { 
  background: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
}

.lmoTabelleUefa a { 
  background: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
  text-decoration: none; 
}

.lmoTabelleUefa a:hover { 
  background: <?=$lmo_tabelle_color4?>; 
  color: <?=$lmo_tabelle_background4?>;
}

.lmoTabelleRelegation { 
  background: <?=$lmo_tabelle_background5?>; 
  color: <?=$lmo_tabelle_color5?>;
}

.lmoTabelleRelegation a { 
  background: <?=$lmo_tabelle_background5?>; 
  color: <?=$lmo_tabelle_color5?>;
  text-decoration: none; 
}

.lmoTabelleRelegation a:hover { 
  background: <?=$lmo_tabelle_color5?>; 
  color: <?=$lmo_tabelle_background5?>;
}

.lmoTabelleAbsteiger { 
  background: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
}

.lmoTabelleAbsteiger a { 
  background: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
  text-decoration: none; 
}

.lmoTabelleAbsteiger a:hover { 
  background: <?=$lmo_tabelle_color6?>; 
  color: <?=$lmo_tabelle_background6?>;
}

.lmoTabelleHeimbilanz { 
  background: <?=$lmo_tabelle_background7?>; 
  color: <?=$lmo_tabelle_color7?>;
}

.lmoTabelleGastbilanz { 
  background: <?=$lmo_tabelle_background8?>; 
  color: <?=$lmo_tabelle_color8?>; 
}

.lmoTurnierSieger { 
  background: <?=$lmo_turnier_background1?>; 
  color: <?=$lmo_turnier_color1?>;
}

.lmoTurnierSieger a { 
  background: <?=$lmo_turnier_background1?>; 
  color: <?=$lmo_turnier_color1?>;
  text-decoration: none;
}

.lmoTurnierSieger a:hover{ 
  background: <?=$lmo_turnier_color1?>; 
  color: <?=$lmo_turnier_background1?>; 
}

.lmoTurnierVerlierer { 
  background: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
}

.lmoTurnierVerlierer a { 
  background: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
  text-decoration: none;
}

.lmoTurnierVerlierer a:hover{ 
  background: <?=$lmo_turnier_color2?>; 
  color: <?=$lmo_turnier_background2?>; 
}

.lmotext { 
  text-align: justify; 
}
/*
.lmofett { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  text-align: justify; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size:85%; 
  font-weight: bold; 
}
*/
.lmoMain li { 
  padding-bottom: 0.5em; 
}

.lmo-formular-input { 
  background: <?=$lmo_formular_background1?>; 
  color: <?=$lmo_formular_color1?>; 
  border: <?=$lmo_formular_border1?>; 
}

.lmo-formular-button { 
  background: <?=$lmo_formular_background2?>; 
  color: <?=$lmo_formular_color2?>; 
  border: <?=$lmo_formular_border2?>; 
  font-weight: bold; 
  width:     auto;
  overflow:  visible;
  padding:   0 0.3em;

}


a.colorpicker {
  border: 1px solid #000; 
  font-size:15px; 
  text-decoration: none;
}

a.colorpicker table {
  background:#fff;
  color:#000;
}

.sort-arrow {
	width:					11px;
	height:					11px;
	background-position:	center center;
	background-repeat:		no-repeat;
	margin:					0 2px;
}

.sort-arrow.descending {
	background-image:		url("img/downsimple.png");

}

.sort-arrow.ascending {
	background-image:		url("img/upsimple.png");
}
a span.popup, a:link span.popup{
	display: none;
}
a:hover span.popup{
  display: inline;
	font-size:80%;
  position: absolute;
  background-color: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
  border: <?=$lmo_middle_border1?>;
  max-width: 15em;
	margin: 1.5em 0 0 -4em;  
  padding: 0.2em;
	z-index: 999;
  white-space:normal;
  text-decoration:none !important;
  text-align:left;
}

a:hover span.popup{\-moz-border-radius: 8px;}