# Guide de Dépannage - Pause Urbaine

Ce guide vous aide à résoudre les problèmes courants lors du développement et du déploiement du site.

## Problèmes de Développement Local

### Hugo ne démarre pas

**Symptôme**: Erreur lors de l'exécution de `hugo server`

**Solutions**:

1. Vérifiez que Hugo est installé:
```bash
hugo version
```

2. Assurez-vous d'utiliser Hugo Extended (requis pour SCSS):
```bash
# La version doit mentionner "extended"
hugo version
# Exemple: hugo v0.156.0+extended darwin/arm64
```

3. Si Hugo n'est pas dans votre PATH:
```bash
# Utilisez le chemin complet
~/go/bin/hugo server -D
```

4. Réinstallez Hugo si nécessaire:
```bash
go install github.com/gohugoio/hugo@latest
```

### Erreurs de compilation SCSS

**Symptôme**: `Error: failed to transform resource: SCSS processing failed`

**Solutions**:

1. Vérifiez que vous utilisez Hugo Extended
2. Vérifiez la syntaxe SCSS dans vos fichiers
3. Assurez-vous que tous les imports existent:
```scss
// Dans main.scss
@import 'variables';  // Doit correspondre à _variables.scss
@import 'layout';
@import 'components';
```

### Dépendances npm manquantes

**Symptôme**: Font Awesome ou autres packages ne fonctionnent pas

**Solutions**:

1. Installez les dépendances:
```bash
cd pause-urbaine-website
pnpm install
```

2. Vérifiez que `node_modules` existe
3. Nettoyez et réinstallez si nécessaire:
```bash
rm -rf node_modules pnpm-lock.yaml
pnpm install
```

### Port déjà utilisé

**Symptôme**: `Error: listen tcp :1313: bind: address already in use`

**Solutions**:

1. Utilisez un port différent:
```bash
hugo server -D -p 1314
```

2. Ou tuez le processus existant:
```bash
# Trouver le processus
lsof -i :1313

# Tuer le processus (remplacez PID par le numéro)
kill -9 PID
```

## Problèmes de Contenu

### Page ne s'affiche pas

**Symptôme**: Page 404 ou page vide

**Solutions**:

1. Vérifiez le frontmatter:
```yaml
---
title: "Titre"
draft: false  # Doit être false pour être visible
---
```

2. Vérifiez le nom du fichier:
- Français: `page.fr.md`
- Anglais: `page.en.md`

3. Vérifiez que le fichier est dans le bon dossier (`content/`)

### Traductions manquantes

**Symptôme**: Texte en anglais sur la version française (ou vice versa)

**Solutions**:

1. Vérifiez que les deux fichiers existent:
- `content/page.fr.md`
- `content/page.en.md`

2. Vérifiez les clés de traduction dans `i18n/`:
```yaml
# i18n/fr.yaml
nav:
  home: "Accueil"

# i18n/en.yaml
nav:
  home: "Home"
```

3. Utilisez la bonne syntaxe dans les templates:
```html
{{ i18n "nav.home" }}
```

### Images ne s'affichent pas

**Symptôme**: Image cassée ou 404

**Solutions**:

1. Vérifiez que l'image est dans `static/images/`
2. Utilisez le bon chemin (commence par `/`):
```markdown
![Description](/images/mon-image.jpg)
```

3. Vérifiez le nom du fichier (sensible à la casse)
4. Évitez les espaces dans les noms de fichiers

## Problèmes de Déploiement

### GitHub Actions échoue

**Symptôme**: Workflow rouge dans l'onglet Actions

**Solutions**:

1. Cliquez sur le workflow pour voir les logs
2. Erreurs courantes:

**Hugo build failed**:
- Vérifiez la syntaxe de vos fichiers Markdown
- Vérifiez le frontmatter YAML
- Testez localement avec `hugo --minify`

**npm install failed**:
- Vérifiez `package.json`
- Vérifiez `pnpm-lock.yaml`

**Deploy failed**:
- Vérifiez les permissions GitHub Pages
- Vérifiez que la branche gh-pages existe

3. Relancez le workflow:
- Allez dans Actions
- Cliquez sur le workflow échoué
- Cliquez "Re-run jobs"

### Site ne se met pas à jour après push

**Symptôme**: Changements non visibles sur le site en ligne

**Solutions**:

1. Vérifiez que le workflow a réussi (onglet Actions)
2. Attendez quelques minutes (propagation)
3. Videz le cache du navigateur:
- Chrome/Edge: Ctrl+Shift+R (Cmd+Shift+R sur Mac)
- Firefox: Ctrl+F5
- Safari: Cmd+Option+R

4. Vérifiez en navigation privée

### Erreur 404 sur toutes les pages

**Symptôme**: Seule la page d'accueil fonctionne

**Solutions**:

1. Vérifiez la configuration GitHub Pages:
- Settings → Pages
- Source: GitHub Actions
- Branch: gh-pages

2. Vérifiez `hugo.yaml`:
```yaml
baseURL: "https://votre-username.github.io/pause-urbaine/"
```

3. Reconstruisez et redéployez

