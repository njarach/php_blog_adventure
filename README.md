[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e29ac202133f418c829322101055a3fa)](https://app.codacy.com/gh/njarach/php_blog_adventure/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)
# PHP BLOG

## Description

Ce projet a été réalisé dans le cadre du projet n°5 de la formation Concepteur/Développeur d'application PHP Symfony : _Créez votre premier blog en php_. Il a été réalisé _from scratch_ et ne comprend que des librairies disponibles via composer, et Bootstrap 5.3 + Icons pour les éléments frontend.
Le projet est un blog réalisé entièrement avec PHP / HTML / CSS (avec Twig templating language). Le propriétaire (administrateur du site) peut publier des articles, les modifier et les supprimer. Un utilisateur peut créer un compte et se connecter. 
Une fois connecté, il peut publier des commentaires sous les articles. Ces commentaires ne sont visibles qu'après révision de l'administrateur.

## Fonctionnalités

- Liste des articles : les utilisateurs peuvent voir les articles et les consulter
- Gestion des articles: un administrateur peut créer les articles, les éditer et les supprimer.
- Gestion des commentaires: un utilisateur connecté peut publier des commentaires sous les différents articles. Ils seront visibles par les autres utilisateurs du site lorsqu'un administrateur aura validé le commentaire.
- Contacter le propriétaire du blog: un formulaire de contact permet à n'importe qui de contacter le propriétaire du blog pour tous types de demande.
- Inscription et connexion : les utilisateurs peuvent s'enregistrer et se connecter. Un administrateur se connecte à son compte 'admin' et dispose de fonctionnalités supplémentaires.
- Télécharger le CV du propriétaire : un bouton permet à l'utilisateur de télécharger le CV inclus dans les fichiers du projet.

## Prérequis

Avant d'installer ce projet, vérifier les prérequis suivants:

- PHP version 8.2 ou supérieur, 
- Composer.

## Installation

Pour installer le projet, cloner le dans le répertoire de votre choix avec :
```bash
  git clone https://github.com/yourusername/yourprojectname.git
````

Puis, si vous utilisez Composer, lancer : 
```bash
  composer install
````

Le projet nécessite une base de données pour fonctionner. Commencer par importer le fichier import.sql dans la base de données. 

1. Mettre à jour le fichier config/DatabaseConnection, en renseignant le nom de la base de données, vos identifiants et mot de passe : 
````bash
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'php_blog_adventure');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
````
2. Mettre à jour le fichier src/Service/MailerSetup pour mettre en place l'envoi de mail. La version par défaut utilise Mailtrap, mais vous devez renseigner vos identifiants, protocole SMTP et identifiants pour effectivement permettre l'envoi de mail (formulaire de contact) :
````bash
  $mail->Host       = 'sandbox.smtp.mailtrap.io';
  $mail->SMTPAuth   = true;
  $mail->Username   = '97032ba77b7dc6';
  $mail->Password   = $password;
````

Les identifiants par défaut sont : identifiant : admin@mail.com  - mot de passe : adminpwd

## Contributions et futur du projet
- Le projet ne permet pas encore la gestion (création, suppression, changement de rôle, etc) des utilisateurs du site par l'administrateur.
- Un administrateur ne peut pas refuser et/ou supprimer un commentaire via l'interface.
- Le projet ne permet pas encore de modifier l'identité du propriétaire sans nécessite de modifier les fichiers source.
- Aucune solution de création de contenu n'est implémentée (markdown avec Twig).
- Aucune librairie ou solution pour utiliser un fichier .env et éviter l'utilisation de 'define' avec des infos sensibles dans la codebase.

---

# Contexte

Ça y est, vous avez sauté le pas ! Le monde du développement web avec PHP est à portée de main et vous avez besoin de visibilité pour pouvoir convaincre vos futurs employeurs/clients en un seul regard. Vous êtes développeur PHP, il est donc temps de montrer vos talents au travers d’un blog à vos couleurs.
Description du besoin

Le projet est donc de développer votre blog professionnel. Ce site web se décompose en deux grands groupes de pages :

    les pages utiles à tous les visiteurs ;
    les pages permettant d’administrer votre blog.

Voici la liste des pages qui devront être accessibles depuis votre site web :

    la page d'accueil ;
    la page listant l’ensemble des blog posts ;
    la page affichant un blog post ;
    la page permettant d’ajouter un blog post ;
    la page permettant de modifier un blog post ;
    les pages permettant de modifier/supprimer un blog post ;
    les pages de connexion/enregistrement des utilisateurs.

Vous développerez une partie administration qui devra être accessible uniquement aux utilisateurs inscrits et validés.

Les pages d’administration seront donc accessibles sur conditions et vous veillerez à la sécurité de la partie administration.

Commençons par les pages utiles à tous les internautes.

Sur la page d’accueil, il faudra présenter les informations suivantes :

    votre nom et votre prénom ;
    une photo et/ou un logo ;
    une phrase d’accroche qui vous ressemble (exemple : “Martin Durand, le développeur qu’il vous faut !”) ;
    un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
    un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
        nom/prénom,
        e-mail de contact,
        message,
    un lien vers votre CV au format PDF ;
    et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).

Sur la page listant tous les blogs posts (du plus récent au plus ancien), il faut afficher les informations suivantes pour chaque blog post :

    le titre ;
    la date de dernière modification ;
    le chapô ;
    et un lien vers le blog post.

Sur la page présentant le détail d’un blog post, il faut afficher les informations suivantes :

    le titre ;
    le chapô ;
    le contenu ;
    l’auteur ;
    la date de dernière mise à jour ;
    le formulaire permettant d’ajouter un commentaire (soumis pour validation) ;
    les listes des commentaires validés et publiés.

Sur la page permettant de modifier un blog post, l’utilisateur a la possibilité de modifier les champs titre, chapô, auteur et contenu.

Dans le footer menu, il doit figurer un lien pour accéder à l’administration du blog.
