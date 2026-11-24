# Jeu de pronostics (Tippspiel)

1. [Évaluation](#1-evaluation)
2. [Newsletter/Rappel](#2-newsletter-rappel)
3. [Gestion des utilisateurs](#3-gestion-des-utilisateurs)
4. [Saisir des pronostics après coup](#4-saisir-des-pronostics-apres-coup)
5. [Gestionnaire de sauvegardes](#5-gestionnaire-de-sauvegardes)
6. [Options](#6-options)

![Vue des pronostics](./assets/media/tippspiel01.png)

Le LMO 4 intègre un jeu de pronostics complet et flexible, basé sur l'addon de pronostics pour LMO 3 de Frank Albrecht.

---

## 1. Évaluation

Tu évalues ici les ligues sur lesquelles on peut pronostiquer, c'est-à-dire que les points obtenus sont crédités à chaque participant. Tu peux évaluer chaque ligue et chaque journée séparément ou toutes les journées d'une ligue en une fois.

Si plusieurs ligues font l'objet de pronostics, tu peux aussi mettre à jour ici le **classement général**.

Tu crées et mets également à jour ici les **vues des pronostics**, grâce auxquelles tes co-joueurs peuvent voir comment les autres ont pronostiqué. Selon le [réglage des options](#6-options), la vue n'est activée qu'une fois la journée terminée.

---

## 2. Newsletter/Rappel

Tu peux ici envoyer à tes participants différents messages : une **newsletter à tous**, des **courriels personnels** à certains joueurs ou un **rappel** qui leur rappelle d'envoyer leurs pronostics.

Tous les courriels du jeu de pronostics (aussi la confirmation d'inscription, l'activation et le courriel de mot de passe) sont envoyés avec la méthode d'envoi que tu as définie dans les [options globales](#options/envoi-de-courriels-smtp) (PHP `mail()` ou SMTP). Si les courriels n'arrivent pas, configure-y un serveur SMTP et vérifie avec le courriel de test.

Les espaces réservés suivants sont disponibles lors de l'envoi :

| Espace réservé | Signification |
|---|---|
| `[nick]` | Pseudo du participant |
| `[pass]` | Lien pour réinitialiser le mot de passe. Les mots de passe ne sont stockés que sous forme de hachage et ne peuvent pas être envoyés en clair. Via ce lien, le participant définit un nouveau mot de passe. |
| `[name]` | Vrai nom du participant |
| `[spiele]` | Uniquement dans le rappel : liste tous les matchs en attente sur la période indiquée |

---

## 3. Gestion des utilisateurs

Tu gères ici les participants du jeu de pronostics : tu peux **créer de nouveaux participants**, **modifier des participants** et **supprimer des participants**. Les données suivantes de chaque participant peuvent être modifiées :

**Données personnelles**
Mot de passe, nom, adresse, e-mail ; bloqué/activé.

**Abonnements aux courriels**
Le participant doit-il recevoir la newsletter ou le rappel ?

**Équipe**
Dans quelle équipe le participant joue-t-il ? (uniquement avec l'option d'équipes activée)

**Ligues souscrites**
Sur quelles ligues le participant peut-il pronostiquer ?

---

## 4. Saisir des pronostics après coup

Seul l'**administrateur complet** peut saisir ou modifier des pronostics d'un participant après le début ou la fin d'un match, p. ex. si quelqu'un n'a pas pu envoyer ses pronostics à temps.

1. Dans l'administration du jeu de pronostics, choisis **Saisir des pronostics après coup**.
2. Choisis la ligue. Tous les participants qui ont un fichier de pronostics pour cette ligue s'affichent.
3. Clique sur **Modifier les pronostics** pour le participant souhaité. La saisie normale des pronostics de ce participant s'ouvre ; un avertissement rouge signale le mode administrateur.
4. Choisis la journée, saisis les pronostics et enregistre.
5. Effectue ensuite à nouveau l'[évaluation](#1-evaluation).

Cela fonctionne pour tous les types de ligue (ligue, tournoi/KO) et tous les modes de pronostic (résultat, tendance, aussi avec joker). Le verrouillage horaire n'est levé que pour l'administrateur dans ce mode ; les participants ne peuvent toujours pronostiquer que dans le délai.

**Journal :** Chaque saisie après coup est consignée dans `config/tipp/nachtrag.php` (date, administrateur, participant, ligue, journée). Tu vois aussi les entrées directement dans le menu d'administration du jeu de pronostics, sous *Saisir des pronostics après coup*.

---

## 5. Gestionnaire de sauvegardes

Seul l'**administrateur complet** peut créer et restaurer des sauvegardes du jeu de pronostics. Une sauvegarde contient le **dossier des pronostics** (pronostics, évaluations, vues, classement des clubs), le **fichier des données des pronostiqueurs** (`addon/tipp/lmo-tipperauth.php`) et les **règles de points** (`config/tipp/cfg.txt`) sous forme de fichier ZIP. Le dossier des pronostics est défini dans les options sous *Chemins* (par défaut `addon/tipp/tipps/`). Le gestionnaire utilise toujours ce réglage.

**Créer une sauvegarde**

1. Dans l'administration du jeu de pronostics, choisis **Gestionnaire de sauvegardes**.
2. Clique sur **Créer une sauvegarde**. Elle apparaît aussitôt dans la liste avec la date, le type, le nombre de fichiers et la taille.
3. **Télécharger** enregistre le fichier ZIP sur ton ordinateur, **Supprimer** le retire du serveur.

Les sauvegardes sont stockées dans le dossier protégé `config/tipp/backup/` et ne peuvent être téléchargées que via le gestionnaire. Le ZIP contient `tippordner/`, `tipperdatei/`, `punkteregeln/`, un `info.txt` et un `manifest.json` avec des sommes de contrôle.

**Sauvegarde automatique**

Sous *Paramètres*, tu peux faire créer automatiquement une sauvegarde (type *Automatique*) avant chaque évaluation dans l'administration et choisir combien de sauvegardes automatiques sont conservées (0 = toutes). Les plus anciennes sont alors supprimées, les sauvegardes manuelles jamais. L'évaluation automatique lors de la saisie des résultats ne déclenche pas de sauvegarde.

**Restaurer une sauvegarde**

1. Dans la liste, clique sur **Restaurer** à côté de la sauvegarde. Elle est vérifiée entièrement (structure, noms de fichiers, sommes de contrôle).
2. Choisis ce qui doit être restauré (dossier des pronostics, fichier des pronostiqueurs, règles) et comment :
   - **Ajouter et écraser (recommandé) :** les fichiers absents de la sauvegarde sont conservés.
   - **Exactement comme dans la sauvegarde :** les fichiers de pronostics, d'évaluation, de consultation et de clubs absents de la sauvegarde sont supprimés.
3. L'aperçu indique combien de fichiers sont nouveaux, écrasés, inchangés ou supprimés.
4. Pour confirmer, saisis le mot **RESTAURER** et clique sur **Restaurer**.

Avant d'écraser, le gestionnaire crée automatiquement une sauvegarde de l'état actuel (type *Avant restauration*). En cas d'échec, ou si la sauvegarde est endommagée, rien n'est modifié. Cela permet aussi d'annuler une restauration. Les fichiers sont d'abord écrits et vérifiés, puis échangés.

**Téléverser une sauvegarde :** sur un nouveau serveur, tu peux téléverser à nouveau un ZIP téléchargé. Il est vérifié entièrement avant d'être accepté ; les autres fichiers sont refusés.

Toutes les actions (créer, télécharger, supprimer, téléverser, restaurer) figurent dans le **journal** en bas de la page. Sous *Paramètres*, tu définis après combien de jours les entrées sont supprimées automatiquement (0 = jamais). **Effacer le journal** supprime tout le journal.

**Important :** le fichier des pronostiqueurs contient des données d'accès et des adresses e-mail. Traite les sauvegardes téléchargées de manière confidentielle. PHP a besoin de l'extension **Zip** et des droits d'écriture sur `config/tipp/` et sur le dossier des pronostics. Si l'un manque, le gestionnaire le signale. Avec Nginx, le `.htaccess` du dossier de sauvegarde est sans effet ; bloque `config/` dans la configuration du serveur.

---

## 6. Options

C'est la zone la plus vaste et la plus importante du jeu de pronostics. Le mieux est de configurer complètement les options une fois avant le début et de ne plus les modifier notablement pendant le jeu.

**Mode de pronostic**
Choisis si l'on pronostique un résultat exact ou seulement la tendance (victoire/nul/défaite).

**Chemins**
Tu y trouves le chemin où le jeu de pronostics enregistre ses données. La valeur par défaut est `/tipps` ; ne la change pas sans bonne raison. Les données d'accès des participants (pseudos, hachages de mots de passe, adresses) sont dans `addon/tipp/lmo-tipperauth.php`. Le fichier commence par une ligne de protection (`<?php exit; ?>`) que tu ne dois pas supprimer et nécessite le droit d'écriture (666).

**Attribution des points**
Tu configures ici l'attribution des points. Selon le mode de pronostic, il y a des options différentes ; en mode tendance, il y a logiquement moins de réglages.

**Affichage**
Tout ce qui est activé ici apparaît dans la barre de navigation du jeu de pronostics.

**Règles**
Définis le **délai de pronostic**, détermine les **tailles maximales d'équipe** et combien de **jours à l'avance** on peut pronostiquer. Tu peux aussi activer le **pronostic joker** : avec lui, les participants peuvent choisir un match par journée où un pronostic rapporte plus de points. Le **facteur de multiplication** se définit ici.

**Inscription**
Détermine quelles **données** sont obligatoires lors de l'inscription, si une **vérification par e-mail** a lieu, si tu reçois une **notification** pour les nouvelles inscriptions et si les nouveaux participants doivent d'abord être **activés** par toi.

**Envoi des pronostics**
Configure l'aspect de l'envoi des pronostics. En mode résultat, tu peux afficher des **boutons fléchés** (comme dans l'éditeur de résultats). Pour orienter les participants, tu peux afficher les **tendances pronostiquées** et les **pronostics moyens**.

> Il existe deux variantes d'envoi : **par ligue** (par ligue et journée) ou **par date** (tous les matchs de plusieurs ligues sur une période). *Si tu désactives les deux variantes, l'envoi de pronostics n'est pas possible.*

Tu peux aussi décider si les vues des pronostics sont **mises à jour automatiquement** lors de l'envoi des pronostics.

**Vue des pronostics**
Choisis quand la vue des pronostics s'affiche : immédiatement après la saisie, après le délai de pronostic ou seulement après la saisie du résultat. Tu détermines aussi combien de participants sont affichés par page.

**Tableau des pronostics**
Le jeu de pronostics calcule, à partir des pronostics envoyés, un classement pour chaque participant. Tu peux publier un classement de tous les participants ou un classement selon les points apportés.

**Classements des points**
Configure l'affichage du décompte des points : seulement le classement général ou aussi des classements individuels par ligue. Tu décides aussi quelles données personnelles (vrai nom, pseudo, adresse e-mail) sont visibles et avec quel niveau de détail le détail des points est affiché.

**Que compte-t-il en cas d'égalité de points ?**
Tu définis ici les critères de départage : pour les participants à égalité de points, jusqu'à trois critères supplémentaires sont utilisés, par ordre de priorité décroissante.

**Évaluations supplémentaires**
> Décide ce qui est en outre évalué automatiquement lors de la saisie des résultats de la ligue. Si tu l'actives, la mise à jour manuelle n'est plus nécessaire ; avec un très grand nombre de participants, des problèmes de temps d'exécution peuvent toutefois survenir, car cette étape demande beaucoup de calcul.

**Ligues avec pronostics**
Active ici quelles ligues peuvent être jouées, toutes ou seulement certaines. *Seules les ligues activées peuvent être souscrites par les participants.*
