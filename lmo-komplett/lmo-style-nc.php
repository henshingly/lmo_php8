<?
header("Content-Type: text/css");
require("init.php");
@include(PATH_TO_TEMPLATEDIR."/style.css");
?>
.message{
  color: #080;
  background-color:transparent;
}
.error{
  color: #a00;
  background-color:transparent;
}

/** Auﬂenbereich*/
.lmoMain { 
  background: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
  font-size: <?=$lmo_main_fontsize1?>;
  font-family: <?=$lmo_main_fontfamily1?>;
}
/** Auﬂenbereich ‹berschrift*/
.lmoMain h1 { 
  background: <?=$lmo_main_background2?>; 
  color: <?=$lmo_main_color2?>; 
  font-size: <?=$lmo_main_fontsize2?>; 
  font-family: <?=$lmo_main_fontfamily2?>;
}
/** Auﬂenbereich Men¸ */
.lmoMain .lmoMenu { 
  font-weight: bold; 
  background: <?=$lmo_main_background4?>; 
  color: <?=$lmo_main_color4?>; 
}
.lmoMain .lmoMenu a { 
  line-height:140%;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_main_background5?>; 
  color: <?=$lmo_main_color5?>; 
}
/** Auﬂenbereich Untermen¸ */
.lmoMain .lmoSubmenu { 
  font-weight: bold; 
  background: <?=$lmo_main_background6?>; 
  color: <?=$lmo_main_color6?>; 
}
.lmoMain .lmoSubmenu a { 
  line-height:140%;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_main_background7?>; 
  color: <?=$lmo_main_color7?>; 
}
/** Auﬂenbereich Fusszeilen */
.lmoFooter { 
  font-size: <?=$lmo_main_fontsize3?>; 
  font-weight: normal;
}
.lmoFooter a { 
  text-decoration: underline; 
  background: <?=$lmo_main_background1?>; 
  color: <?=$lmo_main_color1?>;
}

/** Ende Auﬂenbereich */
/** Mittelbereich */
.lmoMiddle { 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
  font-size: <?=$lmo_middle_fontsize1?>;
  font-weight: bold;
}
/** ‹berschrift im Mittelbereich */
.lmoMiddle h1{ 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
  font-size:<?=$lmo_main_fontsize2?>;
}
/** Links im Mittelbereich */
.lmoMiddle a {  
  line-height:150%;
  text-decoration: none; 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-weight: normal;
}
.lmoMiddle .lmoMenu {
  font-weight: bold; 
}
.lmoMiddle .lmoMenu a {
  line-height:140%;
  font-weight: normal; 
  text-decoration: none; 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>;
}

