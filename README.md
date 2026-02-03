# 🃏 Jeu de Cartes - Application Symfony + Vue.js

Application web interactive permettant de générer et trier des mains de cartes selon des règles personnalisables. Le projet utilise **Symfony 7.4** comme API backend et **Vue.js 3** avec **Quasar** et **Tailwind CSS** pour le frontend, offrant une expérience utilisateur moderne et intuitive.

## 📋 Table des matières

- [Description](#-description)
- [Fonctionnalités](#-fonctionnalités)
- [Architecture](#-architecture)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Utilisation](#-utilisation)
- [Structure du projet](#-structure-du-projet)
- [Technologies utilisées](#-technologies-utilisées)
- [API Endpoints](#-api-endpoints)
- [Tests](#-tests)
- [Développement](#-développement)

## 🎯 Description

Cette application permet aux utilisateurs de :
1. **Définir un ordre personnalisé pour les couleurs** (Carreaux, Cœurs, Piques, Trèfles)
2. **Définir un ordre personnalisé pour les valeurs** (As, 2, 3, ..., Roi)
3. **Générer une main aléatoire** de cartes (de 1 à 52 cartes)
4. **Visualiser les cartes triées** selon les règles personnalisées

Le tri s'effectue d'abord par couleur (selon l'ordre choisi), puis par valeur (selon l'ordre choisi).

## ✨ Fonctionnalités

### Fonctionnalités principales
- ✅ Configuration personnalisée de l'ordre des couleurs
- ✅ Configuration personnalisée de l'ordre des valeurs
- ✅ Réorganisation interactive des couleurs et valeurs (déplacement haut/bas)
- ✅ Génération de mains aléatoires (1 à 52 cartes)
- ✅ Tri automatique des cartes selon les règles définies
- ✅ Interface utilisateur moderne avec Vue.js, Quasar et Tailwind CSS
- ✅ Gestion d'état via sessions Symfony
- ✅ Architecture API REST séparée

### Fonctionnalités bonus
- 🔄 Réorganisation dynamique avec animations fluides
- 🎨 Design moderne avec glassmorphism et effets visuels
- 📱 Design responsive et adaptatif
- ⚡ Transitions et animations optimisées
- 🎯 UX moderne avec feedback visuel

## 🏗 Architecture

### Architecture séparée (Backend/Frontend)

Le projet suit une architecture moderne avec séparation des responsabilités :

- **Backend (Symfony)** : API REST uniquement, retourne du JSON
- **Frontend (Vue.js)** : Single Page Application (SPA) avec Vue Router
- **Communication** : Axios pour les appels API avec gestion des sessions

### Pattern MVC côté Backend

- **Model** : Services (`CardService`, `GameService`, `GameStateService`)
- **View** : JSON responses (API REST)
- **Controller** : `GameApiController` (endpoints API)

### Services

#### CardService
Gère la logique liée aux cartes :
- Génération d'ordres aléatoires (couleurs, valeurs)
- Tri des mains selon les règles personnalisées

#### GameService
Contient la logique métier du jeu :
- Validation du nombre de cartes
- Génération de mains aléatoires
- Réorganisation d'éléments dans un tableau

#### GameStateService
Gère l'état de la partie via les sessions :
- Stockage des ordres de couleurs/valeurs
- Gestion des confirmations d'étapes
- Persistance de la main générée

## 🔧 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.2
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js** >= 18.x et **npm**
- **Symfony CLI** (optionnel mais recommandé)

## 📦 Installation

### 1. Cloner le projet (si applicable)

```bash
git clone <url-du-repo>
cd card-game
```

### 2. Installer les dépendances Backend (Symfony)

```bash
composer install
composer require nelmio/cors-bundle
```

### 3. Installer les dépendances Frontend (Vue.js)

```bash
cd frontend
npm install
cd ..
```

### 4. Configuration

#### Backend
Créez un fichier `.env.local` si nécessaire :
```bash
APP_ENV=dev
APP_SECRET=your-secret-key-here
```

#### Frontend
Créez un fichier `.env` dans le dossier `frontend/` :
```bash
cd frontend
cp .env.example .env
```

Le fichier `.env` contient :
```
VITE_API_URL=http://localhost:8000/api
```

## 🚀 Utilisation

### Démarrer les serveurs

Vous devez démarrer deux serveurs :

#### Terminal 1 - Backend Symfony (API)

```bash
# Option 1 : Serveur PHP intégré
php -S localhost:8000 -t public

# Option 2 : Symfony CLI
symfony server:start
```

Le backend sera accessible sur **http://localhost:8000**

#### Terminal 2 - Frontend Vue.js

```bash
cd frontend
npm run dev
```

Le frontend sera accessible sur **http://localhost:3000**

### Workflow de l'application

1. **Page d'accueil** : Cliquez sur "Commencer"
2. **Étape 1 - Choix des couleurs** : 
   - Un ordre aléatoire des couleurs est généré
   - Vous pouvez réorganiser l'ordre en cliquant sur les flèches haut/bas
   - Cliquez sur "Confirmer cet ordre" une fois satisfait
3. **Étape 2 - Choix des valeurs** :
   - Un ordre aléatoire des valeurs est généré
   - Réorganisez l'ordre si nécessaire
   - Cliquez sur "Confirmer cet ordre"
4. **Étape 3 - Nombre de cartes** :
   - Entrez le nombre de cartes souhaité (entre 1 et 52)
   - Cliquez sur "Confirmer"
5. **Étape 4 - Visualisation** :
   - Visualisez votre main non triée
   - Cliquez sur "Continuer vers la main triée"
6. **Étape 5 - Résultat** :
   - Visualisez les cartes triées selon vos règles
   - Option de retour ou de réinitialisation

## 📁 Structure du projet

```
card-game/
├── public/                        # Application Vue.js (Frontend)
│   ├── src/
│   │   ├── components/            # Composants réutilisables
│   │   │   ├── ModernCard.vue     # Carte principale réutilisable
│   │   │   ├── ActionButton.vue   # Bouton d'action réutilisable
│   │   │   ├── ReorderableItem.vue # Élément réordonnable
│   │   │   ├── CardItem.vue       # Carte individuelle du jeu
│   │   │   ├── CardsGrid.vue      # Grille de cartes
│   │   │   └── README.md          # Documentation des composants
│   │   ├── views/                 # Pages Vue.js
│   │   │   ├── Home.vue
│   │   │   ├── ChooseColors.vue
│   │   │   ├── ChooseValues.vue
│   │   │   ├── ChooseGameMode.vue
│   │   │   ├── ShowCards.vue
│   │   │   └── ShowSortedCards.vue
│   │   ├── services/              # Services API
│   │   │   ├── api.js             # Configuration Axios
│   │   │   └── gameService.js     # Service de jeu
│   │   ├── router/                # Vue Router
│   │   │   └── index.js
│   │   ├── styles/                # Styles CSS
│   │   │   ├── main.css           # Styles Tailwind CSS
│   │   │   └── common.css         # Styles communs partagés
│   │   ├── App.vue                # Composant racine
│   │   └── main.js                # Point d'entrée
│   ├── index.html
│   ├── vite.config.js             # Configuration Vite
│   ├── tailwind.config.js         # Configuration Tailwind
│   ├── package.json
│   └── .env
├── server/                        # Application Symfony (Backend)
│   ├── config/                    # Configuration Symfony
│   │   ├── packages/
│   │   │   ├── nelmio_cors.yaml   # Configuration CORS
│   │   │   └── framework.yaml
│   │   └── routes.yaml
│   ├── public/                    # Point d'entrée web Symfony
│   │   └── index.php
│   ├── src/
│   │   ├── Controller/
│   │   │   └── Api/
│   │   │       └── GameApiController.php  # Contrôleur API REST
│   │   ├── Service/
│   │   │   ├── CardService.php    # Service de gestion des cartes
│   │   │   ├── GameService.php    # Service de logique métier
│   │   │   └── GameStateService.php   # Service de gestion d'état (session)
│   │   └── Kernel.php
│   ├── tests/
│   │   └── Service/
│   │       └── CardServiceTest.php    # Tests unitaires
│   ├── composer.json              # Dépendances PHP
│   └── vendor/                    # Dépendances PHP installées
└── README.md
```

## 🛠 Technologies utilisées

### Backend
- **Symfony 7.4** : Framework PHP moderne
- **PHP 8.2+** : Langage de programmation
- **Nelmio CORS Bundle** : Gestion CORS pour l'API

### Frontend
- **Vue.js 3** : Framework JavaScript réactif
- **Vue Router 4** : Routage côté client
- **Quasar Framework** : Composants UI modernes
- **Tailwind CSS 3.4** : Framework CSS utility-first
- **Axios** : Client HTTP pour les appels API
- **Vite 7.x** : Build tool moderne et rapide

### Architecture Frontend
- **Composants réutilisables** : Architecture modulaire avec composants Vue réutilisables
  - `ModernCard` : Carte principale avec glassmorphism
  - `ActionButton` : Boutons d'action standardisés
  - `ReorderableItem` : Éléments réordonnables avec contrôles
  - `CardItem` : Affichage de cartes individuelles
  - `CardsGrid` : Grille de cartes avec transitions
- **Styles partagés** : `common.css` pour les styles communs

> 📖 **Documentation complète des composants** : Voir [`public/src/components/README.md`](public/src/components/README.md)

### Outils de développement
- **Composer** : Gestionnaire de dépendances PHP
- **npm** : Gestionnaire de paquets Node.js
- **Git** : Contrôle de version

## 📡 API Endpoints

Tous les endpoints sont préfixés par `/api/game` :

| Endpoint | Méthode | Description |
|----------|---------|-------------|
| `/api/game/initialize` | POST | Initialiser le jeu |
| `/api/game/color-order` | GET | Obtenir l'ordre des couleurs |
| `/api/game/color-order/new` | POST | Générer un nouvel ordre de couleurs |
| `/api/game/color-order/reorder` | POST | Réorganiser les couleurs |
| `/api/game/color-order/confirm` | POST | Confirmer l'ordre des couleurs |
| `/api/game/values-order` | GET | Obtenir l'ordre des valeurs |
| `/api/game/values-order/new` | POST | Générer un nouvel ordre de valeurs |
| `/api/game/values-order/reorder` | POST | Réorganiser les valeurs |
| `/api/game/values-order/confirm` | POST | Confirmer l'ordre des valeurs |
| `/api/game/cards-number` | POST | Confirmer le nombre de cartes |
| `/api/game/unsorted-hand` | GET | Obtenir la main non triée |
| `/api/game/sorted-hand` | GET | Obtenir la main triée |
| `/api/game/reset` | POST | Réinitialiser le jeu |

### Format des réponses

Toutes les réponses sont au format JSON :

```json
{
  "colorOrder": [...],
  "success": true,
  "error": "Message d'erreur si applicable"
}
```

## 🧪 Tests

### Exécuter les tests

```bash
# Si PHPUnit est installé
vendor/bin/phpunit

# Ou avec Symfony
php bin/phpunit
```

### Tests disponibles

- `CardServiceTest::testSortHand()` : Test du tri des cartes

### Installation de PHPUnit (si nécessaire)

```bash
composer require --dev phpunit/phpunit
```

## 💻 Développement

### Build de production

#### Frontend

```bash
cd frontend
npm run build
```

Les fichiers compilés seront dans `public/frontend/`

#### Backend

Le backend Symfony reste inchangé. Assurez-vous que les routes API sont accessibles.

### Cache Symfony

En cas de problème, vider le cache :

```bash
php bin/console cache:clear
```

### Configuration CORS

Le fichier `config/packages/nelmio_cors.yaml` est configuré pour autoriser les requêtes depuis `http://localhost:3000`.

Si vous changez le port du frontend, modifiez la configuration CORS.

### Variables d'environnement

#### Backend
- `APP_ENV` : Environnement (dev, prod)
- `APP_SECRET` : Clé secrète Symfony

#### Frontend
- `VITE_API_URL` : URL de l'API Symfony (défaut: http://localhost:8000/api)

## 🔒 Sécurité

- Validation des entrées utilisateur (nombre de cartes)
- Utilisation des sessions Symfony sécurisées
- Protection contre les injections (type casting explicite)
- Configuration CORS pour limiter les origines autorisées
- Gestion des erreurs API avec messages appropriés

## 🐛 Dépannage

### Erreurs CORS

Si vous voyez des erreurs CORS :
1. Vérifiez que `nelmio/cors-bundle` est installé : `composer show nelmio/cors-bundle`
2. Vérifiez la configuration dans `config/packages/nelmio_cors.yaml`
3. Videz le cache Symfony : `php bin/console cache:clear`
4. Redémarrez le serveur Symfony

### Sessions non persistantes

Si les sessions ne persistent pas :
1. Vérifiez que `withCredentials: true` est configuré dans `frontend/src/services/api.js`
2. Vérifiez que les cookies sont envoyés dans les requêtes (onglet Network du navigateur)

### Port déjà utilisé

- **Frontend** : Modifiez le port dans `frontend/vite.config.js` (ligne `port: 3000`)
- **Backend** : Utilisez un autre port avec `php -S localhost:8080 -t public` et mettez à jour `VITE_API_URL` dans `.env`

## 📄 Licence

Ce projet est un exercice de développement. Tous droits réservés.

## 👤 Auteur

Développé dans le cadre d'un exercice technique.

## 🤝 Contribution

Ce projet est un exercice individuel. Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue.

---

**Bon jeu ! 🃏**
