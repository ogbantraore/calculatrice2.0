******************************Introduction de l'application******************************

Cette application est une calculatrice web qui permet aux utilisateurs de réaliser des calculs arithmétiques de base (+, -,*, /) et de sauvegarder leurs calculs dans 
un historique pour consultation ultérieure. Elle utilise PHP pour le backend,SQLite pour le stockage des données, et JavaScript pour la gestion des interactions utilisateur.

**************************************Technologies utilisées**************************************
PHP, JavaScript, HTML, CSS, SQLite.

**************************************Mode d'utilisation**************************************
1. Connexion/Inscription : L'utilisateur se connecte ou s'inscrit en remplissant le formulaire.
2. Création de Séance : L'utilisateur peut créer une nouvelle séance pour enregistrer les calculs.
3. Utilisation de la Calculatrice : Réalisation des calculs en cliquant sur les boutons de l'interface.
4. Historique : L'utilisateur peut visualiser l'historique des calculs réalisés.
5. Déconnexion : Permet de se déconnecter en cliquant sur le bouton de déconnexion.


**************************************Explication des Fichiers**************************************
1. index.php
Page d'accueil gérant l'authentification et la déconnexion de l'utilisateur.
2. seance.php
Page de gestion des séances, permettant d'ajouter ou de supprimer des séances.
3. addcalcul.php
Script pour ajouter les calculs dans la base de données et récupérer l'historique des calculs.
4. fonction.php
Contient les fonctions utilitaires comme `query_requete` pour les requêtes SQL.
5. script.js
Gère les calculs côté client, les appels AJAX et les interactions avec l'utilisateur.
6. style.css
Définit le style et la mise en page de l'application.

**************************************Logiques et Algorithmes**************************************
1. Logique d'authentification : Utilise les sessions PHP pour suivre l'état de connexion.
2. Logique de calcul : Fonction de calcul côté client pour exécuter les opérations et afficher les résultats.
3. Logique d'ajout et d'historique : Sauvegarde des calculs dans SQLite et récupération pour l'historique

**************************************Schéma de la Base de Données**************************************
La base de données SQLite contient les tables suivantes :
1. users : Gère les utilisateurs enregistrés (id, pseudo, password).
2. seances : Gère les séances créées par les utilisateurs (id, nom, users_id).
3. resultats : Stocke chaque calcul (id, operation, result, date, seances_id).

**************************************Instructions d'installation**************************************
1. Installer WAMP/XAMPP : Téléchargez et installez un serveur local (WAMP ou XAMPP).
2. Cloner ou copier l'application dans le dossier `www` ou `htdocs`.
3. Créer la base de données SQLite dans le dossier spécifié.
4. Accéder à l'application via `http://localhost/calculatrice2.0-main/index.php
