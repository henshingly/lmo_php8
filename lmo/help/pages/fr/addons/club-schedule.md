# Calendrier du club

L'addon Calendrier du club crée un calendrier global de ton club à partir de toutes les ligues du LMO, avec des ligues et équipes au choix. Les fichiers de sortie peuvent être intégrés à ton site via un lien.

![Vue du calendrier du club](./assets/media/vereinsplan01.png)

**Caractéristiques :**

- De nombreuses options de configuration dans l'espace d'administration
- Sortie sous forme de vue dynamique (fonction de défilement par mois) ou de vue statique
- Création de calendriers globaux, à domicile et à l'extérieur
- Liste compacte des résultats relative à la journée en cours
- Export PDF des calendriers du club
- Prise en charge de nombreuses variables de sortie du LMO dans les modèles fournis

---

1. [Configuration requise](#1-configuration-requise)
2. [Configuration](#2-configuration)
3. [Intégration](#3-integration)
4. [Téléchargement](#4-telechargement)
5. [Historique des versions](#5-historique-des-versions)

![Appel de l'administration du calendrier du club](./assets/media/vereinsplan02.png)

---

## 1. Configuration requise

- Un LMO 4 fonctionnel
- Addon Classlib de Tim Schumacher installé (disponible dans l'archive des addons), y compris la classe PDF de [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (contenue dans la Classlib)

---

## 2. Configuration

L'addon **Calendrier du club** se gère via l'interface d'administration du LMO.

![Configuration du calendrier du club](./assets/media/vereinsplan03.png)

---

## 3. Intégration

> Des instructions d'installation détaillées sont fournies avec chaque version.

---

## 4. Téléchargement

- [Calendrier du club version 1.3](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?f=18&t=10473&start=43)
- [Derniers ajustements (GitHub)](https://github.com/henshingly/lmo_addons/commits/main/vereinsplan)

---

## 5. Historique des versions

**1.0.0**

- Sortie de base

**1.1.0**

- Tri des ligues dans l'interface de configuration
- Répertoire des ligues sélectionnable dans l'interface de configuration
- Diverses fonctions de défilement dans le fichier de sortie
- Création de PDF en combinaison avec l'addon LMO PDF Printer 1.0 Alpha 1
- Et bien plus

**1.3.0**

- Prend en charge les liens : calendrier de l'équipe, page d'accueil, classement ou compte rendu du match
- Inclut les écussons d'équipe
- Création de PDF via la Classlib PDF intégrée du LMO
- Importantes extensions de configuration dans l'espace d'administration
- Prend en charge de nombreuses variables de sortie du LMO dans le modèle
- Corrections de bogues issues du forum du LMO
- Et bien plus
