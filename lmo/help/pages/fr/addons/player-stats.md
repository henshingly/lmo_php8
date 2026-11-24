# Statistiques des joueurs

1. [Configuration](#1-configuration)

![Vue utilisateur](./assets/media/spielerstatistik01.png)

Avec cet addon, tu peux enregistrer et publier des statistiques de joueurs pour Liga Manager Online. La configuration flexible permet de l'utiliser pour de nombreux sports différents.

Tu peux créer trois types de colonnes : **texte**, **nombres** et **formules**. Malheureusement, l'ordre des colonnes ne peut plus être modifié ensuite, réfléchis donc bien avant de commencer. Après la création des joueurs, la composition apparaît en dessous, où tu saisis les valeurs correspondantes pour chaque joueur. Dans les colonnes de formules, tu peux calculer avec les colonnes numériques (p. ex. moyenne de buts).

**Intégrer des photos de joueurs**
Les photos vont dans le répertoire `img/spieler/small/`, nommées d'après le joueur concerné. Veille à une taille de fichier raisonnable.

**Intégrer des liens de joueurs**
Pour lier des joueurs, crée dans l'espace d'administration une colonne **« Lien du joueur »** (ou l'équivalent de `lang/lmo-[langue].txt`). Un lien peut être enregistré pour chaque joueur ; s'il manque, rien n'est lié.

**Intégrer des graphiques de colonne**
Au lieu d'en-têtes textuels, tu peux aussi utiliser des icônes pour les colonnes. Pour cela, enregistre une image **GIF** nommée d'après la colonne dans le répertoire `img/spieler/`. Des exemples sont déjà inclus.

**Statistiques de plusieurs clubs avec écussons**
Si tu utilises **« Club »** (ou l'équivalent de `lmo-[langue].txt`) comme en-tête de colonne, la prise en charge des clubs est activée : sélection déroulante, écussons de clubs (s'ils existent) et liens vers les sites des clubs.

---

## 1. Configuration

### Vue du visiteur

| Paramètre | Signification |
|---|---|
| Affichage par page | Nombre d'entrées affichées ; `0` = sans limite |
| Pré-tri | Colonne selon laquelle trier d'abord |
| Tri | Ordre du pré-tri |
| Colonne de tri supplémentaire | Affiche une colonne de tri distincte ; sinon, le tri se fait via les en-têtes du tableau |
| Affichage par club | Active la répartition par clubs |
| Afficher les valeurs zéro | Affiche aussi les champs vides ; les chaînes sont toujours affichées |

### Vue d'administration

| Paramètre | Signification |
|---|---|
| Pré-tri admin | Colonne selon laquelle trier d'abord |
| Administrateur auxiliaire | Donne aux administrateurs auxiliaires accès aux statistiques des joueurs |
| Administrateur auxiliaire (colonnes) | Donne en plus aux administrateurs auxiliaires accès à la gestion des colonnes |
