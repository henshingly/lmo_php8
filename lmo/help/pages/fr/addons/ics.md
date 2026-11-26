# Calendrier ICS

1. [Aperçu](#1-apercu)
2. [Ouvrir la page ICS](#2-ouvrir-la-page-ics)
3. [Téléchargement ou abonnement ?](#3-telechargement-ou-abonnement)
4. [S’abonner dans les applications de calendrier](#4-sabonner-dans-les-applications-de-calendrier)
5. [Questions fréquentes](#5-questions-frequentes)

L’addon ICS permet aux visiteurs d’ajouter le calendrier des matchs d’une équipe à leur propre agenda (Google Agenda, Calendrier Apple, Outlook, Thunderbird et bien d’autres). Si le calendrier est **abonné**, les nouveaux horaires et reports se mettent à jour automatiquement.

> **Remarque :** L’addon ICS ne fait pas partie du paquet LMO, c’est un **téléchargement séparé** : [Dernière version sur GitHub](https://github.com/henshingly/ics-calendar/releases/latest). Décompressez-le dans votre répertoire LMO (il crée `addon/ics/`, `lang/ics/` et `config/ics/`).

---

## 1. Aperçu

| Fichier | Rôle |
|---|---|
| `addon/ics/lmo-ics.php` | la page ICS : choisir la ligue, choisir l’équipe, créer le fichier |
| `lang/ics/lang-<langue>.txt` | textes en 14 langues |
| `config/ics/cfg.txt` | réglages (durée du match, rappel, URL dans l’événement, abréger les noms de clubs) |

Sur la page, vous réglez l’équipe, l’URL de l’événement, la durée du match (minutes) et un rappel avant le coup d’envoi. Le **lien de téléchargement** et le **lien d’abonnement** apparaissent ensuite.

---

## 2. Ouvrir la page ICS

* **Depuis le classement :** si l’option **Lier le calendrier ICS** est activée dans les réglages de base de la ligue, sous *Affichage → Liens*, une petite icône de calendrier apparaît derrière chaque équipe. Un clic ouvre la page ICS de cette équipe.
* **Directement :** ouvrir `addon/ics/lmo-ics.php` et choisir la ligue et l’équipe.

---

## 3. Téléchargement ou abonnement ?

| | Téléchargement (fichier `.ics`) | Abonnement (`webcal://`) |
|---|---|---|
| Effet | import unique des matchs actuels | le calendrier reste relié au LMO |
| Modifications dans le LMO | n’arrivent **pas** | sont reprises automatiquement |
| Convient pour | import unique, appareils sans abonnement | en général le meilleur choix |

Le lien d’abonnement commence par `webcal://`, qui est une autre écriture de `https://`. Pour les programmes qui ne connaissent pas `webcal://`, remplacez-le par `https://` (ou `http://` si le site n’utilise pas HTTPS).

---

## 4. S’abonner dans les applications de calendrier

Copiez d’abord le lien d’abonnement depuis la page ICS. Sur smartphone, il suffit souvent d’appuyer sur le lien ; l’application demande alors si vous voulez vous abonner.

### Google Agenda (ordinateur)

1. Ouvrez [calendar.google.com](https://calendar.google.com).
2. À côté de **Autres agendas**, cliquez sur **+** et choisissez **À partir de l’URL**.
3. Collez le lien en remplaçant `webcal://` par `https://`.
4. Cliquez sur **Ajouter l’agenda**.

L’agenda apparaît ensuite aussi dans l’application Google Agenda sur Android avec le même compte. Google actualise rarement les agendas abonnés ; les modifications peuvent prendre jusqu’à un jour.

### Calendrier Apple (iPhone et iPad)

1. **Réglages → Calendrier → Comptes → Ajouter un compte → Autre → Ajouter un calendrier avec abonnement**.
2. Collez le lien, touchez **Suivant** puis **Enregistrer**.

Vous pouvez aussi toucher le lien `webcal://` et choisir **S’abonner**.

### Calendrier Apple (Mac)

1. Dans Calendrier : **Fichier → Nouvel abonnement à un calendrier**.
2. Collez le lien et cliquez sur **S’abonner**.
3. Réglez le nom et l’intervalle d’actualisation (par exemple toutes les heures ou tous les jours).

### Microsoft Outlook (Windows, classique)

1. **Fichier → Paramètres du compte → Paramètres du compte**.
2. Onglet **Calendriers Internet → Nouveau**.
3. Collez le lien, cliquez sur **Ajouter** et donnez un nom.

### Outlook sur le web et nouvel Outlook

1. **Calendrier → Ajouter un calendrier → S’abonner à partir du web**.
2. Collez le lien (au besoin avec `https://` à la place de `webcal://`), donnez un nom, **Importer**.

L’actualisation peut prendre quelques heures.

### Mozilla Thunderbird

1. Passez à la vue calendrier et choisissez **Nouvel agenda** (symbole plus à côté de « Agendas »).
2. Choisissez **Sur le réseau** puis **Suivant**.
3. Sélectionnez le format **iCalendar (ICS)**, collez le lien dans **Emplacement**, **Suivant** et donnez un nom.
4. Clic droit sur l’agenda → **Propriétés** pour régler l’intervalle d’actualisation (par exemple toutes les 30 minutes).

### Android sans compte Google (et Calendrier Samsung)

Beaucoup de calendriers Android ne peuvent pas ajouter d’abonnements. L’application gratuite **ICSx⁵** (F-Droid ou Play Store) s’abonne aux liens ICS et les met à disposition du calendrier de l’appareil : ouvrez l’application, touchez **+**, collez le lien et enregistrez.

### Autres programmes

Nextcloud, GMX, web.de, IONOS et de nombreux autres services proposent une fonction telle que *s’abonner à un calendrier*, *ajouter un calendrier par URL* ou *calendrier Internet*. Saisissez-y le lien, en cas de doute avec `https://` au début.

---

## 5. Questions fréquentes

**Le calendrier affiche tard les nouveaux horaires.**
C’est l’application de calendrier qui décide, pas le LMO. Google et Outlook sur le web actualisent rarement ; Apple et Thunderbird peuvent être réglés pour une actualisation plus fréquente.

**Je ne vois aucun match.**
Le calendrier ne contient que les matchs ayant une date. Sous la liste, la page indique combien de matchs sans date manquent.

**Les heures sont décalées.**
Les heures sont calculées avec le fuseau horaire réglé dans le LMO et transmises au calendrier en UTC. Vérifiez le fuseau horaire dans les options du LMO et dans votre calendrier.

**L’abonnement ne fonctionne pas.**
Le lien doit être accessible de l’extérieur (pas de protection par mot de passe, pas de serveur uniquement intranet). Testez-le dans le navigateur avec `https://` à la place de `webcal://` : un fichier `.ics` doit se télécharger.

**Je veux modifier la durée du match ou le rappel.**
Modifiez les valeurs sur la page ICS et choisissez **Créer le fichier ICS**. Le lien d’abonnement contient ces réglages. Un abonnement existant doit être refait avec le nouveau lien.
