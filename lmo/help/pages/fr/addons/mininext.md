# Mininext

1. [Configuration](#1-configuration)
2. [Intégration](#2-integration)
3. [Modèles](#3-modeles)

![Capture de Mininext](./assets/media/mininext.png)

Le script Mininext affiche le prochain match d'une équipe dans un bloc compact facile à intégrer dans n'importe quelle page existante. En outre, les confrontations précédentes des équipes concernées sont affichées depuis l'archive, par ordre décroissant de date.

---

## 1. Configuration

L'addon Mininext se configure via la gestion des addons du LMO. Pour chaque intégration individuelle, des paramètres supplémentaires peuvent être transmis.

### Gestion des addons

Dans la gestion des addons, clique sur **mini**. Les paramètres de base suivants peuvent être contrôlés :

| Paramètre | Signification |
|---|---|
| `mininext_withArchiv` | Recherche dans l'archive activée/désactivée |
| `mininext_unGreedy` | Recherche floue activée/désactivée ; regroupe les noms d'équipe de sonorité proche |
| `mininext_barWidth` | Largeur de la barre pour V/N/D |
| `mininext_standardTemplate` | Modèle par défaut si aucun n'est transmis |

### Paramètres

Via l'URL (iframe) ou comme variables d'include, tu peux transmettre les valeurs suivantes :

| Paramètre | Signification |
|---|---|
| `file` | Nom de fichier de la ligue, p. ex. `bundesliga.l98` |
| `folder` | Dossier d'archive pour rechercher des matchs précédents. Astuce : crée un sous-dossier distinct par ligue plutôt que de tout mettre directement dans le dossier d'archive. |
| `a` | Numéro de l'équipe A. Nécessaire uniquement si aucune équipe favorite n'est définie dans le fichier de la ligue. |
| `b` | Numéro de l'adversaire. Inutile pour le prochain match, seulement si une confrontation précise doit être affichée. |
| `mini_template` | Modèle à utiliser. Si omis : modèle par défaut. |

---

## 2. Intégration

Il y a deux façons. La première est préférable ; la seconde n'est prévue que pour les serveurs sans support PHP ou les fichiers `.html`.

### Intégrer via include

Définis les paramètres directement comme variables PHP, *dans un bloc PHP* (ouvre-le avec `<?php` si nécessaire) :

```php
$file="liga1.l98";
$folder="archiv/First_Team";
```

Fais attention au `$` devant le nom, aux guillemets autour des chaînes et au point-virgule final. Seul le nom de la ligue est obligatoire. Intègre ensuite l'addon :

```php
include("CheminVersLMO/addon/mini/lmo-mininext.php");
```

`CheminVersLMO` est le chemin absolu ou relatif vers le répertoire du LMO.

> **Attention :** N'utilise jamais d'URL, pas de `include("http://www.../lmo-mininext.php");`. Indique toujours un **chemin de fichier**.

> **Remarque :** Si tu n'utilises pas de sessions sur ta page, ajoute `<?php session_start(); ?>` comme toute première ligne du fichier.

### Intégrer via iframe

Uniquement si la méthode include ne fonctionne pas. Les paramètres font partie de l'URL source :

```html
<iframe src="URLduLMO/addon/mini/lmo-mininext.php?file=liga1.l98&folder=archiv/First_Team"
  style="border:0" width="largeur" height="hauteur" scrolling="no"></iframe>
```

`URLduLMO` est l'adresse web de ton LMO. Pour `largeur` et `hauteur`, il faut tâtonner. Le premier paramètre est séparé par `?`, les suivants par `&`.

---

## 3. Modèles

Comme pour le LMO, tu peux adapter la structure et le design de Mininext. Les modèles se trouvent dans le sous-répertoire `mini` du dossier `template`. Par défaut, c'est `mininext.tpl.php` (modifiable dans la gestion des addons). Tu peux créer autant de modèles que tu veux (extension `.tpl.php`).

### Le prochain match

| Espace réservé | Signification |
|---|---|
| `<!--gameTxt-->` | Titre |
| `<!--gameDate-->` | Date du prochain match |
| `<!--gameTime-->` | Heure du prochain match |
| `<!--countDown-->` | Compte à rebours jusqu'au prochain match |
| `<!--homeName-->` | Nom de l'équipe à domicile |
| `<!--homeNameMiddle-->` | Nom de longueur moyenne de l'équipe à domicile |
| `<!--homeNameShort-->` | Nom court de l'équipe à domicile |
| `<!--homeTore-->` | Buts de l'équipe à domicile (depuis LMO 4.0.2) |
| `<!--imgHomeBig-->` | Grande icône de l'équipe à domicile |
| `<!--imgHomeSmall-->` | Petite icône de l'équipe à domicile |
| `<!--guestName-->` | Nom de l'équipe visiteuse |
| `<!--guestNameMiddle-->` | Nom de longueur moyenne de l'équipe visiteuse |
| `<!--guestNameShort-->` | Nom court de l'équipe visiteuse |
| `<!--guestTore-->` | Buts de l'équipe visiteuse (depuis LMO 4.0.2) |
| `<!--imgGuestBig-->` | Grande icône de l'équipe visiteuse |
| `<!--imgGuestSmall-->` | Petite icône de l'équipe visiteuse |
| `<!--gameNote-->` | Note du match |
| `<!--ligaDatum-->` | Date de la dernière modification de la ligue |
| `<!--copy-->` | Mention de copyright, **ne doit être ni modifiée ni supprimée !** |

### Confrontations précédentes

**En dehors de `<!-- BEGIN/END matches -->` :**

| Espace réservé | Signification |
|---|---|
| `<!--matchesText-->` | Titre des matchs précédents |
| `<!--winCount-->` / `<!--drawCount-->` / `<!--lostCount-->` | Nombre de victoires à domicile / nuls / victoires à l'extérieur |
| `<!--winTxt-->` / `<!--drawTxt-->` / `<!--lostTxt-->` | Libellés des victoires/nuls/défaites (p. ex. V, N, D) |
| `<!--winWidth-->` / `<!--drawWidth-->` / `<!--lostWidth-->` | Largeur de la barre des victoires/nuls/défaites |
| `<!-- BEGIN matches -->` | Début du bloc répété. **Respecte les espaces avant BEGIN et après matches !** |
| `<!-- END matches -->` | Fin du bloc répété. **Respecte les espaces avant END et après matches !** |

**Uniquement à l'intérieur de `<!-- BEGIN/END matches -->` :**

| Espace réservé | Signification |
|---|---|
| `<!--class-->` | Mise en évidence en couleur du match |
| `<!--date-->` | Date du match |
| `<!--time-->` | Heure du match |
| `<!--hTore-->` | Buts à domicile |
| `<!--gTore-->` | Buts à l'extérieur |
| `<!--where-->` | Match à domicile ou à l'extérieur |
| `<!--matchingName-->` | Avec recherche floue active : le nom d'équipe trouvé |

### Le match précédent

| Espace réservé | Signification |
|---|---|
| `<!--previous_gameTxt-->` | Titre |
| `<!--previous_gameDate-->` | Date du match précédent |
| `<!--previous_gameTime-->` | Heure du match précédent |
| `<!--previous_homeName-->` | Nom de l'équipe à domicile |
| `<!--previous_homeNameMiddle-->` | Nom de longueur moyenne de l'équipe à domicile |
| `<!--previous_homeNameShort-->` | Nom court de l'équipe à domicile |
| `<!--previous_imgHomeBig-->` | Grande icône de l'équipe à domicile |
| `<!--previous_imgHomeSmall-->` | Petite icône de l'équipe à domicile |
| `<!--previous_guestName-->` | Nom de l'équipe visiteuse |
| `<!--previous_guestNameMiddle-->` | Nom de longueur moyenne de l'équipe visiteuse |
| `<!--previous_guestNameShort-->` | Nom court de l'équipe visiteuse |
| `<!--previous_imgGuestBig-->` | Grande icône de l'équipe visiteuse |
| `<!--previous_imgGuestSmall-->` | Petite icône de l'équipe visiteuse |

Adapte le code HTML à ton goût, mais veille à ce qu'il soit correct en HTML/CSS.
