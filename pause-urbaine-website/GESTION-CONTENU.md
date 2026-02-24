# Guide de Gestion du Contenu - Pause Urbaine

Ce guide vous explique comment gérer et mettre à jour le contenu du site web Pause Urbaine.

## Table des Matières

1. [Structure du Contenu](#structure-du-contenu)
2. [Modifier une Page Existante](#modifier-une-page-existante)
3. [Ajouter un Nouvel Article](#ajouter-un-nouvel-article)
4. [Mettre à Jour les Tarifs](#mettre-à-jour-les-tarifs)
5. [Mettre à Jour les Informations des Salons](#mettre-à-jour-les-informations-des-salons)
6. [Gérer les Traductions](#gérer-les-traductions)
7. [Prévisualiser les Changements](#prévisualiser-les-changements)

## Structure du Contenu

Le contenu du site est organisé dans le dossier `content/` :

```
content/
├── _index.fr.md          # Page d'accueil (français)
├── _index.en.md          # Page d'accueil (anglais)
├── services.fr.md        # Page services (français)
├── services.en.md        # Page services (anglais)
├── tarifs.fr.md          # Page tarifs (français)
├── tarifs.en.md          # Page tarifs (anglais)
├── contact.fr.md         # Page contact (français)
└── contact.en.md         # Page contact (anglais)
```

## Modifier une Page Existante

### 1. Ouvrir le Fichier

Ouvrez le fichier de la page que vous souhaitez modifier dans le dossier `content/`.

Par exemple, pour modifier la page services en français : `content/services.fr.md`

### 2. Comprendre la Structure

Chaque fichier contient deux parties :

**En-tête (Frontmatter)** - entre les `---` :
```yaml
---
title: "Nos Services"
description: "Découvrez nos services de coiffure professionnels"
---
```

**Contenu** - après le deuxième `---` :
```markdown
## Coupes

Nous proposons des coupes modernes et personnalisées...
```

### 3. Modifier le Contenu

Le contenu utilise le format Markdown. Voici les éléments de base :

```markdown
# Titre Principal (H1)
## Sous-titre (H2)
### Sous-sous-titre (H3)

**Texte en gras**
*Texte en italique*

- Liste à puces
- Deuxième élément

1. Liste numérotée
2. Deuxième élément

[Lien vers une page](https://example.com)
```

### 4. Sauvegarder

Sauvegardez le fichier. Les changements seront automatiquement déployés lors du prochain push vers GitHub.


## Ajouter un Nouvel Article

### 1. Créer les Fichiers

Créez deux fichiers dans le dossier `content/actualites/` (créez le dossier s'il n'existe pas) :

```
content/actualites/
├── mon-article.fr.md
└── mon-article.en.md
```

### 2. Ajouter l'En-tête

**Version française** (`mon-article.fr.md`) :
```yaml
---
title: "Titre de l'Article"
date: 2026-02-24
description: "Description courte pour le SEO"
draft: false
---
```

**Version anglaise** (`mon-article.en.md`) :
```yaml
---
title: "Article Title"
date: 2026-02-24
description: "Short description for SEO"
draft: false
---
```

### 3. Ajouter le Contenu

Écrivez votre article en Markdown après l'en-tête :

```markdown
---
title: "Nouvelle Collection Printemps 2026"
date: 2026-02-24
description: "Découvrez nos nouvelles tendances pour le printemps"
draft: false
---

## Introduction

Nous sommes ravis de vous présenter notre nouvelle collection...

## Les Tendances

Cette saison, les coupes courtes sont à l'honneur...

![Image descriptive](/images/collection-printemps.jpg)
```

### 4. Ajouter des Images

1. Placez vos images dans `static/images/`
2. Référencez-les dans votre article : `![Description](/images/nom-image.jpg)`

## Mettre à Jour les Tarifs

### 1. Ouvrir le Fichier de Données

Ouvrez le fichier `data/pricing.yaml`

### 2. Structure du Fichier

Le fichier est organisé par catégories de services :

```yaml
categories:
  - name:
      fr: "Coupes"
      en: "Haircuts"
    services:
      - name:
          fr: "Coupe femme"
          en: "Women's haircut"
        price: "CHF 75"
        duration: "45 min"
        description:
          fr: "Coupe et brushing inclus"
          en: "Cut and blow-dry included"
```

### 3. Modifier un Prix

Pour changer un prix, modifiez simplement la valeur :

```yaml
price: "CHF 80"  # Ancien prix : CHF 75
```

### 4. Ajouter un Nouveau Service

Ajoutez un nouveau service dans la catégorie appropriée :

```yaml
- name:
    fr: "Coupe enfant"
    en: "Children's haircut"
  price: "CHF 40"
  duration: "30 min"
  description:
    fr: "Pour les enfants jusqu'à 12 ans"
    en: "For children up to 12 years old"
```

### 5. Ajouter une Nouvelle Catégorie

Ajoutez une nouvelle catégorie complète :

```yaml
- name:
    fr: "Soins Spéciaux"
    en: "Special Treatments"
  services:
    - name:
        fr: "Soin réparateur"
        en: "Repair treatment"
      price: "CHF 60"
      duration: "45 min"
```

## Mettre à Jour les Informations des Salons

### 1. Ouvrir le Fichier de Données

Ouvrez le fichier `data/locations.yaml`

### 2. Structure du Fichier

```yaml
locations:
  - name:
      fr: "Plainpalais"
      en: "Plainpalais"
    address: "Rue de Carouge 52, 1205 Genève"
    phone: "022 310 4081"
    instagram: "https://www.instagram.com/pauseurbaine/"
    hours:
      - day:
          fr: "Lundi - Vendredi"
          en: "Monday - Friday"
        time: "9h00 - 19h00"
```

### 3. Modifier les Horaires

Pour changer les horaires d'ouverture :

```yaml
hours:
  - day:
      fr: "Lundi - Vendredi"
      en: "Monday - Friday"
    time: "9h00 - 20h00"  # Nouveau horaire
  - day:
      fr: "Samedi"
      en: "Saturday"
    time: "9h00 - 17h00"
```

### 4. Modifier le Téléphone ou Instagram

```yaml
phone: "022 310 4082"  # Nouveau numéro
instagram: "https://www.instagram.com/pauseurbaine_geneve/"  # Nouveau lien
```

## Gérer les Traductions

### 1. Fichiers de Traduction

Les traductions de l'interface sont dans :
- `i18n/fr.yaml` (français)
- `i18n/en.yaml` (anglais)

### 2. Structure

```yaml
nav:
  home: "Accueil"
  services: "Services"
  pricing: "Tarifs"
  contact: "Contact"
```

### 3. Ajouter une Nouvelle Traduction

Ajoutez la même clé dans les deux fichiers :

**i18n/fr.yaml** :
```yaml
booking:
  title: "Réservation"
  button: "Prendre rendez-vous"
```

**i18n/en.yaml** :
```yaml
booking:
  title: "Booking"
  button: "Book an appointment"
```

### 4. Utiliser dans les Templates

Les traductions sont automatiquement utilisées dans les templates Hugo.

## Prévisualiser les Changements

### 1. Lancer le Serveur Local

```bash
cd pause-urbaine-website
hugo server -D
```

### 2. Ouvrir dans le Navigateur

Ouvrez `http://localhost:1313` dans votre navigateur.

### 3. Voir les Changements en Direct

Le site se recharge automatiquement quand vous modifiez un fichier.

### 4. Tester les Deux Langues

- Version française : `http://localhost:1313/fr/`
- Version anglaise : `http://localhost:1313/en/`

## Publier les Changements

### 1. Vérifier les Modifications

```bash
git status
```

### 2. Ajouter les Fichiers Modifiés

```bash
git add .
```

### 3. Créer un Commit

```bash
git commit -m "docs: mise à jour des tarifs printemps 2026"
```

### 4. Pousser vers GitHub

```bash
git push origin master
```

### 5. Déploiement Automatique

Le site sera automatiquement déployé via GitHub Actions dans quelques minutes.

## Conseils et Bonnes Pratiques

### Contenu

- ✅ Écrivez des descriptions claires et concises
- ✅ Utilisez des titres descriptifs
- ✅ Ajoutez des descriptions alt aux images
- ✅ Vérifiez l'orthographe avant de publier
- ✅ Testez toujours localement avant de pousser

### Traductions

- ✅ Maintenez les versions française et anglaise synchronisées
- ✅ Adaptez le contenu à la culture locale, ne traduisez pas mot à mot
- ✅ Vérifiez que les liens fonctionnent dans les deux langues

### Images

- ✅ Optimisez les images avant de les ajouter (max 500 KB)
- ✅ Utilisez des formats modernes (WebP si possible)
- ✅ Nommez les fichiers de manière descriptive
- ✅ Ajoutez toujours une description alt

### SEO

- ✅ Remplissez toujours le champ `description` dans l'en-tête
- ✅ Utilisez des titres descriptifs
- ✅ Créez des URLs lisibles (pas de caractères spéciaux)

## Dépannage

### Le site ne se met pas à jour

1. Vérifiez que vous avez bien poussé vers GitHub
2. Vérifiez l'onglet "Actions" sur GitHub pour voir si le déploiement a réussi
3. Videz le cache de votre navigateur (Ctrl+F5)

### Erreur de syntaxe Markdown

- Vérifiez que les `---` de l'en-tête sont bien présents
- Vérifiez l'indentation dans les fichiers YAML
- Utilisez un validateur Markdown en ligne

### Image ne s'affiche pas

- Vérifiez que l'image est bien dans `static/images/`
- Vérifiez le chemin : `/images/nom-fichier.jpg`
- Vérifiez que le nom de fichier ne contient pas d'espaces

## Support

Pour toute question ou problème, consultez :
- [Documentation Hugo](https://gohugo.io/documentation/)
- [Guide Markdown](https://www.markdownguide.org/)
- [Documentation YAML](https://yaml.org/)

---

Dernière mise à jour : Février 2026
