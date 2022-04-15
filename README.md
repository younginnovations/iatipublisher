
<h1> IATI Publisher</h1> <br/>
IATI Publisher is a free-to-use publishing tool built using Laravel framework which will provide a simplified, intuitive, robust and more efficient process for publishers to add, modify and update their IATI data.

IATI – the International Aid Transparency Initiative – brings together governments, multilateral institutions, private sector and civil society organizations and others to increase the transparency and openness of resources flowing into developing countries. To learn more about IATI, please visit the [iatistandard.org](https://iatistandard.org/).


## Prerequisite
The prerequisite for this project are:
- php>=8.0
- node: 16
- postgres: 12
- composer: 2
- nginx server

## Install
IATI Publisher can be cloned from GitHub repository and installed as follows:
- git clone https://github.com/younginnovations/iatipublisher.git<br />
  OR<br />
  git clone git@github.com:younginnovations/iatipublisher.git
- cd iatipublisher

## Run
In order to run this app follow the commands listed below:
- Install the application dependencies with commands: `composer install` and `npm install`
- Copy .env.example file to .env file and update your database configuration.
- Generate APP_KEY with command : `php artisan key:generate`
- Run migration and seed the database with command : `php artisan migrate:fresh --seed`
- Serve the application using `php artisan serve` (append --port PORT_NUMBER to run in a port other than 8000)
- Access `localhost:8000` to run application in browser(`localhost:PORT_NUMBER` if different port number is specified)


## Framework
This application is coded in PHP using [Laravel](http://laravel.com) framework. The version of Laravel used for this project is 9.0 . The application also uses [Vue 3](https://vuejs.org) (Composition API), [Typescript](https://www.typescriptlang.org) and [Tailwind](https://tailwindcss.com/). 



## Tools and packages

The packages used in this application can be seen in [composer.json](https://github.com/younginnovations/iatipublisher/blob/main/composer.json) and [package.json](https://github.com/younginnovations/iatipublisher/blob/main/package.json) file. Some of the important packages and dependencies used are:
- Sass: ^1.32.11
- Vue: ^3.0.23
- Typescript: ^4.6.3
- Tailwindcss: ^3.0.23
- Axios: ^0.25
- Husky: ^7.0.4
- Prettier: ^2.5.1
- Postcss: ^8.4.6
- Stylelint: ^14.5.1
- Autoprefixer: ^10.4.2
- Friendsofphp/php-cs-fixer: ^3.6
- Laravel/ui: ^3.4


## Structure
This application is structured in a simple way within `app\IATI` folder. The various folders and their corresponding contents are:
- Models : Contains all the eloquent model classes.
- Repositories : Contains all the classes for storage and retrieval from database.
- Services : Contains the classes which serves as a bridge between Controller and Repositories. All the application logic are handled here.

The Typescript and Vue related files are placed within `resources\assets\js` folder. The various folders and their corresponding contents are:
- components : Contains all the reusable Vue components.
- views : Contains the Vue pages and their partial components.
- scripts : Contains Typescript to manipulate DOM.
The Laravel blade file are placed within the folder present in `resources\views`. The Vue components are loaded into these blade files. 

The sass files are present within `resource\assets\sass` folder. The scss are places using 7-1 folder structure. The component specific styling are present within the script tag of the corresponding component.

These Sass, Typescript and Vue files are bundled with the help of webpack into public folder. To see the changes made into these files use the command `npm run watch`.


