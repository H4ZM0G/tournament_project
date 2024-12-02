# Template de base pour Projet CodeIgniter 4 (Back-Office - COREUI)

![image](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
)
![image](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![image](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white
)
![image](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![image](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)
![image](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white) ![image](http://img.shields.io/badge/-PHPStorm-181717?style=for-the-badge&logo=phpstorm&logoColor=white)
![image](https://img.shields.io/badge/Codeigniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![image](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=Composer&logoColor=white)

## Informations
Ceci est un projet fait sous [CodeIgniter 4](https://www.codeigniter.com/user_guide/index.html).
Il contient des classes et un thème gratuit fait avec [CoreUi for Bootstrap](https://coreui.io/bootstrap/).

Framework CSS : [Boostrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/).

Bibliothèque d'icones : [FontAwesome](https://fontawesome.com/search?m=free&o=r).

Bibliothèque JavaScript :

* [ChartJS](https://www.chartjs.org/docs/latest/)
* [jQuery](https://api.jquery.com/)
* [Toastr](https://codeseven.github.io/toastr/)
* [Tinymce](https://www.tiny.cloud/docs/tinymce/latest/)
* [Datatable](https://datatables.net/manual/)
* [SweetAlert2](https://sweetalert2.github.io/#examples)


## Création de votre projet

1. Créer sur GitHub.com dans vos répertoires privés un repo pour votre projet.
2. Utiliser ce repo comme template de projet.

### Initialiser le projet

Ouvrez votre projet avec phpstorm.

1. Changer le nom de la BDD dans le fichier docker-compose.yml (ligne 6)
2. Changer le nom de la BDD dans app/Config/Database.

Ouvrez un terminal (`Alt + F12`).

Puis utiliser la commande suivante :
```
composer install
```
(vous pouvez utiliser ```composer update ```aussi)

Vérifier que votre Docker Desktop est bien lancé ensuite : 
```
docker-compose up -d
```
Vérifier maintenant que vos 2 container sur Docker Desktop soit bien lancé aussi puis :

```
php spark migrate
```
Ensuite vous pouvez vérifier le bon fonctionnement à l'aide de la commande suivante :
```
php spark serve
```
Qui va créer un serveur de développement local à l'adresse http://localhost:8080 (attention ce n'est pas
https ! )

Vous pouvez vous connecter avec le login et le mdp suivant : ```admin@admin.fr / admin```


Vous avez aussi un accés à un phpmyadmin  de développement local à l'adresse http://localhost:8081 (attention ce
n'est pas https ! ).

Si le phpmyadmin ne fonctionne pas il faut verifier que docker est bien lancé et vos container
aussi.

Pour vous connecter au phpmyadmin il faut utiliser ```root / root```

**_Le projet inclus l'upload d'images, mais attention il faudra faire une migration d'alter table pour ajouter des ENUM 
dans la table media. Dans l'état il n'accepte que les avatars des utilisateurs._**