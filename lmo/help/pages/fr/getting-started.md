# Premiers pas

1. [Introduction](#1-introduction)
2. [Configuration requise](#2-configuration-requise)
3. [Installation](#3-installation)
4. [Corriger les permissions des fichiers](#4-corriger-les-permissions-des-fichiers)
5. [Mise à jour](#5-mise-a-jour)
6. [Connexion/Déconnexion](#6-connexion-deconnexion)
7. [Mentions légales](#7-mentions-legales)

---

## 1. Introduction

Bienvenue dans le Liga Manager Online ! Avec ce script, tu offres à tes visiteurs un service de résultats pour tes ligues préférées. Toute la gestion se fait directement sur le serveur : tu ne fais que saisir les résultats, et tes visiteurs voient immédiatement les classements, statistiques et calendriers à jour.

On accède à l'espace d'administration via `lmoadmin.php`. Il est judicieux de l'ajouter à tes favoris, car, pour des raisons de sécurité, il n'y a aucun lien vers lui dans l'espace visiteur. Tes visiteurs lancent le LMO via le fichier `lmo.php`. Pour l'intégrer à ta page d'accueil, consulte [Personnalisation](#customization/4-integrer-le-lmo-dans-des-sites-existants).

Chaque lien possède une infobulle, de sorte que d'autres explications d'utilisation ne sont généralement pas nécessaires.

---

## 2. Configuration requise

- **Serveur web :** Apache, Nginx ou un autre serveur web avec PHP (Linux ou Windows)
- **PHP :** version **8.2 ou supérieure**
- **Base de données :** inutile, le LMO enregistre tout dans des fichiers (flat files)
- **Extensions PHP :** `mbstring`, `session` et `json` (préinstallées chez presque tous les hébergeurs). Optionnel : **Zip** pour télécharger toutes les ligues et pour les pièces jointes zip des courriels, **OpenSSL** pour l'envoi de courriels par SMTP avec chiffrement (TLS/SSL). Les courbes de forme (ligue et jeu de pronostics) sont dessinées dans le navigateur et n'ont pas besoin de la bibliothèque GD.
- **Droits d'écriture :** PHP doit pouvoir écrire dans les répertoires des ligues, de la configuration et de la sortie. L'installateur le vérifie et définit les droits si possible.
- **Navigateur :** un navigateur récent avec JavaScript activé

> **Remarque pour Apache 2 :** Supprime tous les caractères spéciaux des noms de fichiers des icônes d'équipe. Seuls les lettres et les chiffres sont autorisés.

---

## 3. Installation

L'installation se déroule entièrement dans le navigateur ; tu n'as pas à saisir d'identifiants FTP.

1. Décompresse l'archive ZIP et téléverse **tout son contenu** sur ton serveur en conservant la structure des répertoires.
2. Ouvre le LMO dans ton navigateur, p. ex. `https://www.ton-site.fr/lmo/lmoadmin.php`. **L'installation démarre automatiquement** et configure les chemins, la configuration et les données d'accès.
3. Après une installation réussie, le bouton **Supprimer maintenant le dossier d'installation** apparaît. Clique dessus pour que le dossier `install` ne reste pas sur le serveur.
4. Connecte-toi et change immédiatement le mot de passe (voir [Connexion/Déconnexion](#6-connexion-deconnexion)).

Normalement, le LMO est ensuite prêt à l'emploi. Si l'installation s'interrompt, vérifie d'abord les [permissions des fichiers](#4-corriger-les-permissions-des-fichiers).

### Installation manuelle

> **Nécessaire uniquement si l'installation automatique ne fonctionne pas.**

1. Copie le contenu du dossier `install` dans ton répertoire LMO, puis supprime le fichier `install/install.php`.
2. Crée (ou ouvre) le fichier `config/init-parameters.php` et saisis les deux chemins :

   ```php
   <?php
   $lmo_dateipfad = '/chemin/absolu/vers/lmo'; // chemin de fichier vers le LMO
   $lmo_url = 'https://www.ton-site.fr/lmo'; // URL absolue du LMO
   ```

   Si tu ne connais ni l'un ni l'autre, demande à ton hébergeur.
3. Définis les permissions des fichiers comme décrit dans la section suivante.

---

## 4. Corriger les permissions des fichiers

Le LMO doit pouvoir écrire dans certains dossiers et fichiers. S'il signale que quelque chose n'est pas accessible en écriture, définis les permissions (chmod) comme suit :

![Définir les permissions (chmod)](./assets/media/manual_chmod.png)

**Répertoires (777) :**

- `ligen` et tous les sous-répertoires
- `output`
- `config` et ses sous-répertoires `config/viewer` et `config/smtp`
- `addon/spieler/stats`
- `addon/tipp/tipps` et tous les sous-répertoires

**Fichiers (666) :**

- `config/lmo-auth.php`
- `addon/tipp/lmo-tipperauth.php`
- `config/smtp/cfg.php` et `config/smtp/key.php` (s'ils existent)
- tous les fichiers `cfg.txt` du répertoire `config` et de ses sous-répertoires
- toutes les ligues du répertoire `ligen` et de ses sous-répertoires
- tous les fichiers de `output`, `addon/spieler/stats` et `addon/tipp/tipps` (s'ils existent)

---

## 5. Mise à jour

Lors de la mise à jour d'une installation existante, tes fichiers de configuration et tes ligues ne sont pas écrasés.

1. Sauvegarde d'abord tout ton répertoire LMO (au minimum `ligen`, `config` et `addon/tipp/tipps`).
2. Copie les nouveaux fichiers par-dessus les existants. Tes propres personnalisations (p. ex. dans `template/` ou `img/teams/`) sont conservées tant que tu ne remplaces pas les mêmes fichiers.
3. Ouvre l'espace d'administration. Le LMO signale **Mise à jour détectée**. Clique sur **Lancer l'installation de la mise à jour**.
4. La mise à jour adapte la configuration. Entre autres, les mots de passe des pronostiqueurs du jeu de pronostics sont convertis vers un stockage sécurisé (haché).
5. Ensuite, supprime le dossier `install` avec le bouton **Supprimer maintenant le dossier d'installation**.

> **Remarque :** Si le dossier `config/smtp` n'est pas accessible en écriture, le LMO te le signale. Les paramètres SMTP ne pourront alors être enregistrés qu'après avoir défini les permissions.

---

## 6. Connexion/Déconnexion

L'ouverture de `lmoadmin.php` affiche le formulaire de connexion. Après une nouvelle installation, le nom d'utilisateur `admin` et le mot de passe `lmo` (L, M, O en minuscules) sont prédéfinis. **Change le mot de passe dès que possible** sous [Options → Gestion des utilisateurs](#options/4-gestion-des-utilisateurs) afin qu'aucune personne non autorisée n'obtienne l'accès.

Quand tu es connecté, tu trouves l'entrée **Déconnexion** dans le menu. Utilise-la à la fin de chaque session.

---

## 7. Mentions légales

> Ce script est publié selon les termes de la [GPL](https://www.gnu.org/licenses/gpl.txt). Cela signifie que tu peux utiliser, distribuer et modifier le script, mais qu'aucune garantie n'est donnée. **Les mentions de copyright doivent être conservées dans tous les cas et ne doivent être ni supprimées ni modifiées.**

Bien que le logiciel ait été développé avec soin, aucune responsabilité ne peut être acceptée pour les erreurs ou dommages résultant de son utilisation.
