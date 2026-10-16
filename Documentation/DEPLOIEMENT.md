# Déploiement de SuperCar

Ce document explique comment mettre le site en ligne, et **pourquoi** il est
découpé en deux parties.

---

## 1. Le principe : un seul dossier exposé au web

Le site est séparé en deux :

| Partie | Contenu | Emplacement en ligne |
|---|---|---|
| `public/` | pages, CSS, JS, images | **dans** `htdocs` |
| le reste | `config/`, `includes/`, `modeles/`, `controleurs/`, `vues/` | **hors** de `htdocs` |

### Pourquoi ?

Tout ce qui se trouve dans `htdocs` peut être demandé par un visiteur dans son
navigateur. Si `config/database.php` s'y trouvait, il suffirait de taper son
adresse pour tenter de l'atteindre — et le jour où le serveur ne sait plus
exécuter le PHP (mauvaise configuration, panne de module), il renverrait le
**code source en clair**, avec l'identifiant et le mot de passe de la base.

En plaçant ces dossiers hors de `htdocs`, le serveur ne peut tout simplement
pas les servir : ils n'existent pas dans l'espace web. Le PHP, lui, y accède
sans problème par le système de fichiers.

C'est une protection **structurelle** : elle ne dépend d'aucun fichier de
configuration qu'on pourrait oublier de copier.

---

## 2. Structure à obtenir sur le serveur

```
/home/supercar/                 (exemple, à adapter à l'hébergeur)
│
├── htdocs/                     ← contenu de public/
│   ├── chemins.php             ← LE fichier à configurer
│   ├── index.php
│   ├── voitures.php
│   ├── ... (les autres pages)
│   ├── css/
│   ├── js/
│   ├── Images-Index/
│   └── ADMIN/
│
└── application/                ← tout le reste, HORS htdocs
    ├── config/
    ├── includes/
    ├── modeles/
    ├── controleurs/
    └── vues/
```

---

## 3. Les étapes

### Étape 1 — copier les fichiers

1. Copier **le contenu** de `public/` dans `htdocs/`
   (le contenu, pas le dossier `public` lui-même).
2. Copier `config/`, `includes/`, `modeles/`, `controleurs/` et `vues/`
   dans un dossier situé **à côté** de `htdocs` — ici `application/`.

### Étape 2 — indiquer où se trouve l'application

Ouvrir `htdocs/chemins.php` et modifier **une seule ligne** :

```php
// En développement :
define('RACINE_APP', dirname(__DIR__));

// En production, remplacer par le chemin réel :
define('RACINE_APP', '/home/supercar/application');
```

Le chemin absolu est donné par l'hébergeur. C'est la **seule** modification de
code nécessaire pour le déploiement.

Si le chemin est faux, le site affiche un message clair
(« Erreur de configuration : RACINE_APP ne pointe pas vers l'application »)
plutôt qu'une page blanche impossible à diagnostiquer.

### Étape 3 — la base de données

1. Créer la base sur le serveur, puis importer, dans cet ordre :
   - `Documentation/creation.sql` (structure)
   - `Documentation/INSERTION.sql` (données)
2. Ouvrir `application/config/database.php` et remplacer les identifiants de
   développement (`root`, mot de passe vide) par ceux de l'hébergeur.

### Étape 4 — activer HTTPS

Dans `application/includes/session.php`, passer le cookie de session en
`secure` une fois le certificat en place :

```php
'secure' => true,
```

Le cookie de session n'est alors plus jamais transmis en clair.

### Étape 5 — masquer les erreurs

En développement, PHP affiche les erreurs à l'écran (pratique). En ligne, elles
révèlent des chemins de fichiers et des détails de la base à un visiteur.
Il faut donc, dans le `php.ini` du serveur :

```ini
display_errors = Off
log_errors = On
```

---

## 4. Vérifications après mise en ligne

À faire dans le navigateur, une fois le site en place :

| Test | Résultat attendu |
|---|---|
| Page d'accueil | s'affiche normalement |
| Ajouter une voiture avec une photo (admin) | la photo apparaît bien |
| Connexion / déconnexion client et admin | fonctionne |
| Formulaire de contact | le message arrive en base |

Et surtout, **tester que la protection fonctionne** : essayer d'ouvrir dans le
navigateur une adresse comme

```
https://monsite.fr/config/database.php
https://monsite.fr/../application/config/database.php
```

Le serveur doit répondre **404** (page introuvable) : ces fichiers ne sont pas
dans l'espace web, il ne peut pas les trouver. C'est le comportement voulu.

---

## 5. Note sur les fichiers `.htaccess`

Les dossiers `config/`, `includes/`, `modeles/`, `controleurs/` et `vues/`
contiennent chacun un `.htaccess` avec `Require all denied`.

En production, ils deviennent **inutiles** puisque ces dossiers ne sont plus
dans l'espace web. On les garde quand même, pour deux raisons :

- en développement sous WAMP, tout se trouve sous `www/` : ce sont eux qui
  assurent la protection (elles renvoient 403) ;
- si quelqu'un déployait un jour le projet sans respecter la séparation, ils
  serviraient de seconde barrière.

Une protection en profondeur : deux verrous valent mieux qu'un.
