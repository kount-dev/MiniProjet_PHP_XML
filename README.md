MiniProjet_PHP_XML
==================

Projet IUT avec PHP et XML

Créer une base de données en localhost ou autre
Importer le fichier FILMS.sql
Modifier fichier config.php avec vos identifiants
Faire un chmod 777 sur le dossier exports (pour l'IUT)

Utiliser l'application web

Pour l'import penser à copier le fichier valide.dtd dans le fichier à importer
juste après la balise précisant que c'est du xml.

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