## Problèmes de Performance

### Site lent à charger

**Solutions**:

1. Optimisez les images:
```bash
# Utilisez des outils comme ImageOptim, TinyPNG
# Convertissez en WebP si possible
```

2. Vérifiez la taille des assets:
```bash
cd pause-urbaine-website/public
du -sh js/* scss/*
```

3. Vérifiez que la minification est activée:
```bash
hugo --minify
```

4. Testez avec Lighthouse (Chrome DevTools)

### JavaScript ne fonctionne pas

**Symptôme**: Menu mobile ne s'ouvre pas, lazy loading ne fonctionne pas

**Solutions**:

1. Vérifiez la console du navigateur (F12)
2. Vérifiez que les scripts sont chargés:
```html
<!-- Dans baseof.html -->
<script src="{{ $js.RelPermalink }}" defer></script>
```

3. Vérifiez la syntaxe JavaScript dans `assets/js/`
4. Testez localement d'abord

## Problèmes de Configuration

### Menus ne fonctionnent pas

**Symptôme**: Liens de navigation cassés

**Solutions**:

1. Vérifiez `hugo.yaml`:
```yaml
languages:
  fr:
    menu:
      main:
        - identifier: services
          name: Services
          pageRef: /services
          weight: 2
```

2. Utilisez `pageRef` au lieu de `url`
3. Vérifiez que les pages existent

### Changement de langue ne fonctionne pas

**Symptôme**: Bouton de langue ne fait rien

**Solutions**:

1. Vérifiez que les traductions existent
2. Vérifiez le partial language-switcher:
```html
{{ range .Site.Languages }}
  {{ if .IsTranslated }}
    <a href="{{ .Permalink }}">{{ .LanguageName }}</a>
  {{ end }}
{{ end }}
```

3. Vérifiez la configuration des langues dans `hugo.yaml`

## Problèmes de Données

### Tarifs ne s'affichent pas

**Symptôme**: Page tarifs vide ou erreur

**Solutions**:

1. Vérifiez la syntaxe YAML dans `data/pricing.yaml`:
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
```

2. Vérifiez l'indentation (2 espaces, pas de tabs)
3. Validez le YAML en ligne: https://www.yamllint.com/
4. Vérifiez le template qui utilise les données

### Informations de localisation incorrectes

**Symptôme**: Adresse ou téléphone incorrect

**Solutions**:

1. Modifiez `data/locations.yaml`
2. Vérifiez la syntaxe YAML
3. Reconstruisez le site:
```bash
hugo server -D
```

## Outils de Diagnostic

### Vérifier la configuration Hugo

```bash
hugo config
```

### Vérifier les erreurs de build

```bash
hugo --verbose
```

### Lister toutes les pages

```bash
hugo list all
```

### Nettoyer les fichiers générés

```bash
# Supprimer public/ et resources/
rm -rf public resources
hugo
```

### Vérifier les liens cassés

```bash
# Après build
cd public
# Utilisez un outil comme linkchecker
```

## Commandes Utiles

### Développement

```bash
# Démarrer le serveur avec drafts
hugo server -D

# Démarrer avec un port spécifique
hugo server -D -p 1314

# Démarrer et ouvrir dans le navigateur
hugo server -D --navigateToChanged

# Verbose mode pour debugging
hugo server -D --verbose
```

### Build

```bash
# Build production
hugo --minify

# Build avec verbose
hugo --minify --verbose

# Build sans minification (pour debug)
hugo
```

### Git

```bash
# Voir l'état
git status

# Voir les différences
git diff

# Annuler les changements non commités
git restore fichier.md

# Voir l'historique
git log --oneline

# Revenir à un commit précédent
git checkout COMMIT_HASH
```

## Obtenir de l'Aide

### Documentation Officielle

- [Hugo Documentation](https://gohugo.io/documentation/)
- [Hugo Forums](https://discourse.gohugo.io/)
- [Markdown Guide](https://www.markdownguide.org/)
- [YAML Syntax](https://yaml.org/)

### Validation en Ligne

- [YAML Validator](https://www.yamllint.com/)
- [Markdown Preview](https://markdownlivepreview.com/)
- [HTML Validator](https://validator.w3.org/)

### Outils de Test

- [Lighthouse](https://developers.google.com/web/tools/lighthouse) (Chrome DevTools)
- [PageSpeed Insights](https://pagespeed.web.dev/)
- [GTmetrix](https://gtmetrix.com/)

## Checklist de Dépannage

Avant de demander de l'aide, vérifiez:

- [ ] Hugo Extended est installé et à jour
- [ ] Les dépendances npm sont installées
- [ ] Le site fonctionne localement (`hugo server -D`)
- [ ] Les fichiers sont bien nommés (`.fr.md`, `.en.md`)
- [ ] Le frontmatter est correct (pas de `draft: true`)
- [ ] La syntaxe YAML est valide
- [ ] Les chemins d'images commencent par `/`
- [ ] Le workflow GitHub Actions a réussi
- [ ] Le cache du navigateur est vidé

---

Dernière mise à jour : Février 2026
