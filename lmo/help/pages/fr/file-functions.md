# Fonctions de fichiers

1. [Supprimer une ligue](#1-supprimer-une-ligue)
2. [Téléverser une ligue](#2-televerser-une-ligue)
3. [Télécharger/Envoyer une ligue par courriel](#3-telecharger-envoyer-une-ligue-par-courriel)

---

## 1. Supprimer une ligue

Si une ligue est obsolète ou si tu veux la remplacer par une copie de sauvegarde, choisis **Supprimer** dans le menu et clique sur la ligue dans la liste. Après une demande de confirmation, elle est **définitivement supprimée**. Sois donc prudent.

---

## 2. Téléverser une ligue

Avec **Téléverser**, tu transfères une ligue de ton disque dur directement dans ton répertoire de ligues. Choisis une ligue (`*.l98`) via **Parcourir …** et lance avec **Démarrer le téléversement** (ne clique qu'une seule fois). Les ligues existantes ne sont pas écrasées : si le nom de fichier existe déjà, un numéro est ajouté, ainsi `liga.l98` devient `liga_1.l98`.

---

## 3. Télécharger/Envoyer une ligue par courriel

Pour une sauvegarde, une modification hors ligne ou pour transmettre une ligue, choisis **Télécharger**. L'écran affiche la liste des ligues deux fois :

- **À gauche :** un clic télécharge la ligue sur ton disque dur. Avec **Télécharger toutes les ligues d'un coup**, tu obtiens un fichier ZIP avec toutes les ligues listées.
- **À droite :** un clic ouvre une fenêtre de saisie pour l'adresse e-mail du destinataire. La ligue (ou toutes) est compressée dans un fichier ZIP et envoyée par courriel. L'expéditeur est l'adresse d'expédition définie dans les options ou l'adresse e-mail du webmaster. La méthode d'envoi est celle qui y est définie (PHP `mail()` ou SMTP, voir [Envoi de courriels](#options/envoi-de-courriels-smtp)).
