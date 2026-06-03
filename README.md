# Mini Social Platform

<p align="center">
  <strong>Réseau Social Simplifié - Construit avec Laravel</strong>
</p>

## 📋 Vue d'ensemble

Mini Social Platform est une application web de réseau social complète développée avec Laravel 13.8.0, featuring une messagerie en temps réel, un système d'engagement social (likes, commentaires), et une gestion de contenu multi-média.

### ✨ Fonctionnalités Principales

- **Authentification sécurisée** - Inscription et connexion d'utilisateurs
- **Posts et Feed** - Créer, lire, modifier, supprimer des posts
- **Engagement Social** - Likes et commentaires sur les posts
- **Messagerie en Temps Réel** - Chat privé avec synchronisation en temps réel via Pusher
- **Stories** - Création et visualisation de stories temporaires
- **Gestion d'Amitié** - Système de demandes d'amitié avec acceptation/refus
- **Profil Utilisateur** - Gestion des informations personnelles et avatar
- **Interface Moderne** - Design responsive avec Tailwind CSS

---

## 🚀 Installation Rapide

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js 16+ et npm
- MySQL 5.7+
- Git

### Étapes d'Installation

```bash
# 1. Cloner le dépôt
git clone <repository-url>
cd Mini_Social_Platform

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Copier et configurer le fichier .env
cp .env.example .env

# 5. Générer la clé de l'application
php artisan key:generate

# 6. Configurer la base de données dans .env
# DB_HOST=127.0.0.1
# DB_DATABASE=mini_social
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Exécuter les migrations
php artisan migrate

# 8. Seeder les données de test
php artisan db:seed

# 9. Démarrer le serveur Laravel
php artisan serve

# 10. (Optionnel) Compiler les assets
npm run build
```

Accédez à l'application sur **http://localhost:8000**

---

## 👥 Utilisateurs de Test

Après le seeding, deux utilisateurs de test sont disponibles:

| Utilisateur | Email | Mot de passe |
|-------------|-------|--------------|
| **Alice Johnson** | alice@example.com | password |
| **Bob Smith** | bob@example.com | password |

### Comment Tester le Chat

1. **Onglet 1:** Connectez-vous en tant qu'Alice
2. **Onglet 2 (Incognito):** Connectez-vous en tant qu'Bob  
3. **Alice:** Aller à `/chat/2` et envoyer un message
4. **Bob:** Vérifiez que le message arrive en temps réel
5. **Bob:** Répondre et vérifier qu'Alice reçoit

---

## 📁 Structure du Projet

```
Mini_Social_Platform/
├── app/
│   ├── Events/
│   │   └── MessageSent.php          # Événement de message
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php   # Authentification
│   │       ├── PostController.php   # Gestion des posts
│   │       ├── MessageController.php # Gestion des messages
│   │       ├── StoryController.php  # Gestion des stories
│   │       └── ...
│   └── Models/
│       ├── User.php
│       ├── Post.php
│       ├── Message.php
│       ├── Story.php
│       ├── Comment.php
│       ├── Like.php
│       ├── FriendRequest.php
│       └── StoryView.php
├── database/
│   ├── migrations/   # Schéma de base de données
│   └── seeders/      # Données de test
├── resources/
│   ├── css/          # Styles Tailwind
│   ├── js/           # JavaScript/Echo
│   └── views/        # Blade templates
│       ├── auth/     # Pages d'authentification
│       ├── posts/    # Pages de posts
│       ├── chat.blade.php # Interface de chat
│       └── ...
├── routes/
│   ├── web.php       # Routes web
│   └── channels.php  # Canaux de broadcasting
├── config/
│   ├── app.php
│   ├── database.php
│   └── broadcasting.php
├── RAPPORT_PROJET.tex      # Rapport technique LaTeX
├── RAPPORT_PROJET.pdf      # Rapport PDF compilé
├── SUBMISSION_CHECKLIST.md # Checklist de soumission
└── GUIDE_SOUMISSION.md     # Guide complet de soumission
```

---

## 🗄️ Architecture Base de Données

### Tables Principales

| Table | Description |
|-------|-------------|
| **users** | Utilisateurs avec profil (avatar, bio) |
| **posts** | Posts créés par les utilisateurs |
| **comments** | Commentaires sur les posts |
| **likes** | Likes sur les posts |
| **messages** | Messages privés entre utilisateurs |
| **stories** | Stories avec médias |
| **story_views** | Tracking des vues de stories |
| **friend_requests** | Demandes d'amitié avec statut |

### Diagramme des Relations

```
User (1) ─→ (N) Posts ─→ (N) Comments
  │            ├→ (N) Likes
  │            
  ├→ (N) Messages (sender/receiver)
  ├→ (N) Stories ─→ (N) StoryViews
  └→ (N) FriendRequests
```

---

## 🏗️ Architecture et Stack Technologique

### Backend
- **Framework:** Laravel 13.8.0
- **Language:** PHP 8.2+
- **Base de données:** MySQL
- **ORM:** Eloquent
- **Broadcasting:** Pusher + Laravel Echo
- **Authentication:** Laravel built-in

### Frontend
- **CSS Framework:** Tailwind CSS 4.0
- **JavaScript:** Vanilla ES6+
- **Build Tool:** Vite
- **Templating:** Blade (Laravel)
- **Real-time:** Laravel Echo + Pusher

