# Options

1. [Options globales](#1-options-globales)
2. [Gestion des addons](#2-gestion-des-addons)
3. [Éditeur de design](#3-editeur-de-design)
4. [Gestion des utilisateurs](#4-gestion-des-utilisateurs)
5. [Archive des ligues](#5-archive-des-ligues)

---

## 1. Options globales

La commande de menu **Options** t'amène à l'espace des options. Tu y définis les paramètres globaux du script. Les administrateurs auxiliaires n'y ont pas accès.

**Paramètres de base :** langue par défaut, répertoire des ligues, heure de coup d'envoi par défaut, format des dates de coup d'envoi, e-mail du webmaster, envoi des courriels (PHP `mail()` ou SMTP) et ordre de tri des ligues dans la sélection de ligue.

**Options du classement :** position de la colonne des points et type d'affichage du classement.

**Affichage/Apparence :** tu décides ici quels composants du LMO sont affichés.

### Envoi de courriels (SMTP)

Tous les courriels du LMO (envoi de ligues par e-mail ; dans le jeu de pronostics inscription, activation, courriels de mot de passe, newsletters et rappels de pronostics) utilisent les paramètres de la zone **Envoi de courriels**. Tu la trouves dans les paramètres de base, juste sous l'e-mail du webmaster. Seul l'administrateur complet voit et modifie ces paramètres.

| Paramètre | Signification |
|---|---|
| Méthode d'envoi | **PHP mail()** est la méthode par défaut et fonctionne si ton serveur est autorisé à envoyer lui-même du courrier. Si les courriels n'arrivent pas ou finissent dans les spams, choisis **Serveur SMTP**. Si le SMTP échoue, le LMO réessaie une fois avec `mail()` en solution de repli. |
| Serveur, port, chiffrement | Tu obtiens ces données auprès de ton fournisseur de messagerie. Les valeurs habituelles sont STARTTLS avec le port 587 ou SSL/TLS avec le port 465. Ne choisis *aucun (non chiffré)* qu'à titre exceptionnel. |
| Nom d'utilisateur, mot de passe | Identifiants de la boîte aux lettres, généralement l'adresse e-mail. Le mot de passe n'est plus jamais affiché après l'enregistrement. Laisse le champ vide pour le conserver inchangé, ou supprime-le avec la case à cocher. Le mieux est d'utiliser une boîte aux lettres distincte, réservée à l'envoi. |
| Adresse d'expéditeur | Facultative. Si elle est vide, l'e-mail du webmaster est utilisé. De nombreux fournisseurs n'autorisent que des expéditeurs correspondant au compte SMTP. |
| Envoyer un courriel de test | Envoie un courriel de test avec les valeurs actuellement saisies (même non enregistrées) à l'e-mail du webmaster, qui doit être enregistré pour cela. Le courriel de test passe uniquement par SMTP, sans repli sur `mail()`, afin que les erreurs soient visibles. Le résultat s'affiche à côté du bouton. |

**Où le mot de passe est-il stocké ?** Chiffré dans `config/smtp/cfg.php`, la clé se trouve dans `config/smtp/key.php`. Les deux fichiers sont protégés contre l'accès direct par une ligne de garde. Note que la clé est sur le même serveur : le chiffrement protège contre le fait que le fichier de configuration devienne accidentellement lisible (p. ex. dans une sauvegarde), mais pas contre une personne ayant accès à tout le répertoire du serveur. Ouvre autant que possible l'espace d'administration via HTTPS. Sur une connexion HTTP, le LMO affiche un avertissement.

---

## 2. Gestion des addons

La gestion des addons contrôle les addons qui étendent le LMO avec des fonctions supplémentaires. Elle s'adresse aux utilisateurs expérimentés. Ne modifie des valeurs ici que si l'addon n'a pas sa propre interface de configuration.

Choisis l'addon dans le menu de sélection et modifie directement les variables de configuration. **La saisie n'est pas vérifiée** ; de mauvaises valeurs peuvent, dans le pire des cas, rendre le LMO inutilisable.

---

## 3. Éditeur de design

Avec l'éditeur de design, tu adaptes les couleurs et les polices à ta page d'accueil. Tu le trouves sous **Options → Éditeur de design**. Il n'est disponible que pour l'administrateur complet. À gauche, tu définis les valeurs ; à droite, tu vois immédiatement l'aspect de l'une de tes ligues avec ces valeurs. Rien n'est appliqué tant que tu n'as pas cliqué sur **Enregistrer les modifications**.

### Structure de l'éditeur

Les paramètres sont organisés en onglets. Tous les onglets appartiennent à **un seul** formulaire : tes saisies sont conservées quand tu changes d'onglet, et un clic sur *Enregistrer les modifications* enregistre tout.

| Onglet | Contenu |
|---|---|
| Cadre extérieur | Arrière-plan de la page, police de base, titre, menu principal et sous-menu de la zone extérieure |
| Cadre intermédiaire | Zone autour de chaque vue avec son propre titre ainsi que menu principal et sous-menu |
| Cadre intérieur | Tableaux : cellules normales, mises en évidence (p. ex. en-têtes de tableau) et liens |
| Classement | Couleurs des places du classement (champion, Ligue des champions, Ligue Europa, barrage de relégation, relégué) et classements domicile/extérieur |
| Zone du tournoi | Couleurs des vainqueurs et des perdants dans les plans de tournoi (tours à élimination directe) |
| Autres options | Tableau croisé, calendrier, week-ends, courbes de forme, tailles de police, soulignement des liens |
| Formulaires | Champs de saisie et boutons |

### L'aperçu en direct

À droite, tu vois une vraie ligue de ton installation (au moins une ligue doit exister). Chaque modification s'affiche immédiatement, même sans enregistrement. Avec les champs de sélection au-dessus, tu choisis

- la **ligue** avec laquelle tester,
- la **vue** (classement, résultats, calendriers, tableau croisé, calendrier) et
- la **largeur** (ordinateur, tablette, smartphone). La mise en page du LMO ne s'adapte pas automatiquement à la largeur de l'écran ; l'aperçu étroit peut donc défiler horizontalement.

**Cliquer au lieu de chercher :** si tu passes la souris sur une zone de l'aperçu, elle reçoit un contour orange et son nom (p. ex. « Cadre intermédiaire : Menu principal »). Un clic ouvre l'onglet correspondant et met le champ en évidence. Les liens de l'aperçu ne sont pas déclenchés.

### Définir couleurs et polices

Tu définis chaque couleur de deux façons : en saisissant un code hexadécimal (`#1b6b2f`, abrégé `#0a0`) ou un nom de couleur anglais (`red`), ou en cliquant sur la case de couleur, qui ouvre le sélecteur de couleurs de ton navigateur.

Pour de nombreux champs, deux couleurs vont ensemble : d'abord l'arrière-plan, puis la couleur de police. Un champ vide ne définit aucune couleur et le navigateur utilise sa valeur par défaut. Il existe aussi des valeurs de bordure (p. ex. `1px solid #000000`), la famille de police (p. ex. `Verdana, sans-serif`) et la taille de police (p. ex. `13px` ou `94%`).

> **Avertissement de contraste :** Si l'arrière-plan et la couleur de police sont trop proches, l'éditeur signale la ligne et l'onglet par un symbole d'avertissement ⚠. Un contraste d'au moins 4,5 pour 1 est recommandé. L'avertissement n'est qu'une indication ; tu peux quand même enregistrer.

**Contrôle de saisie :** Lors de l'enregistrement, toutes les valeurs sont vérifiées. Les valeurs non valides sont ignorées et la valeur précédente est conservée. Ainsi, les fautes de frappe ne peuvent pas endommager la feuille de style.

### Schémas de couleurs

Au-dessus du formulaire, tu choisis un **schéma de couleurs** (Défaut, Vert pelouse, Rouge, Bleu ciel, Orange, Anthracite, Violet, Turquoise, Bordeaux). Un clic bascule en une fois les cadres, menus, tableau croisé et formulaires sur la couleur principale choisie.

- **Sombre :** utilise la variante sombre du schéma.
- **Couleur personnalisée :** ouvre une palette de 108 couleurs. Tu y choisis une couleur, utilises le sélecteur de couleurs du navigateur pour n'importe quelle couleur, ou saisis un code hexadécimal (valide avec Entrée).
- **Défaut** rétablit les couleurs d'origine du LMO.

Un schéma ne modifie volontairement pas les couleurs du classement (champion, promotion/relégation) ni de la zone du tournoi, car elles ont une signification fixe. Ensuite, tu peux affiner chaque couleur à la main. Un schéma, lui aussi, ne prend effet qu'après *Enregistrer les modifications*.

### Designs enregistrés

Sous le formulaire, tu gères tes propres designs sur le serveur, p. ex. un design d'été et un design d'hiver.

- **Enregistrer sous …** stocke les valeurs actuelles sous un nom de ton choix (lettres, chiffres, espaces, `-` et `_`). Si le nom existe déjà, on te demande confirmation avant d'écraser.
- **Charger** reprend le design choisi dans le formulaire et l'aperçu. Il ne devient visible pour les visiteurs qu'après *Enregistrer les modifications*.
- **Supprimer** retire le design choisi.

Les designs sont stockés sous forme de fichiers texte dans `config/design/`. Le dossier `config` doit pour cela être accessible en écriture ; le sous-dossier est créé automatiquement si nécessaire.

### Export et import

**Exporter** télécharge le design actuel (y compris les modifications non enregistrées) sous forme de fichier `lmo-design-AAAAMMJJ.json`, **Importer** charge un tel fichier dans le formulaire. Tu sauvegardes ainsi un design, le transfères vers une autre installation ou le partages avec d'autres exploitants du LMO. À l'import, seuls les champs connus avec des valeurs valides sont repris.

Il existe aussi deux fonctions d'aide : **Valeurs par défaut** remet tous les champs à leurs valeurs d'origine (après confirmation), **Annuler les modifications** annule tout depuis le dernier enregistrement.

### Tes propres ajouts avec style.css

Si l'éditeur de design ne suffit pas, modifie le fichier `template/style.css`. Ses règles CSS sont chargées automatiquement, remplacent les paramètres de l'éditeur de design et sont aussi visibles dans l'aperçu en direct. Tous les paramètres de l'éditeur sont stockés dans `config/cfg.txt` (variables `lmo_…`) et convertis en feuille de style lors de l'appel du LMO.

---

## 4. Gestion des utilisateurs

Tu accèdes à la gestion des utilisateurs via **Options → Gestion des utilisateurs**. Tu vois d'abord tous les administrateurs et administrateurs auxiliaires configurés. Pour en modifier un, sélectionne le compte, change les données et clique sur **Enregistrer**. **Supprimer** retire un compte de façon irréversible.

Pour les administrateurs auxiliaires, tu définis en plus sous **Ligues autorisées** à quelles ligues ils peuvent accéder.

Tu crées un nouveau compte dans la zone **Ajouter un nouvel administrateur**. Les champs sont préremplis, et le mot de passe est un mot de passe aléatoire que tu peux accepter. Attribue ensuite ses droits au nouvel administrateur.

### Administrateurs auxiliaires

Les administrateurs auxiliaires saisissent des résultats mais n'ont accès ni aux paramètres sensibles des ligues ni aux options globales. Pratique si des aides saisissent pour toi les résultats actuels.

### Administrateurs auxiliaires étendus

Si les droits d'un administrateur auxiliaire ne suffisent pas, tu peux les étendre. Un administrateur auxiliaire étendu est un administrateur complet, mais uniquement pour ses ligues :

- Il peut gérer entièrement les ligues qui lui sont attribuées.
- Il n'a pas accès aux options globales.

---

## 5. Archive des ligues

Tu peux ranger les ligues terminées dans l'archive intégrée sans allonger trop la sélection de ligue. Crée un répertoire au nom parlant (p. ex. `Bundesliga`) dans le dossier `ligen/` et déplace-y les ligues. Les répertoires peuvent être imbriqués à volonté.

Si le paramètre correspondant des options globales est actif, tes visiteurs voient l'archive avec un lien pour chaque sous-répertoire. Pour une description, crée le fichier texte `dir-descr.txt` dans un répertoire (p. ex. « Toutes les saisons de Bundesliga de 1963 à 2000 »). Après un clic sur le lien du répertoire, les visiteurs choisissent les ligues comme d'habitude. Tu peux toujours modifier les ligues archivées dans l'espace d'administration.
