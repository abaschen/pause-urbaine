# Pause Urbaine - Site Web Statique

## 1. Vue d'ensemble du projet

Création d'un site web statique moderne et multilingue (français/anglais) pour le salon de coiffure "Pause Urbaine" avec deux emplacements. Le site remplacera l'installation WordPress actuelle par une solution statique plus performante, hébergée sur AWS S3 (production) et GitHub Pages (développement).

## 2. Objectifs

- Créer un site web statique rapide et facile à maintenir
- Support multilingue (français par défaut, anglais)
- Permettre à la propriétaire d'ajouter facilement des articles/pages
- Présenter les services et tarifs du salon
- Afficher les informations pour les deux emplacements
- Migrer le contenu existant depuis WordPress
- Optimiser pour les performances et le référencement

## 3. Exigences fonctionnelles

### 3.1 Page d'accueil

**En tant que** visiteur du site  
**Je veux** voir une page d'accueil attrayante avec les derniers articles  
**Afin de** découvrir le salon et ses actualités

**Critères d'acceptation:**
- La page d'accueil affiche le logo "Pause Urbaine"
- Un en-tête visuel attrayant est présent
- Les derniers articles/actualités sont affichés (minimum 3)
- Navigation claire vers les autres sections du site
- Design responsive (mobile, tablette, desktop)
- Temps de chargement < 2 secondes

### 3.2 Gestion de contenu

**En tant que** propriétaire du salon  
**Je veux** pouvoir ajouter facilement des articles et pages  
**Afin de** tenir le site à jour sans compétences techniques avancées

**Critères d'acceptation:**
- Les articles sont créés via des fichiers Markdown
- Structure de dossiers claire et documentée
- Possibilité d'ajouter des images aux articles
- Métadonnées simples (titre, date, description)
- Génération automatique du site après ajout de contenu
- Documentation en français pour l'ajout de contenu

### 3.3 Page Services

**En tant que** visiteur  
**Je veux** voir la liste des services proposés  
**Afin de** connaître les prestations disponibles

**Critères d'acceptation:**
- Liste complète des services de coiffure
- Description de chaque service
- Organisation par catégories (coupes, colorations, soins, etc.)
- Images illustratives si disponibles
- Lien vers la page tarifs

### 3.4 Page Tarifs

**En tant que** visiteur  
**Je veux** consulter les tarifs des prestations  
**Afin de** connaître les prix avant ma visite

**Critères d'acceptation:**
- Tarifs importés depuis `tarifs-2026.jpeg`
- Présentation claire et lisible
- Organisation par catégories de services
- Mise à jour facile des tarifs
- Indication si les tarifs varient selon l'emplacement

### 3.5 Informations des emplacements

**En tant que** visiteur  
**Je veux** trouver les informations de contact et horaires des deux salons  
**Afin de** pouvoir prendre rendez-vous ou me rendre sur place

**Critères d'acceptation:**
- Informations de contact toujours visibles dans l'en-tête du site:
  - Nom des deux emplacements (Plainpalais, Eaux-Vives)
  - Numéro de téléphone cliquable pour chaque emplacement
  - Lien Instagram pour chaque emplacement
- Page contact dédiée avec informations complètes:
  - Adresse complète pour chaque emplacement
  - Horaires d'ouverture détaillés
  - Carte Google Maps intégrée (optionnel)
- Responsive: sur mobile, informations accessibles via menu ou section dédiée
- Navigation facile entre les deux emplacements

### 3.6 Support multilingue

**En tant que** visiteur  
**Je veux** consulter le site dans ma langue (français ou anglais)  
**Afin de** comprendre les informations dans la langue de mon choix

**Critères d'acceptation:**
- Langues supportées: français (par défaut) et anglais
- Sélecteur de langue visible dans l'en-tête
- Structure d'URL: `/fr/` pour français, `/en/` pour anglais
- Redirection intelligente depuis la racine `/`:
  - Sur AWS S3/CloudFront: fonction CloudFront détecte la langue du navigateur (Accept-Language)
  - Redirige vers `/fr/` ou `/en/` selon la préférence
  - Sur GitHub Pages: redirection par défaut vers `/fr/` (pas de détection de langue)
- Fallback toujours vers français si langue non supportée
- Contenu traduit pour toutes les pages statiques
- Articles/actualités peuvent être monolingues (français uniquement acceptable)
- Indication visuelle de la langue active
- URLs canoniques et hreflang pour SEO

### 3.7 Navigation et menu

**En tant que** visiteur  
**Je veux** naviguer facilement sur le site et voir les informations de contact  
**Afin de** trouver rapidement l'information recherchée et contacter le salon

