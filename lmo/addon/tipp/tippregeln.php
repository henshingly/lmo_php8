<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
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
  */


require(__DIR__ . '/../../init.php');
$_SESSION['lmouserlang'] = isset($_GET['lmouserlang']) ? $_GET['lmouserlang'] : (isset($_SESSION['lmouserlang']) ? $_SESSION['lmouserlang'] : 'Deutsch');

$lang=array(
  'Deutsch'=>array(
    'LANG'=>'DE',
    'HEADER'=>'Tippspielregeln',
    'ABS_1'=>'Anleitung für das Tippspiel',
    'ABS_1_text1'=>'Nach der  Anmeldung zum Tippspiel hat der Tipper die Möglichkeit, eine <strong>oder</strong> mehrere Tippspiele zu abonnieren.',
    'ABS_2'=>'Verfahren zum Abonnieren und Spielen einzelner Ligen',
    'ABS_2_text1'=>'Anmelden und Verwalten',
    'ABS_2_text2'=>'Im Login-Bereich auf \'<strong>anmelden</strong>\' klicken .',
    'ABS_2_text3'=>'Alle Anmeldedaten eintragen und auswählen, welche Liga Sie abonnieren möchten.<br><strong>Hinweis</strong>: Weitere Ligen können Sie jederzeit nach der Erstanmeldung unter Ihrem Usernamen nachträglich abonnieren!',
    'ABS_2_text4'=>'Nach der Anmeldung sind Sie eingeloggt bzw. Sie können sich jetzt jederzeit mit Ihrem Nickname einloggen.',
    'ABS_2_text5'=>'Im User-Bereich des Tippspiels können Sie:',
    'ABS_2_text6'=>'Eine abonnierte <strong>Liga tippen</strong>',
    'ABS_2_text7'=>'Punktstände anschauen',
    'ABS_2_text8'=>'Ihre Daten ändern',
    'ABS_2_text9'=>'andere bzw. neue Ligen in Ihren Tippschein aufnehmen',
    'ABS_2_text10'=>'Passwort ändern',
    'ABS_2_text11'=>'<strong>Tipp-Account löschen</strong> (<strong>Achtung</strong>: Alle abonnierten Tippspiele Ihres Nicknames werden gelöscht!)',
    'ABS_2_text12'=>'Aus dem Tippspiel ausloggen',
    'ABS_2_text13'=>'Liga tippen',
    'ABS_2_text14'=>'Nach dem Einloggen im Tippspielbereich eine abonnierte Liga zum Tippen auswählen.',
    'ABS_2_text15'=>'Im Ansetzungsbereich können Sie nun Ihre Tipps für die einzelnen Spieltage abgeben.',
    'ABS_2_text16'=>'Nach Eingabe der Tipps <strong>eines Spieltages</strong> klicken Sie auf <strong>Tipps speichern</strong>',
    'ABS_2_text17'=>'Sie können jetzt auf einen anderen Spieltag wechseln und weitere Tipps abgeben.',
    'ABS_2_text18'=>'Es besteht auch die Möglichkeit pro Spieltag einen <strong>Joker</strong> zu setzen. Die für diesen Spieltag gewonnen Punkte werden dann mit einem bestimmten Faktor multipliziert.',
    'ABS_2_text19'=>'Hinweise zur Tippabgabe',
    'ABS_2_text20'=>'Die Tippzeit läuft für jedes Spiel einzeln ab.',
    'ABS_2_text21'=>'Ablauf der Tippzeit ist jeweils',
    'ABS_2_text21_1'=>'Minuten vor Anpfiff.',
    'ABS_2_text22'=>'Sollten <strong>ohne</strong> unsere Kenntnis einzelne Spiele vorgezogen werden, bitten wir das zu entschuldigen. Wir versuchen jedoch immer <strong>vor</strong> einem Spieltag alle veränderten Anstoßzeiten zu aktualisieren.',
    'ABS_3'=>'Spielwertung und Ligawertung',
    'ABS_3_text1'=>'Die Spielwertung (Punktverteilung)',
    'ABS_3_text2'=>'Ergebnis richtig',
    'ABS_3_text2_0'=>'Punkt',
    'ABS_3_text2_1'=>'Punkte',
    'ABS_3_text2_2'=>'Faktor',
    'ABS_3_text3'=>'nur Tendenz und Tordifferenz richtig',
    'ABS_3_text4'=>'nur Tendenz richtig',
    'ABS_3_text5'=>'nur eine Toranzahl richtig',
    'ABS_3_text6'=>'Jokermultiplikator',
    'ABS_3_text6_1'=>'Bonus für richtigen Unentschieden-Tipp',
    'ABS_3_text7'=>'Es besteht auch die Möglichkeit pro Spieltag einen <strong>Joker</strong> zu setzen. Die für diesen Spieltag gewonnen Punkte werden dann doppelt gewertet.',
    'ABS_3_text8'=>'Die Liga- und Spieltagswertung',
    'ABS_3_text9'=>'Die Gesamtligawertung erhalten Sie, wenn Sie in der Tippspiel-Übersicht eine abonnierte Liga unter dem Punkt: <strong>Punktestände anschauen</strong> auswählen.',
    'ABS_3_text10'=>'Sie erreichen die Gesamtligawertung auch, wenn Sie im Tippbereich auf - <strong>Ligawertung</strong> wechseln',
    'ABS_3_text11'=>'Die erzielten Punkte Ihrer <strong>einzelnen</strong> Spiele können Sie einsehen, wenn Sie im Tippbereich einer Liga einen <strong>absolvierten Spieltag</strong> aufrufen.',
    'ABS_3_text12'=>'<strong>Gesamtsieger</strong> ist, wer nach einer Spielsaison die meisten Punkte auf seinem Spielkonto verbuchen kann.',
    'ABS_3_text13'=>'Zusätzlich können unter <strong>Tippeinsicht</strong> die Tipps der Mitspieler eingesehen werden',
    'ABS_3_text14'=>'Die <strong>Tipp-Tabelle</strong> ist eine Zusatzanzeige, also eine Tabelle erzeugt nach Ihren abgegebenen Tipps',
    'ABS_3_text15'=>'Hinweise zum Zeitpunkt der Tippauswertung',
    'ABS_3_text16'=>'Die technische Auswertung der Spieltipps erfolgt in der Regel nach jedem absolvierten Spieltag.',
    'ABS_3_text17'=>'Bitte beachten Sie, dass sich aus organisatorischen Gründen die Tippauswertung auch einmal um <strong>1 bis 2 Tage</strong> verzögern kann.',
    'ABS_4'=>'Haftungsausschluß',
    'ABS_4_text1'=>'Für etwaige Übertragungsfehler und sonstige technische Schwierigkeiten ist der Veranstalter in keiner Weise verantwortlich zu machen.',
    'ABS_4_text2'=>'Mit der Anmeldung zum Spiel akzeptieren Sie die Bedingungen. Dieses Spiel dient dem reinen Unterhaltungszweck. Wer hackt, verfälscht, oder sich mehrmals unter verschiedenen Namen anmeldet, wird mit Spielsperre bestraft.',
    'ABS_4_text3'=>'Der Rechtsweg ist ausgeschlossen.',
  ),
  'English'=>array(
    'LANG'=>'EN',
    'HEADER'=>'Prediction Game Rules',
    'ABS_1'=>'Instructions for the Prediction Game',
    'ABS_1_text1'=>'After registering for the prediction game, the user has the option to subscribe to one <strong>or</strong> several prediction leagues.',
    'ABS_2'=>'Procedure for subscribing and playing individual leagues',
    'ABS_2_text1'=>'Registration and Management',
    'ABS_2_text2'=>'Click on \'<strong>register</strong>\' in the login area.',
    'ABS_2_text3'=>'Enter all registration data and select which league you would like to subscribe to.<br><strong>Note</strong>: You can subscribe to additional leagues at any time after the initial registration under your username!',
    'ABS_2_text4'=>'After registering, you are logged in, or you can log in at any time with your nickname.',
    'ABS_2_text5'=>'In the user area of the prediction game you can:',
    'ABS_2_text6'=>'Submit <strong>predictions for a league</strong> you subscribed to',
    'ABS_2_text7'=>'View scoreboards',
    'ABS_2_text8'=>'Change your data',
    'ABS_2_text9'=>'Add other or new leagues to your prediction sheet',
    'ABS_2_text10'=>'Change password',
    'ABS_2_text11'=>'<strong>Delete prediction account</strong> (<strong>Warning</strong>: All subscribed prediction games of your nickname will be deleted!)',
    'ABS_2_text12'=>'Log out of the prediction game',
    'ABS_2_text13'=>'Predict league',
    'ABS_2_text14'=>'After logging in, select a subscribed league to predict in the prediction area.',
    'ABS_2_text15'=>'In the fixtures area, you can now submit your predictions for the individual matchdays.',
    'ABS_2_text16'=>'After entering the predictions for <strong>one matchday</strong>, click on <strong>save predictions</strong>',
    'ABS_2_text17'=>'You can now switch to another matchday and submit further predictions.',
    'ABS_2_text18'=>'It is also possible to set a <strong>Joker</strong> per matchday. The points won for this matchday will then be multiplied by a certain factor.',
    'ABS_2_text19'=>'Notes on submitting predictions',
    'ABS_2_text20'=>'The prediction time expires for each game individually.',
    'ABS_2_text21'=>'The prediction deadline is always',
    'ABS_2_text21_1'=>'minutes before kick-off.',
    'ABS_2_text22'=>'Should individual games be brought forward <strong>without</strong> our knowledge, we apologize for this. However, we always try to update all changed kick-off times <strong>before</strong> a matchday.',
    'ABS_3'=>'Game scoring and league standings',
    'ABS_3_text1'=>'Game scoring (Point distribution)',
    'ABS_3_text2'=>'Correct result',
    'ABS_3_text2_0'=>'Point',
    'ABS_3_text2_1'=>'Points',
    'ABS_3_text2_2'=>'Factor',
    'ABS_3_text3'=>'Correct tendency and goal difference only',
    'ABS_3_text4'=>'Correct tendency only',
    'ABS_3_text5'=>'Only one goal count correct',
    'ABS_3_text6'=>'Joker multiplier',
    'ABS_3_text6_1'=>'Bonus for correct draw prediction',
    'ABS_3_text7'=>'It is also possible to set a <strong>Joker</strong> per matchday. The points won for this matchday will then count double.',
    'ABS_3_text8'=>'League and matchday standings',
    'ABS_3_text9'=>'You can access the overall league standings by selecting a subscribed league in the prediction overview under the item: <strong>View scores</strong>.',
    'ABS_3_text10'=>'You can also reach the overall league standings by switching to - <strong>League standings</strong> in the prediction area.',
    'ABS_3_text11'=>'You can view the points achieved for your <strong>individual</strong> games by calling up a <strong>completed matchday</strong> in the prediction area of a league.',
    'ABS_3_text12'=>'The <strong>overall winner</strong> is the person who has the most points in their account after a season.',
    'ABS_3_text13'=>'In addition, the predictions of other players can be viewed under <strong>Prediction insights</strong>',
    'ABS_3_text14'=>'The <strong>Prediction table</strong> is an additional display, i.e., a table generated based on your submitted predictions',
    'ABS_3_text15'=>'Notes on the timing of prediction evaluation',
    'ABS_3_text16'=>'The technical evaluation of the match predictions usually takes place after each completed matchday.',
    'ABS_3_text17'=>'Please note that for organizational reasons, the prediction evaluation may occasionally be delayed by <strong>1 to 2 days</strong>.',
    'ABS_4'=>'Disclaimer',
    'ABS_4_text1'=>'The organizer is in no way responsible for any transmission errors or other technical difficulties.',
    'ABS_4_text2'=>'By registering for the game, you accept the terms and conditions. This game is for entertainment purposes only. Anyone who hacks, falsifies, or registers several times under different names will be punished with a game ban.',
    'ABS_4_text3'=>'Legal recourse is excluded.',
  ),
  'Francais'=>array(
    'LANG'=>'FR',
    'HEADER'=>'Règles du jeu de pronostics',
    'ABS_1'=>'Instructions pour le jeu de pronostics',
    'ABS_1_text1'=>'Après l\'inscription au jeu de pronostics, le joueur a la possibilité de s\'abonner à un <strong>ou</strong> plusieurs championnats.',
    'ABS_2'=>'Procédure pour s\'abonner et jouer aux différentes ligues',
    'ABS_2_text1'=>'Inscription et gestion',
    'ABS_2_text2'=>'Dans la zone de connexion, cliquez sur \'<strong>s\'inscrire</strong>\'.',
    'ABS_2_text3'=>'Saisissez toutes les données d\'inscription et sélectionnez la ligue à laquelle vous souhaitez vous abonner.<br><strong>Remarque</strong> : vous pouvez vous abonner à d\'autres ligues à tout moment après l\'inscription initiale sous votre nom d\'utilisateur !',
    'ABS_2_text4'=>'Après l\'inscription, vous êtes connecté ou vous pouvez vous connecter à tout moment avec votre pseudonyme.',
    'ABS_2_text5'=>'Dans la zone utilisateur du jeu de pronostics, vous pouvez :',
    'ABS_2_text6'=>'Faire un <strong>pronostic pour une ligue</strong> abonnée',
    'ABS_2_text7'=>'Consulter les scores',
    'ABS_2_text8'=>'Modifier vos données',
    'ABS_2_text9'=>'Ajouter d\'autres ou de nouvelles ligues à votre fiche de pronostics',
    'ABS_2_text10'=>'Changer le mot de passe',
    'ABS_2_text11'=>'<strong>Supprimer le compte</strong> (<strong>Attention</strong> : tous les jeux de pronostics abonnés sous votre pseudo seront supprimés !)',
    'ABS_2_text12'=>'Se déconnecter du jeu de pronostics',
    'ABS_2_text13'=>'Pronostiquer la ligue',
    'ABS_2_text14'=>'Après vous être connecté, choisissez une ligue abonnée dans la zone de pronostics.',
    'ABS_2_text15'=>'Dans la zone des rencontres, vous pouvez maintenant soumettre vos pronostics pour les différentes journées de championnat.',
    'ABS_2_text16'=>'Après avoir saisi les pronostics d\'<strong>une journée</strong>, cliquez sur <strong>enregistrer les pronostics</strong>',
    'ABS_2_text17'=>'Vous pouvez maintenant passer à une autre journée et soumettre d\'autres pronostics.',
    'ABS_2_text18'=>'Il est également possible de placer un <strong>Joker</strong> par journée. Les points gagnés pour cette journée seront alors multipliés par un certain facteur.',
    'ABS_2_text19'=>'Conseils pour la saisie des pronostics',
    'ABS_2_text20'=>'Le délai de pronostic expire individuellement pour chaque match.',
    'ABS_2_text21'=>'Le délai d\'expiration est de',
    'ABS_2_text21_1'=>'minutes avant le coup d\'envoi.',
    'ABS_2_text22'=>'Si certains matchs sont avancés <strong>sans</strong> que nous en soyons informés, nous vous prions de nous en excuser. Nous essayons toutefois de mettre à jour tous les horaires de coup d\'envoi modifiés <strong>avant</strong> chaque journée.',
    'ABS_3'=>'Évaluation du jeu et classement de la ligue',
    'ABS_3_text1'=>'Évaluation du jeu (distribution des points)',
    'ABS_3_text2'=>'Résultat correct',
    'ABS_3_text2_0'=>'Point',
    'ABS_3_text2_1'=>'Points',
    'ABS_3_text2_2'=>'Facteur',
    'ABS_3_text3'=>'Seulement tendance et différence de buts correctes',
    'ABS_3_text4'=>'Seulement tendance correcte',
    'ABS_3_text5'=>'Seulement un nombre de buts correct',
    'ABS_3_text6'=>'Multiplicateur Joker',
    'ABS_3_text6_1'=>'Bonus pour un pronostic de match nul correct',
    'ABS_3_text7'=>'Il est également possible de placer un <strong>Joker</strong> par journée. Les points gagnés pour cette journée comptent alors double.',
    'ABS_3_text8'=>'Évaluation de la ligue et de la journée',
    'ABS_3_text9'=>'Vous obtenez le classement général de la ligue en sélectionnant une ligue abonnée dans l\'aperçu sous le point : <strong>consulter les scores</strong>.',
    'ABS_3_text10'=>'Vous pouvez également accéder au classement général de la ligue en passant à <strong>Classement de la ligue</strong> dans la zone de pronostics.',
    'ABS_3_text11'=>'Vous pouvez consulter les points obtenus pour vos matchs <strong>individuels</strong> en appelant une <strong>journée terminée</strong> dans la zone de pronostics d\'une ligue.',
    'ABS_3_text12'=>'Le <strong>vainqueur général</strong> est celui qui comptabilise le plus de points sur son compte à la fin de la saison.',
    'ABS_3_text13'=>'De plus, les pronostics des autres joueurs peuvent être consultés sous <strong>Aperçu des pronostics</strong>.',
    'ABS_3_text14'=>'Le <strong>Tableau de pronostics</strong> est un affichage supplémentaire, c\'est-à-dire un tableau généré selon vos pronostics saisis.',
    'ABS_3_text15'=>'Remarques sur le moment de l\'évaluation des pronostics',
    'ABS_3_text16'=>'L\'évaluation technique des pronostics a généralement lieu après chaque journée de championnat terminée.',
    'ABS_3_text17'=>'Veuillez noter que pour des raisons d\'organisation, l\'évaluation des pronostics peut parfois être retardée de <strong>1 à 2 jours</strong>.',
    'ABS_4'=>'Exclusion de responsabilité',
    'ABS_4_text1'=>'L\'organisateur ne peut en aucun cas être tenu responsable d\'éventuelles erreurs de transmission ou d\'autres difficultés techniques.',
    'ABS_4_text2'=>'En vous inscrivant au jeu, vous acceptez les conditions. Ce jeu est purement destiné au divertissement. Quiconque pirate, falsifie ou s\'inscrit plusieurs fois sous différents noms sera sanctionné par une exclusion du jeu.',
    'ABS_4_text3'=>'Tout recours juridique est exclu.',
  ),
  'Nederlands'=>array(
    'LANG'=>'NL',
    'HEADER'=>'Regels van de pool',
    'ABS_1'=>'Handleiding voor de voetbalpool',
    'ABS_1_text1'=>'Na aanmelding voor de voetbalpool heeft de deelnemer de mogelijkheid om zich op één <strong>of</strong> meerdere competities te abonneren.',
    'ABS_2'=>'Procedure voor het abonneren en spelen van individuele competities',
    'ABS_2_text1'=>'Aanmelden en beheren',
    'ABS_2_text2'=>'Klik in het login-gedeelte op \'<strong>aanmelden</strong>\'.',
    'ABS_2_text3'=>'Vul alle aanmeldgegevens in en kies welke competitie u wilt abonneren.<br><strong>Let op</strong>: U kunt na de eerste aanmelding op elk gewenst moment extra competities toevoegen onder uw gebruikersnaam!',
    'ABS_2_text4'=>'Na aanmelding bent u ingelogd of kunt u op elk moment inloggen met uw gebruikersnaam.',
    'ABS_2_text5'=>'In het gebruikersgedeelte van de voetbalpool kunt u:',
    'ABS_2_text6'=>'Een <strong>voorspelling doen</strong> voor een geabonneerde competitie',
    'ABS_2_text7'=>'Puntenstanden bekijken',
    'ABS_2_text8'=>'Uw gegevens wijzigen',
    'ABS_2_text9'=>'Andere of nieuwe competities toevoegen aan uw pool-overzicht',
    'ABS_2_text10'=>'Wachtwoord wijzigen',
    'ABS_2_text11'=>'<strong>Account verwijderen</strong> (<strong>Let op</strong>: Alle geabonneerde competities van uw gebruikersnaam worden verwijderd!)',
    'ABS_2_text12'=>'Uitloggen uit de voetbalpool',
    'ABS_2_text13'=>'Voorspelling doen',
    'ABS_2_text14'=>'Kies na het inloggen in het pool-gedeelte een geabonneerde competitie om uw voorspellingen door te geven.',
    'ABS_2_text15'=>'In het speelschema-gedeelte kunt u nu uw voorspellingen voor de individuele speelrondes invullen.',
    'ABS_2_text16'=>'Klik na het invoeren van de voorspellingen van <strong>één speelronde</strong> op <strong>voorspellingen opslaan</strong>',
    'ABS_2_text17'=>'U kunt nu naar een andere speelronde gaan om meer voorspellingen te doen.',
    'ABS_2_text18'=>'Het is ook mogelijk om per speelronde een <strong>Joker</strong> in te zetten. De gewonnen punten voor deze speelronde worden dan met een bepaalde factor vermenigvuldigd.',
    'ABS_2_text19'=>'Aanwijzingen voor het invullen',
    'ABS_2_text20'=>'De tijd voor het voorspellen verloopt per wedstrijd afzonderlijk.',
    'ABS_2_text21'=>'De deadline voor de voorspelling is telkens',
    'ABS_2_text21_1'=>'minuten voor de aftrap.',
    'ABS_2_text22'=>'Mochten er <strong>buiten</strong> onze medeweten wedstrijden worden vervroegd, dan vragen wij hiervoor uw begrip. We proberen echter altijd <strong>vóór</strong> een speelronde alle gewijzigde aanvangstijden bij te werken.',
    'ABS_3'=>'Puntentelling en competitieklassement',
    'ABS_3_text1'=>'De spelwaardering (puntentelling)',
    'ABS_3_text2'=>'Uitslag correct',
    'ABS_3_text2_0'=>'Punt',
    'ABS_3_text2_1'=>'Punten',
    'ABS_3_text2_2'=>'Factor',
    'ABS_3_text3'=>'Alleen tendens en doelpuntsaldo correct',
    'ABS_3_text4'=>'Alleen tendens correct',
    'ABS_3_text5'=>'Alleen het aantal doelpunten van één team correct',
    'ABS_3_text6'=>'Joker-vermenigvuldiger',
    'ABS_3_text6_1'=>'Bonus voor een correcte voorspelling van een gelijkspel',
    'ABS_3_text7'=>'Het is ook mogelijk om per speelronde een <strong>Joker</strong> in te zetten. De punten voor die speelronde tellen dan dubbel.',
    'ABS_3_text8'=>'De competitie- en speelrondewaardering',
    'ABS_3_text9'=>'U vindt het algemene competitieklassement als u in het overzicht een competitie kiest onder het punt: <strong>Puntenstanden bekijken</strong>.',
    'ABS_3_text10'=>'U kunt het klassement ook bereiken door in het pool-gedeelte naar <strong>Competitiestand</strong> te gaan.',
    'ABS_3_text11'=>'De behaalde punten van uw <strong>afzonderlijke</strong> wedstrijden kunt u inzien door in een competitie een <strong>voltooide speelronde</strong> te openen.',
    'ABS_3_text12'=>'De <strong>algehele winnaar</strong> is degene die na een heel seizoen de meeste punten op zijn account heeft staan.',
    'ABS_3_text13'=>'Daarnaast kunnen onder <strong>Inzicht in voorspellingen</strong> de voorspellingen van medespelers worden bekeken.',
    'ABS_3_text14'=>'De <strong>Pool-tabel</strong> is een extra weergave, een tabel gegenereerd op basis van uw eigen voorspellingen.',
    'ABS_3_text15'=>'Opmerkingen over de verwerkingstijd',
    'ABS_3_text16'=>'De technische verwerking van de voorspellingen vindt meestal plaats na elke voltooide speelronde.',
    'ABS_3_text17'=>'Houd er rekening mee dat de verwerking door organisatorische redenen incidenteel <strong>1 tot 2 dagen</strong> vertraging kan oplopen.',
    'ABS_4'=>'Disclaimer',
    'ABS_4_text1'=>'De organisator is op geen enkele wijze verantwoordelijk voor eventuele transmissiefouten of andere technische problemen.',
    'ABS_4_text2'=>'Door u aan te melden voor het spel accepteert u de voorwaarden. Dit spel is puur bedoeld voor amusementsdoeleinden. Wie hackt, vervalst of zich meerdere keren onder verschillende namen aanmeldt, wordt uitgesloten van deelname.',
    'ABS_4_text3'=>'Juridische stappen zijn uitgesloten.',
  ),
    'Espanol'=>array(
    'LANG'=>'ES',
    'HEADER'=>'Reglas de la quiniela',
    'ABS_1'=>'Instrucciones para el juego de pronósticos',
    'ABS_1_text1'=>'Tras registrarse en el juego de pronósticos, el usuario tiene la posibilidad de suscribirse a una <strong>o</strong> varias ligas.',
    'ABS_2'=>'Procedimiento para suscribirse y jugar en ligas individuales',
    'ABS_2_text1'=>'Registro y gestión',
    'ABS_2_text2'=>'En el área de inicio de sesión, haga clic en \'<strong>registrarse</strong>\'.',
    'ABS_2_text3'=>'Introduzca todos los datos de registro y seleccione la liga a la que desea suscribirse.<br><strong>Nota</strong>: ¡Puede suscribirse a más ligas en cualquier momento después del registro inicial bajo su nombre de usuario!',
    'ABS_2_text4'=>'Después del registro, estará conectado o podrá iniciar sesión en cualquier momento con su apodo.',
    'ABS_2_text5'=>'En el área de usuario del juego de pronósticos puede:',
    'ABS_2_text6'=>'Hacer <strong>pronósticos para una liga</strong> suscrita',
    'ABS_2_text7'=>'Ver las puntuaciones',
    'ABS_2_text8'=>'Cambiar sus datos',
    'ABS_2_text9'=>'Añadir otras ligas o ligas nuevas a su boleto de pronósticos',
    'ABS_2_text10'=>'Cambiar contraseña',
    'ABS_2_text11'=>'<strong>Eliminar cuenta</strong> (<strong>Atención</strong>: ¡Se borrarán todos los juegos suscritos de su apodo!)',
    'ABS_2_text12'=>'Cerrar sesión en el juego de pronósticos',
    'ABS_2_text13'=>'Pronosticar liga',
    'ABS_2_text14'=>'Después de iniciar sesión, seleccione una liga suscrita en el área de pronósticos.',
    'ABS_2_text15'=>'En el área de encuentros, ahora puede enviar sus pronósticos para las jornadas individuales.',
    'ABS_2_text16'=>'Después de introducir los pronósticos de <strong>una jornada</strong>, haga clic en <strong>guardar pronósticos</strong>',
    'ABS_2_text17'=>'Ahora puede cambiar a otra jornada y enviar más pronósticos.',
    'ABS_2_text18'=>'También existe la posibilidad de colocar un <strong>Joker</strong> por jornada. Los puntos ganados en esa jornada se multiplicarán por un factor determinado.',
    'ABS_2_text19'=>'Notas sobre el envío de pronósticos',
    'ABS_2_text20'=>'El tiempo de pronóstico expira para cada partido individualmente.',
    'ABS_2_text21'=>'El plazo de pronóstico finaliza siempre',
    'ABS_2_text21_1'=>'minutos antes del saque inicial.',
    'ABS_2_text22'=>'Si se adelantan partidos <strong>sin</strong> nuestro conocimiento, pedimos disculpas. Sin embargo, siempre intentamos actualizar todos los horarios de inicio modificados <strong>antes</strong> de cada jornada.',
    'ABS_3'=>'Valoración del juego y de la liga',
    'ABS_3_text1'=>'Valoración del juego (distribución de puntos)',
    'ABS_3_text2'=>'Resultado correcto',
    'ABS_3_text2_0'=>'Punto',
    'ABS_3_text2_1'=>'Puntos',
    'ABS_3_text2_2'=>'Factor',
    'ABS_3_text3'=>'Solo tendencia y diferencia de goles correcta',
    'ABS_3_text4'=>'Solo tendencia correcta',
    'ABS_3_text5'=>'Solo un número de goles correcto',
    'ABS_3_text6'=>'Multiplicador de Joker',
    'ABS_3_text6_1'=>'Bono por pronóstico de empate correcto',
    'ABS_3_text7'=>'También existe la posibilidad de colocar un <strong>Joker</strong> por jornada. Los puntos ganados en esa jornada valdrán el doble.',
    'ABS_3_text8'=>'Valoración de la liga y de la jornada',
    'ABS_3_text9'=>'Obtendrá la clasificación general de la liga si selecciona una liga suscrita en el resumen bajo el punto: <strong>Ver puntuaciones</strong>.',
    'ABS_3_text10'=>'También puede acceder a la clasificación general si cambia a <strong>Clasificación de la liga</strong> en el área de pronósticos.',
    'ABS_3_text11'=>'Puede ver los puntos obtenidos en sus partidos <strong>individuales</strong> consultando una <strong>jornada completada</strong> en el área de pronósticos de una liga.',
    'ABS_3_text12'=>'El <strong>ganador total</strong> es quien acumule más puntos en su cuenta después de una temporada.',
    'ABS_3_text13'=>'Además, bajo <strong>Ver pronósticos</strong> se pueden ver los pronósticos de los demás jugadores.',
    'ABS_3_text14'=>'La <strong>Tabla de pronósticos</strong> es una visualización adicional, es decir, una tabla generada según sus pronósticos enviados.',
    'ABS_3_text15'=>'Notas sobre el momento de la evaluación',
    'ABS_3_text16'=>'La evaluación técnica de los pronósticos suele realizarse después de cada jornada completada.',
    'ABS_3_text17'=>'Tenga en cuenta que, por razones organizativas, la evaluación puede retrasarse en ocasiones entre <strong>1 y 2 días</strong>.',
    'ABS_4'=>'Exclusión de responsabilidad',
    'ABS_4_text1'=>'El organizador no se hace responsable en modo alguno de posibles errores de transmisión u otras dificultades técnicas.',
    'ABS_4_text2'=>'Al registrarse en el juego, acepta las condiciones. Este juego tiene fines puramente recreativos. Quien piratee, falsifique o se registre varias veces con nombres diferentes será sancionado con la expulsión del juego.',
    'ABS_4_text3'=>'Se excluye cualquier recurso legal.',
  ),
    'Italiano'=>array(
    'LANG'=>'IT',
    'HEADER'=>'Regole del gioco dei pronostici',
    'ABS_1'=>'Istruzioni per il gioco dei pronostici',
    'ABS_1_text1'=>'Dopo la registrazione al gioco, l\'utente ha la possibilità di abbonarsi a uno <strong>o</strong> più campionati.',
    'ABS_2'=>'Procedura per l\'abbonamento e la partecipazione alle singole leghe',
    'ABS_2_text1'=>'Registrazione e gestione',
    'ABS_2_text2'=>'Nell\'area di login, cliccare su \'<strong>registrati</strong>\'.',
    'ABS_2_text3'=>'Inserire tutti i dati di registrazione e selezionare a quale lega ci si desidera abbonare.<br><strong>Nota</strong>: è possibile abbonarsi a ulteriori leghe in qualsiasi momento dopo la registrazione iniziale sotto il proprio nome utente!',
    'ABS_2_text4'=>'Dopo la registrazione, sarai loggato o potrai accedere in qualsiasi momento con il tuo nickname.',
    'ABS_2_text5'=>'Nell\'area utente del gioco è possibile:',
    'ABS_2_text6'=>'Inviare <strong>pronostici per una lega</strong> abbonata',
    'ABS_2_text7'=>'Visualizzare i punteggi',
    'ABS_2_text8'=>'Modificare i propri dati',
    'ABS_2_text9'=>'Aggiungere altre o nuove leghe alla propria schedina',
    'ABS_2_text10'=>'Cambiare la password',
    'ABS_2_text11'=>'<strong>Eliminare l\'account</strong> (<strong>Attenzione</strong>: tutti i giochi abbonati del tuo nickname verranno eliminati!)',
    'ABS_2_text12'=>'Effettuare il logout dal gioco',
    'ABS_2_text13'=>'Giocare la lega',
    'ABS_2_text14'=>'Dopo il login, selezionare una lega abbonata nell\'area pronostici.',
    'ABS_2_text15'=>'Nell\'area incontri, è ora possibile inserire i pronostici per le singole giornate.',
    'ABS_2_text16'=>'Dopo l\'inserimento dei pronostici di <strong>una giornata</strong>, cliccare su <strong>salva pronostici</strong>',
    'ABS_2_text17'=>'È ora possibile passare a un\'altra giornata e inserire ulteriori pronostici.',
    'ABS_2_text18'=>'È inoltre possibile impostare un <strong>Joker</strong> per ogni giornata. I punti guadagnati per quella giornata verranno moltiplicati per un determinato fattore.',
    'ABS_2_text19'=>'Note sull\'invio dei pronostici',
    'ABS_2_text20'=>'Il tempo per i pronostici scade per ogni partita individualmente.',
    'ABS_2_text21'=>'La scadenza per i pronostici è fissata a',
    'ABS_2_text21_1'=>'minuti prima del calcio d\'inizio.',
    'ABS_2_text22'=>'Qualora alcune partite venissero anticipate <strong>senza</strong> la nostra conoscenza, ce ne scusiamo. Tuttavia, cerchiamo sempre di aggiornare tutti gli orari di inizio modificati <strong>prima</strong> di ogni giornata.',
    'ABS_3'=>'Valutazione del gioco e della lega',
    'ABS_3_text1'=>'Valutazione della partita (distribuzione dei punti)',
    'ABS_3_text2'=>'Risultato esatto',
    'ABS_3_text2_0'=>'Punto',
    'ABS_3_text2_1'=>'Punti',
    'ABS_3_text2_2'=>'Fattore',
    'ABS_3_text3'=>'Solo tendenza e differenza reti esatte',
    'ABS_3_text4'=>'Solo tendenza esatta',
    'ABS_3_text5'=>'Solo il numero di reti di una squadra esatto',
    'ABS_3_text6'=>'Moltiplicatore Joker',
    'ABS_3_text6_1'=>'Bonus per pronostico di pareggio esatto',
    'ABS_3_text7'=>'È inoltre possibile impostare un <strong>Joker</strong> per ogni giornata. I punti guadagnati per quella giornata varranno il doppio.',
    'ABS_3_text8'=>'Valutazione della lega e della giornata',
    'ABS_3_text9'=>'È possibile visualizzare la classifica generale selezionando una lega abbonata nella panoramica alla voce: <strong>Visualizza punteggi</strong>.',
    'ABS_3_text10'=>'È possibile raggiungere la classifica generale anche passando a <strong>Classifica lega</strong> nell\'area pronostici.',
    'ABS_3_text11'=>'È possibile visualizzare i punti ottenuti per le <strong>singole</strong> partite consultando una <strong>giornata completata</strong> nell\'area pronostici di una lega.',
    'ABS_3_text12'=>'Il <strong>vincitore assoluto</strong> è colui che accumula il maggior numero di punti sul proprio conto dopo una stagione.',
    'ABS_3_text13'=>'Inoltre, sotto <strong>Visualizza pronostici</strong> è possibile vedere i pronostici degli altri giocatori.',
    'ABS_3_text14'=>'La <strong>Tabella pronostici</strong> è una visualizzazione aggiuntiva, ovvero una tabella generata in base ai pronostici inseriti.',
    'ABS_3_text15'=>'Note sulla tempistica di valutazione',
    'ABS_3_text16'=>'La valutazione tecnica dei pronostici avviene solitamente dopo ogni giornata completata.',
    'ABS_3_text17'=>'Si prega di notare che, per motivi organizzativi, la valutazione può talvolta subire un ritardo di <strong>1 o 2 giorni</strong>.',
    'ABS_4'=>'Esclusione di responsabilità',
    'ABS_4_text1'=>'L\'organizzatore non è in alcun modo responsabile per eventuali errori di trasmissione o altre difficoltà tecniche.',
    'ABS_4_text2'=>'Con la registrazione al gioco, si accettano le condizioni. Questo gioco è a puro scopo di intrattenimento. Chiunque hackererà, falsificherà o si registrerà più volte con nomi diversi sarà punito con l\'esclusione dal gioco.',
    'ABS_4_text3'=>'È escluso ogni ricorso legale.',
  )
);
$userlan = $_SESSION['lmouserlang'];

