# Calendrier de l'équipe

1. [Configuration requise](#1-configuration-requise)
2. [Configuration](#2-configuration)
3. [Intégration](#3-integration)
4. [Téléchargement](#4-telechargement)
5. [Historique des versions](#5-historique-des-versions)

![Vue du calendrier de l'équipe](./assets/media/teampl01.png)

L'addon permet de sortir le calendrier d'une équipe choisie sous forme de document PDF, directement via le lien « Calendriers » du LMO.

---

## 1. Configuration requise

- Un LMO 4 fonctionnel
- Addon Classlib de Tim Schumacher installé (disponible dans l'archive des addons), y compris la classe PDF de [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (contenue dans la Classlib)

---

## 2. Configuration

L'addon Calendrier de l'équipe se configure via la gestion des addons du LMO.

### Gestion des addons

Dans la gestion des addons, clique sur **pdf**. Les paramètres suivants sont disponibles :

| Paramètre | Description |
|---|---|
| `linktarget` | Ouvre le PDF dans une nouvelle fenêtre (p. ex. `_blank`) |
| `show_adobe_link` | Indication sur le lecteur PDF avec image : **0** = désactivé / **1** = activé |
| `homepage` | Affiche un texte dans la marge, p. ex. l'adresse de ton site |
| `anzeige` | Tri par journée / date : **0** / **1** |
| `format` | Format de sortie A4 paysage / portrait : **0** / **1** |
| `teamfett` | Mettre en gras l'équipe choisie : **0** = désactivé / **1** = activé |
| `teamnamen` | Nom d'équipe long / court / moyen : **0** / **1** / **2** |
| `serie` | Aller/retour sur 1 page / 2 pages : **0** / **1** |

---

## 3. Intégration

### Intégrer dans le LMO

> Définis les droits d'accès (chmod) :
> **Fichiers :** `666` pour tous les fichiers `cfg.txt` du répertoire `config` et de ses sous-répertoires

Ouvre le fichier `lmo-showprogram.php` et insère le code suivant sous la dernière ligne (`} ?>`) :

```php
<?
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>
```

Après l'installation, le nouveau lien **Calendrier en document PDF** apparaît sous la fenêtre de sélection « Calendriers ».

> **Remarque :** La mention de copyright avec les informations de version ne doit **pas** être modifiée ni supprimée !

---

## 4. Téléchargement

- [Calendrier de l'équipe](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?t=5489)

---

## 5. Historique des versions

**1.0**

- Sortie du calendrier au format PDF

**2.0**

- Tri de la sortie
- Mise en évidence de l'équipe choisie
- Nom d'équipe et format au choix
- Sortie séparée pour l'aller et le retour