**Critères d'acceptation:**
- Menu principal avec: Accueil, Services, Tarifs, Contact
- Sélecteur de langue (FR/EN) dans l'en-tête
- Informations des deux emplacements toujours visibles dans l'en-tête:
  - Nom de chaque emplacement (Plainpalais, Eaux-Vives)
  - Numéro de téléphone cliquable pour chaque emplacement
  - Lien Instagram pour chaque emplacement
  - Icônes pour téléphone et Instagram
- Sur mobile: informations de contact accessibles via menu hamburger ou section dédiée
- Menu responsive (hamburger sur mobile)
- Liens actifs indiqués visuellement
- Footer avec informations de contact complètes et réseaux sociaux
- Accessibilité clavier
- Navigation préserve la langue sélectionnée

## 4. Exigences techniques

### 4.1 Générateur de site statique

**Critères d'acceptation:**
- Utilisation de Hugo (ou alternative justifiée: Eleventy, Astro)
- Support multilingue natif (i18n)
- Langue par défaut: français (fr-FR)
- Langue secondaire: anglais (en-US)
- Thème moderne et responsive
- Support des articles en Markdown
- Génération rapide du site (< 5 secondes)
- Fichiers de traduction pour les chaînes de l'interface

### 4.2 Hébergement

**Critères d'acceptation:**
- Production: AWS S3 avec CloudFront (CDN)
  - CloudFront Function (pas Lambda@Edge) pour détection de langue (Accept-Language header)
  - Redirection `/` vers `/fr/` ou `/en/` selon préférence navigateur
  - Cache configuré par langue
  - Coûts minimaux (CloudFront Functions incluses dans le prix CloudFront)
- Développement: GitHub Pages
  - Redirection simple `/` vers `/fr/` (pas de détection de langue)
  - Fallback vers français
- HTTPS activé
- Nom de domaine personnalisé configuré
- Déploiement automatisé via GitHub Actions

### 4.3 Performance

**Critères d'acceptation:**
- Score Lighthouse > 90 (Performance, Accessibilité, SEO)
- Images optimisées (WebP avec fallback)
- CSS et JS minifiés
- Lazy loading des images
- Temps de chargement initial < 2 secondes

### 4.4 SEO et métadonnées

**Critères d'acceptation:**
- Balises meta appropriées (title, description) par langue
- Balises hreflang pour chaque page (`<link rel="alternate" hreflang="fr" />` et `<link rel="alternate" hreflang="en" />`)
- URL canonique pour chaque version linguistique
- Open Graph pour réseaux sociaux (avec langue spécifiée)
- Sitemap.xml généré automatiquement (avec URLs des deux langues)
- Robots.txt configuré
- Données structurées Schema.org (LocalBusiness) avec support multilingue

### 4.5 Accessibilité

**Critères d'acceptation:**
- Conformité WCAG 2.1 niveau AA
- Navigation au clavier fonctionnelle
- Textes alternatifs pour toutes les images
- Contraste de couleurs suffisant
- Tailles de police lisibles

## 5. Migration du contenu

### 5.1 Import WordPress

**Critères d'acceptation:**
- Extraction du contenu depuis `WordPress.2026-02-20.xml`
- Conversion des articles en Markdown
- Téléchargement et optimisation des images
- Préservation des métadonnées (dates, auteur)
- Vérification de tous les liens

### 5.2 Import des tarifs

**Critères d'acceptation:**
- Extraction des tarifs depuis `tarifs-2026.jpeg`
- Conversion en format structuré (YAML ou JSON)
- Intégration dans le template de la page tarifs
- Vérification de l'exactitude des données

## 6. Contraintes

- Site bilingue (français/anglais), français par défaut
- Détection de langue uniquement sur AWS CloudFront (pas sur GitHub Pages)
- Pas de système de réservation en ligne (phase 1)
- Pas de système de commentaires
- Pas de base de données
- Budget hébergement minimal (S3 + CloudFront + CloudFront Functions)
- Utiliser CloudFront Functions au lieu de Lambda@Edge pour minimiser les coûts

## 7. Livrables

1. Site web statique fonctionnel (bilingue)
2. CloudFront Function pour détection de langue (pas Lambda@Edge)
3. Documentation d'utilisation en français
4. Guide de déploiement (AWS et GitHub Pages)
5. Scripts de build et déploiement
6. Configuration GitHub Actions
7. Fichiers de traduction (i18n)
8. README avec instructions de développement local
9. Documentation des coûts AWS estimés

## 8. Critères de succès

- Site accessible et fonctionnel sur tous les navigateurs modernes
- Support complet français/anglais avec changement de langue fluide
- Détection automatique de langue fonctionnelle sur CloudFront
- Temps de chargement < 2 secondes (toutes langues)
- Score Lighthouse > 90
- Propriétaire capable d'ajouter du contenu de manière autonome
- Coûts d'hébergement < 5€/mois
- Site déployé et accessible via le domaine pauseurbaine.com
- SEO optimisé pour les deux langues
