# Personnaliser le LMO

1. [Icônes des équipes](#1-icones-des-equipes)
2. [CSS personnalisé](#2-css-personnalise)
3. [Modèles](#3-modeles)
4. [Intégrer le LMO dans des sites existants](#4-integrer-le-lmo-dans-des-sites-existants)

Outre l'[éditeur de design](#options/3-editeur-de-design), tu peux adapter le LMO via des icônes d'équipe, ton propre CSS et un système de modèles simple.

---

## 1. Icônes des équipes

De petits écussons de club embellissent le LMO. Le LMO trouve les fichiers automatiquement :

- Copie les icônes dans `img/teams/small/`.
- Le nom de fichier doit correspondre au nom de l'équipe (y compris les points ou espaces). Seul le caractère `/` n'est pas autorisé ; omets-le simplement dans le nom de fichier.
- Certains addons affichent des icônes agrandies. Place-les dans `img/teams/big/`.
- Les formats autorisés sont PNG, GIF et JPG.

> **Apache 2 :** Supprime tous les caractères spéciaux des noms de fichiers ; seuls les lettres et les chiffres sont autorisés.

---

## 2. CSS personnalisé

Si les paramètres de l'éditeur de design ne suffisent pas, modifie le fichier `template/style.css`. Il est chargé automatiquement et remplace l'éditeur de design. Modifie-le avec un éditeur de texte et, si besoin, vérifie-le avec le [validateur CSS du W3C](https://jigsaw.w3.org/css-validator/).

---

## 3. Modèles

Un modèle est un fichier HTML complété par des commentaires HTML de la forme `<!--Nom-->`. Le LMO remplace chaque commentaire par la partie correspondante de sa sortie. La position des commentaires détermine où quelque chose apparaît. Si tu omets un commentaire, cette partie est supprimée. Tu peux aussi utiliser plusieurs modèles pour le même LMO.

Les modèles se trouvent dans le dossier `template/` (`lmo-standard-komplett.tpl.php` et `lmo-standard.tpl.php`). Il existe d'autres modèles pour les addons, p. ex. dans `template/mini/` et `template/viewer/`.

| Commentaire | Contenu |
|---|---|
| `<!--Titel-->` | Texte du titre du LMO |
| `<!--Stylesheet-->` | La feuille de style |
| `<!--Newsticker-->` | Le ticker d'actualités intégré |
| `<!--Kalender-->` | Lien de navigation vers le calendrier |
| `<!--Ergebnisse-->` | Lien de navigation vers les résultats |
| `<!--Tabelle-->` | Lien de navigation vers le classement |
| `<!--Spielplan-->` | Lien de navigation vers le calendrier des matchs |
| `<!--Kreuztabelle-->` | Lien de navigation vers le tableau croisé |
| `<!--Fieberkurve-->` | Lien de navigation vers la courbe de forme |
| `<!--Ligastatistik-->` | Lien de navigation vers les statistiques de la ligue |
| `<!--Spielerstatistik-->` | Lien de navigation vers les statistiques des joueurs |
| `<!--Tippspiel-->` | Lien de navigation vers le jeu de pronostics |
| `<!--Info-->` | Lien de navigation vers la page d'infos, **merci de ne pas supprimer** |
| `<!--Hauptteil-->` | Partie principale du LMO |
| `<!--Savehtml-->` | Liens vers les versions imprimables sous les résultats ou le classement |
| `<!--Sprachauswahl-->` | Sélection de la langue |
| `<!--Ligenuebersicht-->` | Lien vers l'aperçu des ligues |
| `<!--LetzteAuswertung-->` | Date de la dernière évaluation de la ligue choisie |
| `<!--Berechnungszeit-->` | Temps de calcul |
| `<!--Infolink-->` | Mention de copyright, **ne doit pas être supprimée** (voir [Mentions légales](#getting-started/7-mentions-legales)) |

Veille à produire du HTML valide. Tu peux le vérifier avec le [validateur HTML du W3C](https://validator.w3.org/).

Selon la manière d'intégrer le LMO, il te faut l'un de deux modèles : un **document HTML complet** pour les appels directs, ou un modèle avec **uniquement la partie HTML** pour l'inclusion via `include`.

---

## 4. Intégrer le LMO dans des sites existants

Tu peux appeler le LMO directement ou l'inclure dans tes pages via `include`.

### Appel direct

Appelle le LMO via `lmo.php`. Le modèle utilisé est défini dans ce fichier. Par défaut, c'est `lmo-standard-komplett.tpl.php`, un document HTML complet.

L'appel direct convient aussi pour une **iframe** :

```html
<iframe src="URL-du-LMO/lmo.php" width="largeur" height="hauteur" style="border:0"></iframe>
```

Pour la largeur et la hauteur, il faut malheureusement tâtonner ; c'est l'un des inconvénients des iframes.

Avec des paramètres dans l'URL, tu démarres directement dans une certaine vue, p. ex. `lmo.php?file=liga.l98` pour démarrer avec une ligue.

Pour un deuxième modèle, copie `lmo.php`, renomme-le (p. ex. `lmoneu.php`) et modifie l'appel du modèle dedans. Tu accèdes alors au « nouveau » LMO sous `lmoneu.php`.

### Include

L'inclusion via `include` dans une page PHP existante est plus pratique :

```php
<?php include("CheminVersLMO/lmo.php"); ?>
```

Tiens compte de ce qui suit :

- **`CheminVersLMO` est un chemin de fichier, pas une URL.** `include("http://www.monsite.fr/lmo/lmo.php");` ne fonctionne pas.
- Une ligue qui doit s'ouvrir immédiatement au lieu de l'aperçu des ligues est indiquée **avant** l'include : `$file = "NomDeLaLigue.l98";`
- Par défaut, `lmo-standard.tpl.php` (sans « komplett ») est chargé. Ce n'est pas un document HTML complet ; les autres parties viennent de ta page.
- Tout en haut de ta page (la toute première ligne), ceci doit figurer :

  ```php
  <?php if (session_id() == "") session_start(); ?>
  ```

- Si ta page n'utilise pas encore `<!DOCTYPE html>`, ajoute-le. Indique aussi le jeu de caractères dans le `<head>` : `<meta charset="utf-8">`
- Inclus la feuille de style du LMO dans le `<head>` :

  ```html
  <link rel="stylesheet" href="CheminVersLMO/lmo-style-nc.php">
  <style>@import url('CheminVersLMO/lmo-style.php');</style>
  ```

Tu peux utiliser plusieurs modèles avec la même méthode.
