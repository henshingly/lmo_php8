<?
header("Content-Type: text/css");
require("init.php");
echo <<< STYLE
FORM { padding: 0; margin: 0; }
TABLE { padding: 0; margin: 0; }
  .lmomaina { background: $tababack; }
  .lmosta { background: $tabbback; }
  .lmostb {  background: $tabcback; }

  .lmomain0 {  background: $tababack; color: $tabacoti; font-family: $tabafont; font-size: $tabatite; font-weight: bold; }
  .lmomain1 {  background: $tababack; color: $tabacolo; font-family: $tabafont; font-size: $tabasize; font-weight: bold; }
    .lmomain1 a:link { background: $tababack; color: $tabacolo; font-weight: normal; text-decoration: none; }
    .lmomain1 a:visited { background: $tababack; color: $tabacolo; font-weight: normal; text-decoration: none; }
    .lmomain1 a:active { background: $tabacolo; color: $tababack; font-weight: normal; text-decoration: none; }
    .lmomain1 a:hover { background: $tabacolo; color: $tababack; font-weight: normal; text-decoration: none; }
  .lmomain2 {  background: $tababack; color: $tabacolo; font-family: $tabafont; font-size: $tabaupda; font-weight: normal; }
  .lmost0 {  background: $tabbback; color: $tabccolo; font-family: $tabbfont; font-size: $tabbsize; font-weight: normal; }
    .lmost0 a:link { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmost0 a:visited { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmost0 a:active { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
    .lmost0 a:hover { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
  .lmost0a {  background: $tabbback; color: $tabbcolo; font-family: $tabbfont; font-size: $tabbsize; font-weight: bold; }
    .lmost0a a:link { background: $tabbback; color: $tabbcolo; font-weight: bold; text-decoration: none; }
    .lmost0a a:visited { background: $tabbback; color: $tabbcolo; font-weight: bold; text-decoration: none; }
    .lmost0a a:active { background: $tabbcolo; color: $tabbback; font-weight: bold; text-decoration: none; }
    .lmost0a a:hover { background: $tabbcolo; color: $tabbback; font-weight: bold; text-decoration: none; }
  .lmost1 {  background: $tabbback; color: $tabbcolo; font-family: $tabbfont; font-size: $tabbsize; font-weight: bold; }
  .lmost2 {  background: $tabbback; color: $tabbcolo; font-family: $tabbfont; font-size: $tabbsize; font-weight: normal; }
    .lmost2 a:link { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmost2 a:visited { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmost2 a:active { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
    .lmost2 a:hover { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
  .lmost3 {  background: $tabbback; }
  .lmost4 {  background: $tabcgrey; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
    .lmost4 a:link { background: $tabcgrey; color: $tabccolo; font-weight: bold; text-decoration: none; }
    .lmost4 a:visited { background: $tabcgrey; color: $tabccolo; font-weight: bold; text-decoration: none; }
    .lmost4 a:active { background: $tabcgrey; color: $tabccolo; font-weight: bold; text-decoration: overline underline; }
    .lmost4 a:hover { background: $tabcgrey; color: $tabccolo; font-weight: bold; text-decoration: overline underline; }
  .lmost5 {  background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmost5 a:link { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost5 a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost5 a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmost5 a:hover { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmost7 {  background: $tabftur1; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmost7 a:link { background: $tabftur1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost7 a:visited { background: $tabftur1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost7 a:active { background: $tabftur1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmost7 a:hover { background: $tabftur1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmost8 {  background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmost9a {  background: $tabftur2; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmost9a a:link { background: $tabftur2; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9a a:visited { background: $tabftur2; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9a a:active { background: $tabftur2; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmost9a a:hover { background: $tabftur2; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmost9b {  background: $tabftur3; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmost9b a:link { background: $tabftur3; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9b a:visited { background: $tabftur3; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9b a:active { background: $tabftur3; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmost9b a:hover { background: $tabftur3; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmost9c {  background: $tabftur4; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmost9c a:link { background: $tabftur4; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9c a:visited { background: $tabftur4; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmost9c a:active { background: $tabftur4; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmost9c a:hover { background: $tabftur4; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab1 {  background: $tabftab1; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab1 a:link { background: $tabftab1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab1 a:visited { background: $tabftab1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab1 a:active { background: $tabftab1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab1 a:hover { background: $tabftab1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab2 {  background: $tabftab2; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab2 a:link { background: $tabftab2; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab2 a:visited { background: $tabftab2; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab2 a:active { background: $tabftab2; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab2 a:hover { background: $tabftab2; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab3 {  background: $tabftab3; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab3 a:link { background: $tabftab3; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab3 a:visited { background: $tabftab3; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab3 a:active { background: $tabftab3; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab3 a:hover { background: $tabftab3; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab4 {  background: $tabftab4; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab4 a:link { background: $tabftab4; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab4 a:visited { background: $tabftab4; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab4 a:active { background: $tabftab4; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab4 a:hover { background: $tabftab4; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab5 {  background: $tabftab6; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab5 a:link { background: $tabftab6; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab5 a:visited { background: $tabftab6; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab5 a:active { background: $tabftab6; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab5 a:hover { background: $tabftab6; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab8 {  background: $tabftab5; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
    .lmotab8 a:link { background: $tabftab5; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab8 a:visited { background: $tabftab5; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmotab8 a:active { background: $tabftab5; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmotab8 a:hover { background: $tabftab5; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotab6 {  background: $tabftab7; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
  .lmotab7 {  background: $tabftab8; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
  .lmocross1 {  background: $tabbback; color: $tabbcolo; font-family: $tabcfont; font-size: 75%; font-weight: bold; }
  .lmocross2 {  background: $tabbback; color: $tabccolo; font-family: $tabcfont; font-size: 75%; font-weight: normal; }
    .lmocross2 a:link { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmocross2 a:visited { background: $tabbback; color: $tabbcolo; font-weight: normal; text-decoration: none; }
    .lmocross2 a:active { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
    .lmocross2 a:hover { background: $tabbcolo; color: $tabbback; font-weight: normal; text-decoration: none; }
  .lmocross4 {  background: $tabcgrey; color: $tabccolo; font-family: $tabcfont; font-size: 75%; font-weight: bold; }
  .lmocross5 {  background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: 75%; font-weight: normal; }
    .lmocross5 a:link { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocross5 a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocross5 a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocross5 a:hover { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmocross6 {  background: $tabftur1; color: $tabccolo; font-family: $tabcfont; font-size: 75%; font-weight: normal; }
    .lmocross6 a:link { background: $tabftur1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocross6 a:visited { background: $tabftur1; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocross6 a:active { background: $tabftur1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocross6 a:hover { background: $tabftur1; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmocalni {  background: $tabcgrey; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
  .lmocalat { border: 1px solid $tabcgrey;  background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
    .lmocalat a:link { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalat a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalat a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocalat a:hover { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmocalht { border: 1px solid $tabcgrey;  background: $tabhback; color: $tabccolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
    .lmocalht a:link { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalht a:visited { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalht a:active { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocalht a:hover { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmocalwe { border: 1px solid $tabcgrey;  background: $tabcback; color: $tabwcolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
    .lmocalwe a:link { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalwe a:visited { background: $tabcback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalwe a:active { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocalwe a:hover { background: $tabcback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmocalhe { border: 1px solid $tabcgrey;  background: $tabhback; color: $tabwcolo; font-family: $tabcfont; font-size: $tabcsize; font-weight: bold; }
    .lmocalhe a:link { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalhe a:visited { background: $tabhback; color: $tabclin1; font-weight: normal; text-decoration: none; }
    .lmocalhe a:active { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
    .lmocalhe a:hover { background: $tabhback; color: $tabclin2; font-weight: normal; text-decoration: overline underline; }
  .lmotext { background: $tabcback; color: $tabccolo; text-align: justify; font-family: $tabcfont; font-size: $tabcsize; font-weight: normal; }
  .lmofett { background: $tabcback; color: $tabccolo; font-family: $tabcfont; font-weight: bold; }
STYLE;
?>