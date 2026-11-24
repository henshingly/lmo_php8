# API JSON et vue de ligue

1. [Aperçu](#1-apercu)
2. [API JSON](#2-api-json)
3. [Vue de ligue](#3-vue-de-ligue)

L'extension API rend les données de tes ligues utilisables par d'autres sites et programmes : sous forme d'**interface JSON** (en lecture seule) et de **vue de ligue** toute prête, **générée côté serveur**, avec des designs interchangeables. Les deux utilisent la même logique de calcul que l'interface normale du LMO ; il n'y a pas de second calcul maintenu séparément.

> **Remarque :** L'extension API ne fait pas partie du paquet LMO, c'est un **téléchargement séparé**. Décompresse-la dans ton répertoire LMO (elle crée `addon/api/` et `template/api/`).

---

## 1. Aperçu

| Fichier | Rôle |
|---|---|
| `addon/api/lmo-api.php` | Interface JSON (lecture seule) |
| `addon/api/init-api.php` | Initialisation légère de l'interface (sans session) |
| `template/api/lmo-liga.php` | Vue de ligue complète en un seul fichier, avec designs (thèmes) |
| `template/api/themes/` | Designs `karten` et `stadium` |

---

## 2. API JSON

Appel : `addon/api/lmo-api.php?file=XXX.l98&resource=...`

L'interface est en **lecture seule**, ne nécessite aucune connexion, ne dépose aucun cookie et autorise les requêtes depuis d'autres domaines (CORS). Les réponses sont mises en cache pendant 60 secondes.

| Paramètre | Signification |
|---|---|
| `file` | Nom de fichier de la ligue avec l'extension `.l98` (obligatoire, sans sous-dossiers) |
| `resource` | Ressource souhaitée (voir ci-dessous), par défaut `info` |
| `st` | Journée, uniquement pour `results` |
| `team` | Numéro d'équipe comme filtre, uniquement pour `program` |
| `team1`, `team2` | Numéros d'équipe, uniquement pour `h2h` |
| `lang` | Langue, p. ex. `Englisch` (nom du fichier de langue du LMO) ; sinon la langue par défaut |

| Ressource | Contenu |
|---|---|
| `info` | Métadonnées de la ligue |
| `table` | Classement (y compris champs supplémentaires propres au sport) |
| `results` | Résultats d'une journée |
| `program` | Calendrier, éventuellement pour une équipe |
| `cross` | Tableau croisé (toutes les rencontres sous forme de matrice) |
| `graph` | Évolution de la place au classement par journée (courbe de forme) |
| `h2h` | Confrontations directes de deux équipes |

Exemple :

```
addon/api/lmo-api.php?file=1l_2024-25.l98&resource=table
```

---

## 3. Vue de ligue

Appel : `template/api/lmo-liga.php?file=XXX.l98&view=...&theme=...`

**Exemple en direct:** [https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php](https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php)

Ce fichier remplace les pages HTML individuelles et génère la vue directement sur le serveur. La ligue peut se trouver dans un sous-dossier (p. ex. `file=dfb/04er-liga.l98`). Sans `file`, il affiche une sélection cliquable de toutes les ligues et sous-dossiers.

| Paramètre | Signification |
|---|---|
| `file` | Ligue, éventuellement avec sous-dossier |
| `dir` | Sous-dossier dont les ligues doivent être listées |
| `view` | `uebersicht` (par défaut), `tabelle`, `ergebnisse`, `spielplan`, `kreuztabelle`, `fieberkurve`, `direkte-duelle` |
| `theme` | Design : `karten` ou `stadium` |
| `st`, `team`, `team1`, `team2` | comme pour l'API JSON |
| `lang` | Langue |

**Ton propre design :** Crée dans `template/api/themes/` un nouveau dossier avec un `theme.php` (structure comme `stadium/theme.php`, dont l'en-tête indique les variables disponibles). Facultativement, un `meta.php` indique le nom affiché pour le sélecteur de design.
