<?
// Ist der MD5-Hack aktiv?
// Voreinstellung ist ja!
// Ist wird sehr empfohlen, diesen Hack zu installieren, da ansonsten das Passwort im Klartext übermittelt wird.
// Wenn md5 nicht aktiv ist, von TRUE auf FALSE ändern
$lmo_md5 = FALSE;

// Pfad zu den Dateien lmo-access.txt und lmo-auth.txt
// Voreinstellung ist der lmo-Pfad, also ohne Unterverzeichnis
// Wenn dies geändert werden soll, dann z.B. einfach folgendes hinschreiben:
// $lmo_auth_pfad="meinverzeichnis/";
// Also in den "" das Verzeichnis !!!mit!!! / angeben
$lmo_auth_verz="";

// Hier könnte man die Endung der Ligadatein ändern, falls dies mal notwendig werden sollte.
// Aber normalerweise bzw. zur Zeit keine Änderungen vornehmen!
$ftype=".l98";
?>