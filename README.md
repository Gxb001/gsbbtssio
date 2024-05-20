# GSB - Gestion des Notes de Frais

## Description

Le projet GSB a pour objectif de développer un site web dynamique destiné à la gestion des notes de frais internes d'une entreprise. Ce système comprend deux types de profils utilisateurs :

- **Comptable** : Réception et traitement des notes de frais.
- **Visiteur** : Création et soumission des notes de frais.

En plus du développement de l'application, le projet inclut la mise en place d'un serveur web sécurisé avec des certificats HTTPS et l'installation d'un logiciel de prise de contrôle à distance sur le serveur Apache.

## Fonctionnalités principales

- **Gestion des utilisateurs** : Authentification et gestion des droits pour les comptables et les visiteurs.
- **Création de notes de frais** : Interface permettant aux visiteurs de créer et soumettre des notes de frais.
- **Traitement des notes de frais** : Interface pour les comptables afin de recevoir, vérifier et traiter les notes de frais soumises.
- **Sécurité** : Mise en place de HTTPS pour sécuriser les communications entre les utilisateurs et le serveur.
- **Administration à distance** : Installation d'un logiciel permettant la prise de contrôle à distance du serveur Apache.

## Technologies utilisées

- **HTML/CSS/JS** : Pour la structure, le style, et l'interactivité des pages web.
- **PHP** : Pour la gestion des requêtes SQL et la logique côté serveur.
- **MySQL** : Base de données pour stocker les informations des utilisateurs et des notes de frais.
- **Apache** : Serveur web utilisé pour héberger l'application.
- **Certificats SSL/TLS** : Pour sécuriser le site avec HTTPS.
- **Logiciel de prise de contrôle à distance** : Pour la gestion et la maintenance à distance du serveur.

## Prérequis

- **Apache** (version 2.4 ou supérieure)
- **PHP** (version 7.4 ou supérieure)
- **MySQL** (version 5.7 ou supérieure)
- **Git** (pour cloner le repository)
- **Certificats SSL/TLS** pour HTTPS

## Installation

1. **Cloner le repository** :

   ```bash
   git clone https://github.com/Gxb001/gsbbtssio.git
   cd gsbbtssio
