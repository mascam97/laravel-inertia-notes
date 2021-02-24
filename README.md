# Laravel8 Inertia Notes ![Status](https://img.shields.io/badge/status-in_progress-yellow) ![Passing](https://img.shields.io/badge/build-passing-green) ![Docker build](https://img.shields.io/badge/docker_build-passing-green)  ![Tests](https://img.shields.io/badge/tests-100%25-green)

_System with authentication to manage your notes._

### Project goal by martin-stepwolf :goal_net:

Personal project to learn [Tailwindcss](https://tailwindcss.com/) and [Laravel 8](https://laravel.com/docs/8.x) and its new features like [Laravel Sail](https://laravel.com/docs/8.x/sail) and [Jetstream with Inertia + Vue](https://jetstream.laravel.com/2.x/introduction.html). 

### Achievements :star2:

- Install all the package from Jetstream and Sail.
- Learn better practices with Docker compose.
- Learn Inertia to work with a Single Page Application.
- Create a basic CRUD, each user manages its data.
- Create a Middleware to allow request about notes just from its owner.
- Tested with PHPUnit (**Test-Driven Development**) to Models, CRUD implemented and Middleware.

---

## Getting Started :rocket:

These instructions will get you a copy of the project up and running on your local machine.

### Prerequisites :clipboard:

The programs you need are:

-   [Docker](https://www.docker.com/get-started).
-   [Docker compose](https://docs.docker.com/compose/install/).

### Installing 🔧

First duplicate the file .env.example as .env.

```
cp .env.example .env
```

Then install the PHP dependencies:

```
 docker run --rm --interactive --tty \
 --volume $PWD:/app \
 composer install
```

Then create the next alias to run docker commands with Laravel Sail.

```
alias sail='bash vendor/bin/sail'
```

Note: Setting this alias as permanent is recommended.

Create the images and run the services (laravel app, mysql, redis and mailhog):

```
sail up
```

With Laravel Sail you can run commands as docker-compose (docker-compose up -d = sail up -d) and php(e.g php artisan migrate = sail artisan migrate). To run Composer, Artisan, and Node / NPM commands just add sail at the beginning (e.g sail npm install). More information [here](https://laravel.com/docs/8.x/sail).

Then install javascript dependencies.

```
sail npm install
```

Then generate symbolic link to storage files.

```
sail artisan storage:link
```

Then generate the application key.

```
sail artisan key:generate
```

Finally generate the database with fake data:

```
sail artisan migrate --seed
```

Note: You could refresh the database any time with `migrate:refresh`.

---

## Running the project :computer:

### Javascript and CSS files

Each time SASS and JavaScript files are updated you need to run:

```
sail npm run dev
```

To make it automated run:

```
sail npm run watch
```

And now you have all the environment in the port 80 (e.g http://127.0.0.1:80/).

---

### Backend testing

There are some unit testing in Models and some feature testings in controllers, all these test guarantee functionalities from Jetstream, authorization and actions as create, read, update and delete notes. 

```
sail artisan test
```

---

## Deployment 📦

For production environment you need extra configurations for optimization and security as:

Generate optimized JavaScript files.

```
sail npm run production
```

Set in the file .env the next configuration.

```
APP_ENV=production
APP_DEBUG=false
```

---

### Built With 🛠️

-   [Laravel 8](https://laravel.com/docs/8.x/releases/) - PHP framework.
-   [Laravel Jetstream](https://jetstream.laravel.com/2.x/introduction.html) - Started kit.
-   [Vue 2](https://vuejs.org/) - JavaScript framework.
-   [Tailwindcss](https://tailwindcss.com/) - CSS framework.

### Authors

-   Martín Campos [martin-stepwolf](https://github.com/martin-stepwolf)

### Contributing

You're free to contribute to this project by submitting [issues](https://github.com/martin-stepwolf/laravel8-inertia-notes/issues) and/or [pull requests](https://github.com/martin-stepwolf/laravel8-inertia-notes/pulls).

### License

This project is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).

### References :books:

- [Test Driven Development with Laravel Course](https://platzi.com/clases/laravel-tdd/)
- [Testing with PHP and Laravel Basic Course](https://platzi.com/clases/laravel-testing/)
- [Single Page Applications in Laravel with Inertia and Vue.js Course](https://platzi.com/clases/laravel-spa/)
