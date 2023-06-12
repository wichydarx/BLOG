# Mini Blog

## Objectif
Revoir les bases de la programmation en PHP et MySQL.

### Instructions

1. Faire la page d'accueil du blog avec un menu et un pied de page. Le menu doit contenir les liens vers les pages suivantes :
    - Accueil
    - Articles
    - Inscription
    - Connexion
    - Profil

2. Faire la page d'inscription avec un formulaire contenant les champs suivants :
    - Nom
    - Prénom
    - Email
    - Mot de passe
    - Confirmation du mot de passe

3. Faire la page de connexion avec un formulaire contenant les champs suivants :
    - Email
    - Mot de passe

4. Création d'une bdd nommé `blog_php` et d'une table nommé `users` avec les champs suivants :
    - `id_user` PRIMARY KEY AUTO_INCREMENT
    - `nom` VARCHAR(255)
    - `prenom` VARCHAR(255)
    - `email` VARCHAR(255)
    - `password` VARCHAR(255)

    `CREATE TABLE `blog_php`.`users` (`id_user` INT NOT NULL AUTO_INCREMENT , `nom` VARCHAR(255) NOT NULL , `prenom` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id_user`)) ENGINE = InnoDB;`

5. Créer un fichier `config.php` qui va contenir les informations de connexion à la base de données.

6. Créer un fichier `functions.php` qui va contenir les fonctions du site.

7. Créer un fichier `init.php` qui va inclure les fichiers `config.php` et `functions.php` et qui va démarrer la session.

8. Créer un fichier `inscription.php` qui va contenir le code HTML du formulaire d'inscription et faire le traitement du formulaire afin d'insérer les données dans la table `users`. Utiliser la fonction `password_hash()` pour hasher le mot de passe.

9. Créer un fichier `connexion.php` qui va contenir le code HTML du formulaire de connexion et faire le traitement du formulaire afin de vérifier si l'utilisateur existe dans la table `users` et si le mot de passe est correct. Utiliser la fonction `password_verify()` pour vérifier le mot de passe.

10. Créer un fichier `profil.php` qui va afficher les informations de l'utilisateur connecté.Faites en sorte que l'utilisateur ne puisse pas accéder à cette page s'il n'est pas connecté.

11. Créer un bouton de déconnexion sur la page `profil.php` qui va détruire la session et rediriger l'utilisateur vers la page d'accueil.

12. Créer un bouton `Ajout article` sur la page `profil.php` qui va rediriger l'utilisateur vers la page `ajout_article.php`. Faites en sorte que l'utilisateur ne puisse pas accéder à cette page s'il n'est pas connecté.

13. Créer une table  `article` avec les champs suivants :
    - `id_article` PRIMARY KEY AUTO_INCREMENT
    - `titre` VARCHAR(255)
    - `catégorie` VARCHAR(100)
    - `contenu` TEXT
    - `image` VARCHAR(255)
    - `date` DATETIME
    - `id_user` INT NOT NULL

    `CREATE TABLE `blog_php`.`article` ( `id_article` INT NOT NULL AUTO_INCREMENT , `titre` VARCHAR(255) NOT NULL , `categorie` VARCHAR(100) NOT NULL , `contenu` TEXT NOT NULL , `image` VARCHAR(255) NOT NULL , `date` DATETIME NOT NULL , `id_user` INT NOT NULL , PRIMARY KEY (`id_article`)) ENGINE = InnoDB;`

14. Faire tout le code HTML et PHP de la page `ajout_article.php` qui va permettre à l'utilisateur de créer un article. N'oubliez pas de faire le traitement du formulaire avant d'insérer les données dans la table `article`. (Tous les champs sont obligatoires etc...)

15. Afficher dans des card tous les articles(titre, image, date(au format français), catégorie et auteur)  par ordre décroissant de date sur la page d'accueil avec un bouton `Lire la suite` qui va rediriger l'utilisateur vers la page `detail_article.php` qui va afficher l'article en entier.


16. Sur la page `detail_article.php`, afficher l'article en entier avec un bouton `Retour` qui va rediriger l'utilisateur vers la page d'accueil.


17. Dans le profil de l'utilisateur, afficher tous les articles de l'utilisateur connecté avec la possibilité de modifier ou supprimer un article.

18. Gérer le menu de navigation en fonction de l'état de connexion de l'utilisateur. Si l'utilisateur est connecté, afficher les liens suivants :
    - Accueil
    - Articles
    - Profil
    - Déconnexion

    Si l'utilisateur n'est pas connecté, afficher les liens suivants :
    - Accueil
    - Articles
    - Inscription
    - Connexion

19. Faire en sorte que l'utilisateur ne puisse pas accéder aux pages `inscription.php`, `connexion.php` et `ajout_article.php` s'il est déjà connecté.



# BONUS POUR ALLER PLUS LOIN

1. En utilisant un token CSRF, faites en sorte de vérifier que le formulaire d'ajout d'article provient bien de l'utilisateur et non d'un bot. Vous pouvez utiliser la fonction `uniqid()` pour générer un token unique ou utiliser la fonction `bin2hex(random_bytes(32))` pour générer un token aléatoire.

2. Sur la page `detail_article.php`, Si l'article appartient à l'utilisateur connecté, afficher un bouton `Modifier` et `Supprimer` sur l'article. Sinon afficher un bouton `Retour` qui va rediriger l'utilisateur vers la page `index.php` qui va afficher l'article en entier.

3. Faites en sorte de donner la possibilité à l'utilisateur de modifier son profil (nom, prénom, email et mot de passe).

4. Faites en sorte de déconnecter automatiquement l'utilisateur au bout de 10 minutes d'inactivité. Pour cela, vous pouvez utiliser la fonction `time()` qui va retourner le timestamp actuel et le stocker dans une variable de session. Ensuite, à chaque fois que l'utilisateur va charger une page, vous allez comparer le timestamp actuel avec celui stocké dans la variable de session. Si la différence est supérieure à 10 minutes, vous détruisez la session et redirigez l'utilisateur vers la page d'accueil. Vous pouvez utiliser la fonction `header()` pour rediriger l'utilisateur. Vous pouvez aussi utiliser javascript pour voir si l'utilisateur est inactif depuis 10 minutes et le déconnecter automatiquement, en vérifiant s'il a cliqué sur un bouton ou s'il a scrollé la page ou s'il a tapé sur une touche du clavier.Voici un exemple en javascript :
