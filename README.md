# Laravel8 Inertia Notes

_System with authentication to manage your notes._

### Project goal by martin-stepwolf :goal_net:

Personal project to learn [Tailwindcss](https://tailwindcss.com/) and [Laravel 8](https://laravel.com/docs/8.x) and its new features like [Laravel Sail](https://laravel.com/docs/8.x/sail) and [Jetstream with Inertia + Vue](https://jetstream.laravel.com/2.x/introduction.html). 

### Achievements :star2:

As web developer, I knew already about Laravel 7, Vue 2 and Docker, with this project I achieved.

- Learn better practices with Docker compose.
- Learn Inertia to create a Single Page Application.
- Install all the package from Jetstream and Sail.
- Create a basic CRUD, each user manages its data.
- Create a Middleware to allow request about notes just from its owner.
- Implement testing to Models, Controller (the CRUD) and Middleware with PHPUnit.

## Getting Started :rocket:

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites :clipboard:

The programs you need are:

-   [Docker](https://www.docker.com/get-started).
-   [Docker compose](https://docs.docker.com/compose/install/).

### Installing 🔧

First duplicate the file .env.example as .env.

```
cp .env.example .env
```

Note: You could change some values, anyway docker-compose create the database according to the defined values.

Then install the PHP dependencies:

```
 docker run --rm --interactive --tty \
 --volume $PWD:/app \
 composer install
```

Then create the next alias to run commands in the container with Laravel Sail.

```
alias sail='bash vendor/bin/sail'
```

Create the images (laravel, mailhog, mysql and redis) and run the services:

```
sail up
```

With Laravel Sail you can run commands as docker-compose (docker-compose up -d = sail up -d) and php(e.g php artisan migrate = sail artisan migrate). To run Composer, Artisan, and Node / NPM commands just add sail at the beginning (e.g sail npm install). More information [here](https://laravel.com/docs/8.x/sail).

Then install the dependencies.

```
sail npm install
```

Create a symbolic link to storage images.

```
php artisan storage:link
```

Then generate the application key.

```
sail artisan key:generate
```

Finally generate the database with fake data:

```
sail artisan migrate --seed
```

Note: You could refresh the database any time with migrate:refresh.

## Running the project :computer:

Each time SASS and JavaScript files are updated you need to run:

```
sail npm run dev
```

To make it automated run:

```
sail npm run watch
```

And now you have all the environment in the port 80 (e.g http://127.0.0.1:80/).

## Running the tests

To test the backend run:

```
sail artisan test
```

## Deployment 📦

For production environment you need extra configurations for optimization and security as:

Generate optimized JavaScript files.

```
sail npm run production
```

Set in the file .env the next configuration.

```
APP_ENV=production
```

## Built With 🛠️

-   [Laravel 8](https://laravel.com/docs/8.x/releases/) - PHP framework.
-   [Vue 2](https://vuejs.org/) - JavaScript framework.
-   [Tailwindcss](https://tailwindcss.com/) - CSS framework.

## Authors

-   Martín Campos [martin-stepwolf](https://github.com/martin-stepwolf)

## Contributing

You're free to contribute to this project by submitting [issues](https://github.com/martin-stepwolf/laravel8-inertia-notes/issues) and/or [pull requests](https://github.com/martin-stepwolf/laravel8-inertia-notes/pulls).

## License

This project is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).

## References :books:

- [Test Driven Development with Laravel Course](https://platzi.com/clases/laravel-tdd/)
- [Testing with PHP and Laravel Basic Course](https://platzi.com/clases/laravel-testing/)
- [Single Page Applications in Laravel with Inertia and Vue.js Course](https://platzi.com/clases/laravel-spa/)
