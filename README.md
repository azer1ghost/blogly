## Blog

For installing project follow all steps.

### Requirements
- PHP 8
- Node.js
- Nginx
- MySql

<br/>

### Technologies
Laravel, Php, Alpine js, Axios, Html, Css, Scss, Bootstrap 5, Webpack, Feature test, Jobs

### Installation
First download project as zip and extract go inside project folder and run commands

- <code> composer install </code>
- <code> npm install </code>
- <code> npm run prod </code>

You must create table in database
- <code> blogly</code>

Then go project folder enter terminal run commands
- <code> php -r "file_exists('.env') || copy('.env.example', '.env');" </code>

Now go .env file and configure db connection

After all run this commands
- <code> php artisan migrate</code> or with fake posts <code> php artisan migrate:fresh --seed </code>
- <code> php artisan optimize:clear </code>
- <code> php artisan schedule:work</code>

Enjoy 😊

### Testing
- <code> php artisan test</code>