### Architecture Pattern
- **MVC:** Model-View-Controller
- **Routing:** RESTful routes
- **Events:** Event-driven architecture
- **Channels:** Private broadcasting channels

---

## 🔐 Sécurité

- ✅ **CSRF Protection** - Tokens dans tous les formulaires
- ✅ **Password Hashing** - Bcrypt pour les mots de passe
- ✅ **Authentication** - Middleware d'authentification
- ✅ **Authorization** - Policies pour l'autorisation
- ✅ **Data Validation** - Validation côté serveur
- ✅ **SQL Injection Prevention** - Eloquent queries
- ✅ **XSS Protection** - Échappement des données

---

## 🧪 Routes Principales

### Authentication
- `GET /login` - Formulaire de connexion
- `POST /login` - Traiter la connexion
- `GET /register` - Formulaire d'inscription
- `POST /register` - Traiter l'inscription
- `POST /logout` - Déconnexion

### Posts
- `GET /` - Feed d'actualité
- `POST /posts` - Créer un post
- `DELETE /posts/{post}` - Supprimer un post

### Messages & Chat
- `GET /chat/{userId}` - Interface de chat
- `POST /send-message` - Envoyer un message
- `GET /messages/{userId}` - Récupérer l'historique

### Friends
- `POST /friends/send/{user}` - Envoyer demande d'amitié
- `PATCH /friends/accept/{request}` - Accepter demande
- `PATCH /friends/decline/{request}` - Refuser demande
- `GET /friends/requests` - Voir les demandes

### Profile
- `GET /profile` - Afficher le profil
- `GET /profile/edit` - Éditer le profil
- `POST /profile` - Mettre à jour le profil

---

## 📊 Fichiers de Soumission

Le projet inclut la documentation complète pour la soumission:

| Fichier | Description |
|---------|-------------|
| **RAPPORT_PROJET.tex** | Rapport technique complet en LaTeX |
| **RAPPORT_PROJET.pdf** | Rapport compilé en PDF |
| **SUBMISSION_CHECKLIST.md** | Checklist de soumission détaillée |
| **GUIDE_SOUMISSION.md** | Guide complet pour préparer la soumission |
| **README.md** | Ce fichier |

---

## 🎯 Fonctionnalités Implémentées

### ✅ Authentification et Profil
- [x] Enregistrement d'utilisateurs
- [x] Connexion sécurisée
- [x] Gestion du profil
- [x] Avatar utilisateur

### ✅ Posts et Engagement
- [x] Créer des posts
- [x] Lire le feed
- [x] Modifier/Supprimer ses posts
- [x] Système de likes
- [x] Système de commentaires

### ✅ Messagerie Temps Réel
- [x] Chat privé entre utilisateurs
- [x] Messages synchronisés en temps réel
- [x] Historique des messages
- [x] Indicateur de connexion

### ✅ Stories
- [x] Créer des stories
- [x] Visualiser les stories
- [x] Tracker les vues

### ✅ Gestion d'Amitié
- [x] Envoyer des demandes
- [x] Accepter/Refuser les demandes
- [x] Lister les amis
- [x] Annuler les demandes

---

## 🐛 Dépannage

### Problème: La base de données ne se connecte pas

```bash
# Vérifier votre .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307  # Port XAMPP
DB_DATABASE=mini_social
DB_USERNAME=root
DB_PASSWORD=
```

### Problème: npm run build échoue

```bash
npm install
npm run dev
```

### Problème: Le chat ne fonctionne pas

Vérifiez la configuration Pusher dans `.env`:
```
PUSHER_APP_ID=2154930
PUSHER_APP_KEY=3f380e9e0194de21d229
PUSHER_APP_SECRET=22c6c5ebafeb85bd5fb0
```

### Problème: Les migrations échouent

```bash
# Réinitialiser la base de données
php artisan migrate:fresh
php artisan db:seed
```

---

## 📖 Documentation Supplémentaire

- **[RAPPORT_PROJET.pdf](./RAPPORT_PROJET.pdf)** - Rapport technique détaillé
- **[SUBMISSION_CHECKLIST.md](./SUBMISSION_CHECKLIST.md)** - Checklist de soumission
- **[GUIDE_SOUMISSION.md](./GUIDE_SOUMISSION.md)** - Guide de soumission complet
- **[Laravel Documentation](https://laravel.com/docs)** - Documentation officielle
- **[Pusher Documentation](https://pusher.com/docs)** - Documentation Pusher

---

## 👨‍💻 Technologies Utilisées

- **Laravel 13.8.0** - Web application framework
- **PHP 8.2+** - Langage serveur
- **MySQL** - Base de données
- **Tailwind CSS 4.0** - Framework CSS
- **JavaScript ES6+** - Logique client
- **Pusher** - Service de broadcasting temps réel
- **Laravel Echo** - Client de broadcasting JavaScript
- **Vite** - Build tool moderne
- **Composer** - Gestionnaire de dépendances PHP
- **npm** - Gestionnaire de packages

---

## 📝 Licence

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 🤝 Contributing

Les contributions sont bienvenues! 

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📞 Support

Pour toute question ou problème:

1. Vérifiez d'abord le [GUIDE_SOUMISSION.md](./GUIDE_SOUMISSION.md)
2. Consultez la [documentation Laravel](https://laravel.com/docs)
3. Ouvrez une issue sur GitHub

---

**Créé avec ❤️ pour le cours de développement web**

*Dernière mise à jour: 2 Juin 2026*
