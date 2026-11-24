# Mini-classements

1. [Paramètres de contrôle](#1-parametres-de-controle)
2. [Intégration](#2-integration)
3. [Modèles](#3-modeles)

![Vue utilisateur](./assets/media/minitabs01.png)

Le LMO permet d'afficher des classements ou des extraits de classements sur des pages externes. Tu peux ainsi, par exemple, intégrer à ta page d'accueil une version compacte du classement actuel. Quels détails sont affichés et quel aspect a le classement, tu peux le configurer librement via des [modèles](#3-modeles).

---

## 1. Paramètres de contrôle

Comme pour le ticker, les mini-classements ont plusieurs paramètres de contrôle.

| Paramètre | Signification |
|---|---|
| `mini_liga` | Nom de fichier de la ligue (avec l'extension `.l98`) |
| `mini_platz` | Autour de quelle place l'extrait doit-il être centré ? Laisse vide pour l'équipe favorite. |
| `mini_ueber` | Combien d'équipes afficher au-dessus de celle choisie ? |
| `mini_unter` | Combien d'équipes afficher en dessous de celle choisie ? |
| `mini_template` | Nom du modèle (sans extension). S'il n'est pas indiqué, `standard` est utilisé. |

---

## 2. Intégration

Il y a deux façons d'intégrer des mini-classements. La première est préférable ; la seconde n'est prévue que pour les serveurs sans support PHP ou les fichiers `.html`.

### Intégrer via include

Les paramètres sont définis directement comme variables PHP, *dans un bloc PHP* (ouvre-le avec `<?php` si nécessaire) :

```php
$mini_liga="liga1.l98";
$mini_ueber=3;          // 3 équipes au-dessus de l'équipe favorite
$mini_unter=2;          // 2 équipes en dessous de l'équipe favorite
$mini_template="all";   // utiliser le modèle "all.tpl.php"
```

Fais attention au `$` devant le nom du paramètre, aux guillemets autour des chaînes et au point-virgule final. Seul le nom de la ligue est obligatoire. Intègre ensuite le mini-classement :

```php
include("CheminVersLMO/addon/mini/lmo-minitab.php");
```

`CheminVersLMO` est le chemin absolu ou relatif vers le répertoire du LMO.

> **Attention :** N'utilise jamais d'URL, pas de `include("http://www.../minitab.php");`, car cela ne fonctionne pas ! Indique toujours un **chemin de fichier**.

### Intégrer via iframe

Uniquement si la méthode include ne fonctionne pas. Les iframes ont des inconvénients (compatibilité des navigateurs, ergonomie). Les paramètres font partie de l'URL source :

```html
<iframe src="URLduLMO/addon/mini/lmo-minitab.php?mini_liga=liga1.l98&mini_ueber=3&mini_unter=2&mini_template=all"
  style="border:0" width="largeur" height="hauteur" scrolling="no"></iframe>
```

`URLduLMO` est l'adresse web de ton LMO. Pour `largeur` et `hauteur`, il faut tâtonner. Le premier paramètre est séparé par `?`, les suivants par `&`.

---

## 3. Modèles

Comme pour le LMO lui-même, tu peux adapter librement la structure et le design des mini-classements. Les modèles se trouvent dans le sous-répertoire `mini` du dossier `template`. Sans paramètres de contrôle, `standard.tpl.php` est utilisé. Tu peux créer autant de modèles que tu veux (extension `.tpl.php`).

Les espaces réservés suivants sont disponibles :

| Espace réservé | Signification |
|---|---|
| `<!--Link-->` | Lien vers le classement complet dans le LMO |
| `<!-- BEGIN Inhalt -->` | Début du bloc répété pour chaque équipe. **Respecte les espaces avant BEGIN et après Inhalt !** |
| `<!-- END Inhalt -->` | Fin du bloc répété. **Respecte les espaces avant END et après Inhalt !** |
| `<!--Style-->` | Active la mise en évidence du champion, des relégués, etc. selon le réglage de la ligue |
| `<!--Team-->` | Nom court de l'équipe |
| `<!--TeamLang-->` | Nom complet de l'équipe |
| `<!--TeamMittel-->` | Nom de longueur moyenne de l'équipe |
| `<!--TeamBild-->` | Icône de l'équipe (si elle existe) |
| `<!--Teamnotiz-->` | Note de l'équipe |
| `<!--Spiele-->` | Nombre de matchs |
| `<!--Punkte-->` | Points ; avec points négatifs sous la forme **+P:-P** |
| `<!--PlusTore-->` | Buts marqués |
| `<!--MinusTore-->` | Buts encaissés |
| `<!--Tordifferenz-->` | Différence de buts |
| `<!--Siege-->` | Nombre de victoires |
| `<!--Unentschieden-->` | Nombre de nuls |
| `<!--Niederlagen-->` | Nombre de défaites |

Adapte le code HTML à ton goût, mais veille à ce que ce soit du HTML/CSS correct. Dans le modèle `all.tpl.php`, tu trouveras tous les espaces réservés en exemple.