.lmoMiddle .lmoSubmenu {
  font-weight: bold; 
  
}
/** Innerer Bereich */
.lmoInner {
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>;
  font-size: <?=$lmo_inner_fontsize1?>;
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
}
.lmoInner td td{
}
.lmoInner th {
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
  margin 0 auto;
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
/*
.lmoMenu { 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-size: <?=$lmo_middle_fontsize1?>;
}
.lmoMenu, 
.lmoMenu a { 
  
}
.lmoMenu a:link,
.lmoMenu a:visited { 
  text-decoration: none; 
}
.lmoMenu a:hover, 
.lmoMenu a:active { 
  background: <?=$lmo_middle_color1?>; 
  color: <?=$lmo_middle_background1?>; 
  text-decoration: none; 
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
.lmoTabelleCleague { 
  background: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
}
.lmoTabelleCleague a {
  background: <?=$lmo_tabelle_background2?>; 
  color: <?=$lmo_tabelle_color2?>; 
  text-decoration: none;
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
.lmoTabelleUefa { 
  background: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
}
.lmoTabelleUefa a { 
  background: <?=$lmo_tabelle_background4?>; 
  color: <?=$lmo_tabelle_color4?>;
  text-decoration: none; 
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
.lmoTabelleAbsteiger { 
  background: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
}
.lmoTabelleAbsteiger a { 
  background: <?=$lmo_tabelle_background6?>; 
  color: <?=$lmo_tabelle_color6?>;
  text-decoration: none; 
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
.lmoTurnierVerlierer { 
  background: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
}
.lmoTurnierVerlierer a { 
  background: <?=$lmo_turnier_background2?>; 
  color: <?=$lmo_turnier_color2?>;
  text-decoration: none;
}

/*
.lmocross1 { 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_middle_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_kreuz_fontsize1?>; 
  font-weight: bold; 
}
.lmocross2{ 
  font-weight: normal; 
  font-size: <?=$lmo_kreuz_fontsize1?>;
}
.lmocross2, 
.lmocross2 a { 
  background: <?=$lmo_middle_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
}
.lmocross2 a:link, 
.lmocross2 a:visited { 
  text-decoration: none; 
}
.lmocross2 a:hover, 
.lmocross2 a:active { 
  background: <?=$lmo_middle_color1?>; 
  color: <?=$lmo_middle_background1?>; 
  font-weight: normal; 
  text-decoration: none; 
}
.lmocross4 { 
  background: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_kreuz_fontsize1?>; 
  font-weight: bold;
}
.lmocross5 { 
  font-weight: normal; 
  font-size: <?=$lmo_kreuz_fontsize1?>;
}
.lmocross5, 
.lmocross5 a { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>;
}
.lmocross5 a:link, 
.lmocross5 a:visited { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin1?>; 
  text-decoration: none; 
}
.lmocross5 a:hover, 
.lmocross5 a:active { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin2?>; 
  text-decoration: underline; 
}
.lmocross6 { 
  font-weight: normal; 
  font-size: <?=$lmo_kreuz_fontsize1?>;
}
.lmocross6, .lmocross6 a { 
  background: <?=$lmo_turnier_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; }
.lmocross6 a:link, 
.lmocross6 a:visited { 
  background: <?=$lmo_turnier_background1?>; 
  color: <?=$tabclin1?>; 
  text-decoration: none; }
.lmocross6 a:hover, 
.lmocross6 a:active { 
  background: <?=$lmo_turnier_background1?>; 
  color: <?=$tabclin2?>; 
  text-decoration: underline; 
  }
.lmocalni { 
  background: <?=$lmo_inner_background2?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: bold; }
.lmocalat { 
    
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: bold; }
.lmocalat a:link, 
.lmocalat a:visited { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin1?>; 
  font-weight: normal; 
  text-decoration: none; }
.lmocalat a:hover, 
.lmocalat a:active { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin2?>; 
  font-weight: normal; 
  text-decoration: underline; 
  }
.lmocalht { 
    
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: bold; }
.lmocalht a:link, 
.lmocalht a:visited { 
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$tabclin1?>; 
  font-weight: normal; 
  text-decoration: none; }
.lmocalht a:hover, 
.lmocalht a:active { 
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$tabclin2?>; 
  font-weight: normal; 
  text-decoration: underline; 
  }
.lmocalwe { 
    
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabwcolo?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: bold; }
.lmocalwe a:link, 
.lmocalwe a:visited { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin1?>; 
  font-weight: normal; 
  text-decoration: none; }
.lmocalwe a:hover, 
.lmocalwe a:active { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$tabclin2?>; 
  font-weight: normal; 
  text-decoration: underline; 
  }
.lmocalhe { 
    
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$tabwcolo?>; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: bold; }
.lmocalhe a:link, 
.lmocalhe a:visited  { 
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$tabclin1?>; 
  font-weight: normal; 
  text-decoration: none; 
}
.lmocalhe a:hover, 
.lmocalhe a:active { 
  background: <?=$lmo_kreuzkal_background1?>; 
  color: <?=$tabclin2?>; 
  font-weight: normal; 
  text-decoration: underline; 
}
.lmotext { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  text-align: justify; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size: <?=$lmo_inner_fontsize1?>; 
  font-weight: normal; 
}
.lmofett { 
  background: <?=$lmo_inner_background1?>; 
  color: <?=$lmo_inner_color1?>; 
  text-align: justify; 
  font-family: <?=$lmo_inner_fontfamily1?>; 
  font-size:85%; 
  font-weight: bold; 
}
.lmoadminli { 
  padding-bottom: 4px; 
}
*/

a.colorpicker {
  font-size:15px; 
  text-decoration: none;
}
a.colorpicker table {
  background:#fff;
  color:#000;
}

a span.popup, a:link span.popup{
	display: none;
}