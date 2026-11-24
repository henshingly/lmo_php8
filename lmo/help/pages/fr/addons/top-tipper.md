# TopTipper

1. [Configuration requise](#1-configuration-requise)
2. [Fichiers expliqués](#2-fichiers-expliques)
3. [Téléchargement](#3-telechargement)

![Vue de TopTipper](./assets/media/toptipper.png)

L'addon TopTipper affiche de façon compacte et claire le classement actuel du jeu de pronostics.

---

## 1. Configuration requise

- Un LMO 4 fonctionnel, à partir de la Beta 3, avec le jeu de pronostics activé

---

## 2. Fichiers expliqués

Le téléchargement contient 4 fichiers.

**`toptipper.php`**
Se trouve dans le dossier `addon/tipp/`.

**`kal.tip`**
Se trouve dans le dossier `config/tipp/`. C'est le fichier de configuration. Tu peux le renommer tant que l'extension `*.tip` est conservée et que le nouveau nom est pris en compte lors de l'intégration.

Contenu du fichier :

```
[config]
modus=1              // leave mode at 1, may still be useful
anzahl_tipper=10     // number of tippers in the display
all=0                // 0 or 1: 0 shows the file, 1 overall
file=erg_dfb.l98     // your league
template=standard    // template name without the extension *.tpl.php
```

(`modus` : laisse à 1 ; `anzahl_tipper` : nombre de participants affichés ; `all` : 0 affiche le fichier, 1 le classement général ; `file` : ta ligue ; `template` : nom du modèle sans l'extension `*.tpl.php`.)

**`standard.tpl.php`**
Se trouve dans le dossier `template/tipp/`. Tu peux concevoir le modèle librement. Espaces réservés disponibles :

| Espace réservé | Signification |
|---|---|
| `<!--Link-->` | Lien vers le jeu de pronostics |
| `<!--Lmo-->` | Lien vers le LMO |
| `<!--Platz-->` | Place des participants |
| `<!--Name-->` | Nom des participants |
| `<!--Punkte-->` | Points des participants |

**`tipp.php`**
Se trouve directement dans le répertoire racine de ton LMO. Il sert à intégrer le script ; adapte le contenu en conséquence.

Exemple :

```php
<?php
$multi="kal";  // Ton fichier adapté kal.tip est intégré.
require(dirname(__FILE__) . '/init.php');
include(PATH_TO_ADDONDIR . "/tipp/toptipper.php");
?>
```

---

## 3. Téléchargement

- [TopTipper](https://www.liga-manager-online.org/forum/viewtopic.php?t=94)

> Des instructions d'installation détaillées sont fournies avec chaque version.
