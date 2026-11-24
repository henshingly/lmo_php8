# Ticker d'actualités

1. [Paramètres de contrôle](#1-parametres-de-controle)
2. [Intégration](#2-integration)

![Vue utilisateur](./assets/media/ticker01.png)

Le LMO intègre un ticker d'actualités flexible qui affiche résultats et notes sous forme de texte défilant peu encombrant. Dans l'[éditeur de résultats](#edit-league/3-editeur-de-resultats), tu peux activer ou désactiver le ticker séparément pour chaque ligue. Il apparaît alors dans l'espace des utilisateurs au-dessus de la ligue correspondante. Tu peux aussi l'intégrer n'importe où sur ton site et même le configurer pour que plusieurs ligues soient réunies dans un même ticker.

---

## 1. Paramètres de contrôle

Avec ces paramètres, tu contrôles le comportement du ticker. Dans la [gestion des addons](#options/2-gestion-des-addons), tu peux modifier les valeurs par défaut ; elles valent pour les tickers placés au-dessus des ligues et pour tout ticker auquel aucun paramètre propre n'est transmis.

| Paramètre | Valeur | Signification |
|---|---|---|
| `standard_ligen` | nom(s) de fichier | Noms de fichier avec l'extension `.l98` ; sépare plusieurs ligues par des virgules |
| `tickerart` | `1` | Ticker de résultats |
| | `2` | Texte de ticker du LMO |
| | `3` | Ticker de résultats, uniquement équipe favorite |
| `tickertitel` | `0` | Masquer l'en-tête du ticker |
| | `1` | Afficher l'en-tête du ticker |
| `notizanzeigen` | `0` | Masquer les notes de match |
| | `1` | Afficher les notes de match |
| `breite` | nombre | Largeur du ticker (en nombre de lettres) |
| `geschwindigkeit` | nombre | Vitesse de défilement du ticker |

---

## 2. Intégration

Il y a deux façons d'intégrer le ticker d'actualités. La première est préférable ; la seconde n'est prévue que pour les serveurs sans support PHP (quand le LMO tourne sur un serveur externe) ou si tu utilises un fichier `.html` (que PHP ne traite normalement pas).

### Intégrer via include

Les paramètres sont définis directement comme variables PHP. Écris-les les uns après les autres *dans un bloc PHP* (ouvre-le avec `<?php` si nécessaire) :

```php
$tickerart="1";
$tickerligen="liga1.l98,liga2.l98";
```

Fais attention au `$` devant le nom du paramètre, aux guillemets autour des chaînes et au point-virgule final. Tu n'as qu'à indiquer les paramètres qui diffèrent des réglages par défaut. Intègre ensuite le ticker :

```php
include("CheminVersLMO/addon/ticker/ticker.php");
```

`CheminVersLMO` est le chemin absolu ou relatif vers le répertoire du LMO.

> **Attention :** N'utilise jamais d'URL, donc pas de `include("http://www.../ticker.php");`, car cela ne fonctionne pas ! Indique toujours un **chemin de fichier**.

### Intégrer via iframe

N'utilise cette méthode que si la variante include ne fonctionne pas pour une raison quelconque. Les iframes ne sont pas pris en charge par tous les navigateurs et ont en outre des inconvénients d'ergonomie. Ici, les paramètres font partie de l'URL source :

```html
<iframe src="URLduLMO/addon/ticker/ticker.php?tickerart=1&tickerligen=liga1.l98,liga2.l98"
  style="border:0" width="largeur" height="hauteur" scrolling="no"></iframe>
```

`URLduLMO` est l'adresse web de ton LMO. Pour `largeur` et `hauteur`, il faut malheureusement tâtonner un peu. Le premier paramètre est séparé par `?`, tous les suivants par `&`.
