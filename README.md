MiniProjet_PHP_XML
==================

Louis Lafont
Antonin Huvier
Quentin Montant


1 - Créer une base de données en localhost ou autre
2 - Importer le fichier FILMS.sql
3 - Modifier fichier config.php avec vos identifiants
4 - Faire un chmod 777 sur le dossier exports (pour l'IUT)


-------------------------------------------------------
| Navigateurs supportés pour une utilisation optimale |
| (en considérant que ceux-ci sont à jours):          |
| Chrome, Firefox, Opera, Safari                      |
-------------------------------------------------------

**************************
*    Problèmes connus    *
**************************

- Pour l'import penser à copier le fichier valide.dtd dans le fichier à importer juste après la balise précisant que c'est du xml.

exemple :

<?xml version="1.0"?>
<!DOCTYPE FILMS [
  <!ELEMENT FILMS (FILM+)>
  <!ELEMENT FILM (TITRE,GENRES?,DUREE,DATE,PAYS,REALISATEUR,ACTEURS?)>
  <!ELEMENT TITRE (ORIGINAL,FRANCAIS)>
  <!ELEMENT ORIGINAL (#PCDATA)>
  <!ELEMENT FRANCAIS (#PCDATA)>
  <!ELEMENT GENRES (GENRE*)>
  <!ELEMENT GENRE (#PCDATA)>
  <!ELEMENT DUREE (#PCDATA)>
  <!ELEMENT DATE (#PCDATA)>
  <!ELEMENT PAYS (#PCDATA)>
  <!ELEMENT REALISATEUR (#PCDATA)>
  <!ELEMENT ACTEURS (ACTEUR*)>
  <!ELEMENT ACTEUR (#PCDATA)>
]>
...

- Le bouton "Parcourir" pour importer un fichier ne fonctionne pas sur le navigateur "Chromium" (à l'iut).