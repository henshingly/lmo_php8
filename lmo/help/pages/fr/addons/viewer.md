# Viewer

1. [Modèles](#1-modeles)

![Vue utilisateur](./assets/media/viewer01.png)

Le Viewer est un addon pour LMO 4. Il affiche les matchs d'un nombre quelconque d'équipes pour les XX jours précédents/suivants à partir de la date actuelle, toutes ligues confondues. Bien qu'il soit surtout configuré dans l'espace d'administration, le Viewer est un script autonome que tu peux intégrer n'importe où sur ton site web. Via des [modèles](#1-modeles), la sortie peut être conçue librement.

---

## 1. Modèles

Comme pour le LMO, tu peux adapter librement la structure et le design du Viewer. Les modèles se trouvent dans le répertoire `template/viewer`, où tu trouves aussi des exemples.

### Variables globales

| Espace réservé | Signification |
|---|---|
| `<!--Titelzeile-->` | Ligne de titre configurée |
| `<!--VERSION-->` | Mention de copyright avec informations de version, **ne doit être ni modifiée ni supprimée !** |

### Bloc de ligue

| Espace réservé | Signification |
|---|---|
| `<!-- BEGIN Liga -->` / `<!-- END Liga -->` | Bloc de contenu d'une ligue. **Respecte les espaces avant BEGIN et après Liga !** |

Les espaces réservés suivants n'ont de sens qu'à l'intérieur de `<!-- BEGIN/END Liga -->` :

| Espace réservé | Signification |
|---|---|
| `<!--Ligadatum-->` | Date d'enregistrement de la ligue |
| `<!--Liganame-->` | Nom de la ligue |
| `<!--ErgebnisLink-->` | Lien vers l'aperçu des résultats de la ligue |
| `<!--Anfangsspieltag-->` / `<!--Endespieltag-->` | Première et dernière journée affichées (uniquement avec affichage par journées) |
| `<!--Spieltageminus-->` / `<!--Spieltageplus-->` | Nombre de journées affichées vers l'arrière/l'avant (uniquement avec affichage par journées) |
| `<!--Anfangsdatum-->` / `<!--Enddatum-->` | Nombre de jours affichés vers l'arrière/l'avant (uniquement avec affichage par dates) |

### Bloc de journée

| Espace réservé | Signification |
|---|---|
| `<!-- BEGIN Spieltag -->` / `<!-- END Spieltag -->` | Bloc de contenu d'une journée (uniquement avec affichage par journées). **Respecte les espaces avant BEGIN et après Spieltag !** |

Les espaces réservés suivants n'ont de sens qu'à l'intérieur de `<!-- BEGIN/END Spieltag -->` :

| Espace réservé | Signification |
|---|---|
| `<!--AktSpieltag-->` | Cette journée |
| `<!--AktSpieltagLink-->` | Lien vers l'aperçu des résultats de cette journée |

### Bloc de contenu (match)

| Espace réservé | Signification |
|---|---|
| `<!-- BEGIN Inhalt -->` / `<!-- END Inhalt -->` | Bloc de contenu d'un match. **Respecte les espaces avant BEGIN et après Inhalt !** |

Les espaces réservés suivants n'ont de sens qu'à l'intérieur de `<!-- BEGIN/END Inhalt -->` :

| Espace réservé | Signification |
|---|---|
| `<!--Heim-->` / `<!--Gast-->` | Noms d'équipe à la longueur configurée |
| `<!--HeimLang-->` / `<!--GastLang-->` | Nom long de l'équipe |
| `<!--HeimMittel-->` / `<!--GastMittel-->` | Nom de longueur moyenne de l'équipe |
| `<!--HeimKurz-->` / `<!--GastKurz-->` | Nom court de l'équipe |
| `<!--ToreHeim-->` / `<!--ToreGast-->` | Buts des équipes (séparément) |
| `<!--Tore-->` | Résultat du match sous la forme `x:y` |
| `<!--Datum-->` | Date du match |
| `<!--Uhrzeit-->` | Heure du coup d'envoi |
| `<!--Spieltag-->` | Journée du match |
| `<!--Iconheim-->` / `<!--Icongast-->` | Icônes des équipes (petites) |
| `<!--IconMiddleheim-->` / `<!--IconMiddlegast-->` | Icônes des équipes (moyennes) |
| `<!--IconBigheim-->` / `<!--IconBiggast-->` | Icônes des équipes (grandes) |
| `<!--IconBigheimalt-->` / `<!--IconBiggastalt-->` | Icônes des équipes (grandes, alternatives) |
| `<!--Notiz-->` | Note du match |
| `<!--Tabellenlink-->` | Lien vers le classement |
| `<!--Spieltaglink-->` | Lien vers la vue des résultats de la journée |
| `<!--Spielbericht-->` | Lien vers le compte rendu du match |
| `<!--Zeilenklasse-->` | Mise en évidence de la date du jour (`vRow` normal, `vRowHighlight` aujourd'hui) |
| `<!--Ligadatum-->` | Date d'enregistrement de la ligue |
| `<!--Liganame-->` | Nom de la ligue |
