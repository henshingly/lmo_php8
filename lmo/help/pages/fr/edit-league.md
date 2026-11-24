# Modifier une ligue

1. [Créer une ligue](#1-creer-une-ligue)
2. [Ouvrir une ligue](#2-ouvrir-une-ligue)
3. [Éditeur de résultats](#3-editeur-de-resultats)
4. [Paramètres de base](#4-parametres-de-base)
5. [Classement manuel](#5-classement-manuel)
6. [Éditeur des équipes](#6-editeur-des-equipes)

---

## 1. Créer une ligue

Clique sur **Nouveau** dans le menu pour créer une nouvelle ligue. Le processus comporte 4 étapes :

**Étape 1 :** Définis le **nom de fichier** de la ligue, sans chemin ni extension, qui sont préréglés. La saisie ne doit pas dépasser 28 caractères. Donne à la ligue un **nom** parlant, qui apparaît dans les listes et comme titre dans l'espace visiteur. Outre le titre, mentionne aussi la saison, p. ex. `1re ligue départementale Springfield 2001/02`. Choisis aussi si tu crées une **ligue** (avec points, classement, etc.) ou un **tournoi à élimination directe** (play-off ou similaire). Clique sur **Suivant**.

**Étape 2 :** Définis le **nombre d'équipes**. Pour une ligue, tu saisis aussi le **nombre de journées** et les **matchs par journée**. Pour les tournois à élimination directe, cela disparaît, car ces valeurs découlent du nombre d'équipes. Clique sur **Suivant**.

**Étape 3 :** Pour les ligues, la **création du calendrier** suit. Tu peux reprendre un calendrier d'une autre ligue (possible uniquement pour des ligues ayant le même nombre d'équipes, de matchs et de journées), générer un **calendrier aléatoire** (le système connu de LM98Free ; possible uniquement pour une ligue « normale » où chaque équipe joue un match aller et un match retour contre chaque adversaire, comme en Bundesliga) ou l'ignorer complètement. Pour les tournois à élimination directe, tu définis ici le **mode de jeu** des différents tours. Clique sur **Suivant**.

**Étape 4 :** La **ligue est enregistrée !** Tu dois ensuite modifier les [équipes](#6-editeur-des-equipes), qui sont d'abord simplement numérotées. Si tu as repris le calendrier d'une autre ligue, jette d'abord un œil à l'espace visiteur pour trouver l'attribution correcte des équipes.

---

## 2. Ouvrir une ligue

Après t'être [connecté](#getting-started/6-connexion-deconnexion), tu vois directement un aperçu de toutes les ligues disponibles. Sinon, clique sur **Ouvrir** dans le menu. Choisis la ligue que tu veux modifier. Les [administrateurs auxiliaires](#options/administrateurs-auxiliaires) ne voient que les ligues qui leur sont autorisées.

---

## 3. Éditeur de résultats

Après l'[ouverture d'une ligue](#2-ouvrir-une-ligue), tu arrives automatiquement dans l'éditeur de résultats avec la journée en cours. Avec le menu de sélection sous le menu, tu peux aussi afficher d'autres journées.

**Date :** Tout en haut, tu peux définir la **date de début et de fin** de la journée. Le format est `JJ.MM.AAAA`. Veille à saisir la date avec un jour et un mois à deux chiffres et une année à quatre chiffres, séparés par des points. À côté des champs de date, un bouton ouvre un calendrier contextuel où tu choisis la date d'un clic. Ces dates ne sont montrées aux visiteurs que si le [paramètre](#4-parametres-de-base) **Date de la journée** est actif.

**Dates de coup d'envoi :** Chaque match peut recevoir une **date de coup d'envoi**, également au format `JJ.MM.AAAA`, et là aussi un bouton ouvre le calendrier contextuel. Si tu saisis une date mais pas d'heure, l'[heure de coup d'envoi par défaut](#options/1-options-globales) est utilisée. Saisis les heures au format `HH:MM` (heure et minute à deux chiffres, séparées par `:`).

**Équipes :** Tu choisis les équipes via les listes déroulantes.

**Saisir les résultats :** Le plus simple est d'utiliser les boutons fléchés à côté des champs de résultat. Tu peux aussi saisir directement des nombres ou utiliser les touches fléchées quand le curseur est dans le champ. Avec les décimales activées, tu saisis toujours les résultats en nombres entiers ; la conversion n'a lieu qu'à l'affichage.

**Fin du match :** Pour les ligues avec [fin de match ouverte](#4-parametres-de-base) ou les tournois à élimination directe, tu indiques comment le match s'est terminé : normalement (\_), après prolongation (a.p.) ou aux tirs au but (t.a.b.).

> **Remarque :** Pour les décisions des instances sportives qui touchent à la fois les points et les buts (p. ex. victoire par forfait), tu n'as pas besoin du champ suivant.

**Décision de table verte :** Ce champ n'est normalement pas nécessaire. Mais il y a toujours des décisions d'instances sportives qui bouleversent les résultats. Indépendamment du résultat saisi, tu peux ici fixer une décision sur le vainqueur. Les buts comptent pour le classement tels que saisis, mais les points suivent ce paramètre. En général, l'instance décide alors par exemple : 0:0 buts et l'équipe X gagne. L'option **résultat commun** s'applique si l'instance tranche le match de la même manière pour les deux équipes (p. ex. 2:0 pour les deux).

**Note :** Tu peux saisir ici une note sur le match, p. ex. le lieu. Une décision normale d'une instance sportive peut aussi y être mentionnée. Les cas particuliers de décisions de table verte n'ont pas besoin d'être mentionnés à nouveau ; ils sont insérés automatiquement comme note.

**URL du compte rendu :** Tu peux facultativement ajouter un lien vers le compte rendu du match. Il n'est affiché que si **Lier les comptes rendus** est actif dans les [paramètres](#4-parametres-de-base).

**Jeu de pronostics :** Si tu utilises le [jeu de pronostics](#addon-betting-game), tu peux exclure des matchs individuels du décompte des points.

**Paramètres indépendants de la journée :** Sous les matchs, tu trouves d'autres paramètres que tu peux ajuster directement ici.

**Journée en cours :** Tu n'as à modifier quelque chose ici que si la journée que tu modifies ne doit *pas* être marquée comme journée en cours, p. ex. quand tu modifies un match reporté ou corriges un ancien résultat. Sélectionne alors la journée qui doit compter comme journée en cours. Sinon, laisse le champ inchangé.

**Ticker d'actualités :** Active le ticker et saisis les messages, un par ligne, sans lignes vides.

Clique sur **Enregistrer la journée et le ticker** pour tout appliquer. Tes modifications sont immédiatement visibles pour les visiteurs, vérifie donc encore une fois !

> Si le [classement manuel](#5-classement-manuel) est actif : un classement manuel précédent de cette journée ou des suivantes est supprimé après l'enregistrement.

---

## 4. Paramètres de base

Tu définis ici tous les paramètres de la ligue. Pour les tournois à élimination directe, seules les options pertinentes sont affichées.

**Valeurs de base**
Le **nom de la ligue** apparaît dans les listes et comme titre dans l'espace visiteur, avec la saison, p. ex. `1re ligue départementale Springfield 2001/02`. Tu définis aussi les **libellés des points et des buts** (adaptables au sport) et peux activer les **points/buts décimaux**. Choisis aussi l'**équipe favorite** et les **équipes par défaut pour le calendrier, la courbe de forme et les statistiques**.

**Liens**
Décide si les [pages d'accueil des équipes](#6-editeur-des-equipes) (dans le classement) et les [comptes rendus](#3-editeur-de-resultats) (dans les résultats et calendriers) sont liés.

**Affichage/Apparence**
Tu décides ici de ce que tu proposes à tes visiteurs. Avec **Vue de départ**, tu détermines ce que les visiteurs voient en premier au chargement de la ligue. Tu peux activer la **date de la journée** et les **dates de coup d'envoi** ; sans les deux, il n'y a pas non plus de calendrier. Le **calendrier** peut aussi être désactivé séparément. Avec les dates de coup d'envoi actives, choisis le **format d'affichage** souhaité.

**Match pour la troisième place** et **Activer le play-down** ne sont disponibles que pour les tournois à élimination directe. Tu décides ici si une petite finale a lieu et si (comme c'est l'usage pour les play-downs) le perdant peut aussi avancer d'un tour.

Le **tableau croisé** et la **courbe de forme** peuvent être désactivés. La courbe de forme est dessinée dans le navigateur et n'a besoin d'aucune bibliothèque serveur. Le tableau croisé a peu de sens s'il n'y a pas de matchs retour (p. ex. matchs de poule d'une Coupe du monde).

**Système de jeu**
Le système de jeu contient tous les paramètres concernant le mode de la ligue.

- Les **points négatifs** existent dans les ligues à 2 points, plus dans les ligues à 3 points.
- La **fin de match ouverte** ne doit être activée que si un match nul est suivi de prolongations et éventuellement de tirs au but.
- Tu ne dois masquer la colonne **Nuls** du classement que s'il n'y a généralement pas de matchs nuls dans ta ligue.
- **Confrontation directe** signifie qu'à égalité de points, la comparaison directe des équipes à égalité est prise en compte.
- Tu n'actives **Buts marqués avant la différence de buts** que si, dans ta ligue, les buts marqués pèsent plus que la différence de buts, ce qui est plutôt rare.
- Tu ne dois activer le **classement manuel** qu'à titre exceptionnel, p. ex. pour des règles spéciales que ce logiciel ne prend pas en compte. Tu peux alors [corriger le classement manuellement](#5-classement-manuel).

**Classement**
Décide quelles entrées de ton classement (et de la courbe de forme) sont mises en évidence ou affichées :

- Classements aller/retour
- Classements domicile/extérieur
- Champion, promu, relégué
- Autres marquages (p. ex. places en Coupe de l'UEFA)

Une valeur de `0` désactive le marquage correspondant.

**Système de points**
Tu configures ici l'attribution des points. Avec les points négatifs activés, les points de victoire sont en même temps des points de défaite négatifs et inversement ; les points de match nul sont comptés pour les deux côtés.

**Nombre de journées et de matchs**
Tu n'as généralement pas besoin de cette fonction. Si tu dois modifier après coup le nombre de journées ou de matchs, tu peux le faire ici. Mais fais d'abord [une sauvegarde](#file-functions/3-telecharger-envoyer-une-ligue-par-courriel) ! Non disponible pour les tournois à élimination directe.

---

## 5. Classement manuel

Si tu as activé le [paramètre](#4-parametres-de-base) **Activer le classement manuel**, l'option **Classement** apparaît en bas de l'[éditeur de résultats](#3-editeur-de-resultats). Clique dessus pour vérifier le classement et, si nécessaire, le corriger manuellement.

Choisis sous le menu la journée dont tu veux modifier le classement. Le classement est affiché tel que le logiciel l'a calculé. Si tout est correct, tu n'as rien à faire.

Sinon, attribue de nouvelles places aux équipes. Chaque place ne doit apparaître qu'une fois (une fonction JavaScript empêche normalement automatiquement les doublons).

Clique ensuite sur **Enregistrer le classement manuel**. Dans l'espace visiteur, le classement (et la courbe de forme) est affiché selon tes corrections.

---

## 6. Éditeur des équipes

Tu peux ici saisir et modifier les **noms des équipes**. L'**abréviation** ne doit pas dépasser 5 caractères.

Si la fédération attribue des points et buts de pénalité ou de bonus, tu peux les saisir ici ; ils sont pris en compte dans le calcul du classement. Tu peux aussi définir à partir de quelle journée la modification prend effet.

Si tu veux lier les pages d'accueil des équipes, saisis les URL dans la colonne correspondante. Les liens apparaissent dans le classement si **Lier les pages d'accueil des équipes** est actif dans les [paramètres](#4-parametres-de-base).

> **Attention :** Pour chaque équipe, il existe des fonctions pour la **retirer** de la ligue et pour **ajouter** une nouvelle équipe **plus tard**. *Fais d'abord [une sauvegarde](#file-functions/3-telecharger-envoyer-une-ligue-par-courriel) !* Si tu utilises le jeu de pronostics pour cette ligue, ces fonctions peuvent provoquer des dysfonctionnements. Ces options ne sont pas disponibles pour les tournois à élimination directe.