if (isset($lang[$userlan])) {
    $userlang = $userlan;
} else {
    $userlang = 'English';
} ?>
<style type="text/css">
    :root {
        --primary: #3182ce;
        --bg-soft: #f7fafc;
        --text-main: #2d3748;
        --text-muted: #718096;
        --border: #e2e8f0;
    }

    /* Basis-Korrektur für Zeilenumbrüche und Ausrichtung */
    .regeln-wrapper {
        font-family: 'Inter', -apple-system, sans-serif;
        color: var(--text-main);
        line-height: 1.6;
        padding: 20px;
        background: #fff;
        text-align: left !important;
        /* Erzwingt Zeilenumbruch bei langem Text */
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        white-space: normal !important;
    }

    h1 { font-size: 1.75rem; font-weight: 800; text-align: center; margin-bottom: 30px; }

    /* Accordion Design */
    details { border: 1px solid var(--border); border-radius: 12px; margin-bottom: 16px; }
    summary {
        padding: 16px 20px; font-weight: 800; cursor: pointer; color: var(--primary);
        display: flex; justify-content: space-between; align-items: center; list-style: none;
    }
    summary::after { content: "+"; font-size: 2.0rem; }
    details[open] summary::after { content: "−"; }

    /* Info-Blöcke (dd) und Definitionslisten (dt) */
    dl { margin: 0; width: 100%; }
    dt {
        font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted);
        margin-top: 20px; font-weight: 700; display: block;
    }
    dd {
        margin: 4px 0 16px 0 !important;
        padding: 15px !important;
        background: var(--bg-soft);
        border-radius: 10px;
        border-left: 4px solid var(--primary);
        display: block !important;
        float: none !important; /* Verhindert das Nebeneinander-Stehen */
        width: 100% !important;
    }

    /* FIX FÜR DIE AUFZÄHLUNG (ul/li) INNERHALB VON DD */
    .regeln-wrapper ul {
        margin: 10px 0 0 0 !important;
        padding-left: 20px !important; /* Platz für Bullets */
        list-style-type: disc !important; /* Standard-Punkte */
        text-align: left !important;
    }

    .regeln-wrapper li {
        margin-bottom: 8px !important;
        text-align: left !important;
        display: list-item !important; /* Erzwingt klassisches Listenverhalten */
        float: none !important;
        color: var(--text-main) !important;
    }

    .points-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin: 20px 0; }
    .point-card { background: #fff; border: 1px solid var(--border); padding: 16px; border-radius: 12px; text-align: center; }
    .point-card .value { display: block; font-size: 1.5rem; font-weight: 800; color: var(--primary); }
    .point-card {
    background: #fff;
    border: 1px solid var(--border);
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: white;

    display: flex;
    flex-direction: column; /* Stapelt Elemente untereinander */
    justify-content: flex-start;
    min-height: 120px; /* Optionale Mindesthöhe für Gleichmäßigkeit */
    text-align: center !important;
}

.point-card .value {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
}

.point-card .label {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 600;
    line-height: 1.2;
}

/* AUSRICHTUNG NACH UNTEN */
.point-card .unit {
    font-size: 0.65rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding-top: 10px;
}

</style>
<div class="regeln-container">
    <h1><?php echo $lang[$userlang]['ABS_1']; ?></h1>
    <p style="text-align:center; color: #718096; margin-bottom: 30px;"><?php echo $lang[$userlang]['ABS_1_text1']; ?></p>

    <details open>
        <summary><?php echo $lang[$userlang]['ABS_2']; ?></summary>
        <div class="accordion-content">
            <strong><?php echo $lang[$userlang]['ABS_2_text1'];?></strong>
            <p><?php echo $lang[$userlang]['ABS_2_text2'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text3'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text4'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text5'];?></p>
            <ul>
                <li><?php echo $lang[$userlang]['ABS_2_text6'];?></li>
                <li><strong><?php echo $lang[$userlang]['ABS_2_text7'];?></strong></li>
                <li><strong><?php echo $lang[$userlang]['ABS_2_text8'];?></strong></li>
                <li><strong><?php echo $lang[$userlang]['ABS_2_text9'];?></strong></li>
                <li><strong><?php echo $lang[$userlang]['ABS_2_text10'];?></strong></li>
                <li><?php echo $lang[$userlang]['ABS_2_text11'];?></li>
                <li><strong><?php echo $lang[$userlang]['ABS_2_text12'];?></strong></li>
            </ul>
            <hr style="border:0; border-top:1px dashed #cbd5e0; margin:15px 0;">
            <strong><?php echo $lang[$userlang]['ABS_2_text13'];?></strong>
            <p><?php echo $lang[$userlang]['ABS_2_text14'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text15'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text16'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text17'];?></p><?php
if ($tipp_jokertipp==1) {?>
            <p><?php echo $lang[$userlang]['ABS_2_text18'];?></p><?php
}?>
            <strong><?php echo $lang[$userlang]['ABS_2_text19'];?></strong>
            <p><?php echo $lang[$userlang]['ABS_2_text20'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text21'];?> <?php echo $tipp_tippBis;?> <?php echo $lang[$userlang]['ABS_2_text21_1'];?></p>
            <p><?php echo $lang[$userlang]['ABS_2_text22'];?></p>
        </div>
    </details>

    <details>
        <summary><?php echo $lang[$userlang]['ABS_3']; ?></summary>
        <div class="accordion-content">
            <p><?php echo $lang[$userlang]['ABS_3_text1'];?></p>
            <div class="points-grid">
                <div class="point-card">
                    <span class="unit"><?php if ($tipp_rergebnis > 1) {echo $lang[$userlang]['ABS_3_text2_1'];} else {echo $lang[$userlang]['ABS_3_text2_0'];};?></span>
                    <span class="value"><?php echo $tipp_rergebnis; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text2'];?></span>
                </div>
                <div class="point-card">
                    <span class="unit"><?php if ($tipp_rtendenzdiff > 1) {echo $lang[$userlang]['ABS_3_text2_1'];} else {echo $lang[$userlang]['ABS_3_text2_0'];}?></span>
                    <span class="value"><?php echo $tipp_rtendenzdiff; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text3'];?></span>
                </div>
                <div class="point-card">
                    <span class="unit"><?php if ($tipp_rtendenz > 1) {echo $lang[$userlang]['ABS_3_text2_1'];} else {echo $lang[$userlang]['ABS_3_text2_0'];}?></span>
                    <span class="value"><?php echo $tipp_rtendenz; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text4'];?></span>
                </div>
                <div class="point-card">
                    <span class="unit"><?php if ($tipp_rtor > 1) {echo $lang[$userlang]['ABS_3_text2_1'];} else {echo $lang[$userlang]['ABS_3_text2_0'];}?></span>
                    <span class="value"><?php echo $tipp_rtor; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text5'];?></span>
                </div><?php
if ($tipp_jokertipp == 1) {?>
                <div class="point-card highlight">
                    <span class="unit"><?php if ($tipp_rremis > 1) {echo $lang[$userlang]['ABS_3_text2_1'];} else {echo $lang[$userlang]['ABS_3_text2_0'];}?></span>
                    <span class="value"><?php echo $tipp_rremis; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text6_1'];?></span>
                </div><?php
}
if ($tipp_rremis >= 1) {?>
                <div class="point-card highlight">
                    <span class="unit"><?php echo $lang[$userlang]['ABS_3_text2_2'];?></span>
                    <span class="value">x&nbsp;<?php echo $tipp_jokertippmulti; ?></span>
                    <span class="label"><?php echo $lang[$userlang]['ABS_3_text6'];?></span>
                </div><?php
}?>
            </div>
            <strong><?php echo $lang[$userlang]['ABS_3_text8'];?></strong>
            <p><?php echo $lang[$userlang]['ABS_3_text9'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text10'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text11'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text12'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text13'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text14'];?></p>
            <strong><?php echo $lang[$userlang]['ABS_3_text15'];?></strong>
            <p><?php echo $lang[$userlang]['ABS_3_text16'];?></p>
            <p><?php echo $lang[$userlang]['ABS_3_text17'];?></p>
        </div>
    </details>

    <details>
        <summary><?php echo $lang[$userlang]['ABS_4']; ?></summary>
        <div class="accordion-content">
            <p><?php echo $lang[$userlang]['ABS_4_text1'];?></p>
            <p><?php echo $lang[$userlang]['ABS_4_text2'];?></p>
            <p style="font-style: italic; color: #e53e3e;"><strong><?php echo $lang[$userlang]['ABS_4_text3'];?></strong></p>
        </div>
    </details>
</div>

