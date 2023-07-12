<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Movie Quotes Updated Version</h1>
</div>

---

In this updated version of Movie Quotes, you can view thousands of different user-uploaded quotes and comment or like them. Many features have been added; you can like someone's quote or a comment, add your own movie and quote, and more. You have your own profile where you can update your data.

#

### Table of Contents

-   [Prerequisites](#prerequisites)
-   [Tech Stack](#tech-stack)
-   [Getting Started](#getting-started)
-   [Migrations](#migration)
-   [Development](#development)
-   [Resources](#resources)

#

### Prerequisites

-   <img src="https://raw.githubusercontent.com/RedberryInternship/example-project-laravel/7a054d64192f92566a0f48349002e0296a9d5347/readme/assets/php.svg" width="35" style="position: relative; top: 4px" /> *PHP@8.2 and up*
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/mysql.png?raw=true" width="35" style="position: relative; top: 4px" /> _MYSQL@8 and up_
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/npm.png?raw=true" width="35" style="position: relative; top: 4px" /> *npm@9.5 and up*
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/composer.png?raw=true" width="35" style="position: relative; top: 6px" /> *composer@2.4 and up*

#

### Tech Stack

-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/laravel.png?raw=true" height="18" style="position: relative; top: 4px" /> [Laravel@9.x](https://laravel.com/docs/9.x) - back-end framework
-   <img src="https://github.com/RedberryInternship/example-project-laravel/blob/master/readme/assets/spatie.png?raw=true" height="19" style="position: relative; top: 4px" /> [Spatie Translatable](https://github.com/spatie/laravel-translatable) - package for translation
-   <img src="https://miro.medium.com/max/632/1*5QD8DKhOjRe-gcYjozlLNQ.png" height="19" style="position: relative; top: 4px" /> [Tailwind CSS](https://tailwindcss.com) - CSS library
-   [Sanctum](https://pusher.com) - Laravel sanctum authentication system
-   [Pusher](https://pusher.com) - Real time notification package

#

### Getting Started

1\. First of all you need to clone repository from github:

```sh
git clone https://github.com/RedberryInternship/giorgi-surmanidze-movie-quotes-back.git
```

2\. Install dependencies by running:

```sh
composer install
npm install
```

5\. Now we need to set our env file. Go to the root of your project and execute this command.

```sh
cp .env.example .env
```

6\. Next generate Laravel key:

```sh
php artisan key:generate
```

7\. link storage folder to public folder:

```sh
php artisan storage:link
```

And now you should provide **.env** file all the necessary environment variables:

#

**MYSQL:**

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***

#

**Pusher:**

> ROADCAST_DRIVER=pusher

> CACHE_DRIVER=file

> FILESYSTEM_DISK=public

> QUEUE_CONNECTION=sync

> SESSION_DRIVER=file

> SESSION_LIFETIME=120

> PUSHER_APP_ID=**\***

> PUSHER_APP_KEY=**\***

> PUSHER_APP_SECRET=**\***

> PUSHER_PORT=443

> PUSHER_SCHEME=https

> PUSHER_APP_CLUSTER=**\***

#

**Laravel sanctum:**

> SANCTUM_STATEFUL_DOMAINS=**\***

> SESSION_DOMAIN=localhost

#

**App urls:**

> FRONT_BASE_URL=**\***

#

**Mailable:**

> MAIL_MAILER=**\***

> MAIL_HOST=**\***

> MAIL_PORT=465

> MAIL_USERNAME=**\***

> MAIL_PASSWORD=**\***

> MAIL_ENCRYPTION=**\***

> MAIL_FROM_ADDRESS=**\***

> MAIL_FROM_NAME="${APP_NAME}"

##### Now, you should be good to go!

#

### Migration

if you've completed getting started section, then migrating database if fairly simple process, just execute:

```sh
php artisan migrate
```

#

### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

#

### Resources

Database structure in DrawSQL:
<a href="https://drawsql.app/teams/redberry-35/diagrams/movie-quotes-epic">
https://drawsql.app/teams/redberry-35/diagrams/movie-quotes-epic
</a>

<img src="https://i.postimg.cc/5ycvDRzf/draw-SQL-movie-quotes-epic-export-2023-07-07.png"  />
