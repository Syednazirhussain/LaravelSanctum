## SETUP GUIDE

Install project dependencies:

```bash
composer install
```

To setup database, update (`.env`) file with your database credentials and run the below command:

```bash
php artisan migrate
```

To feed some sample data into your database table then run the below command:

```bash
php artisan db:seed
```

To process queueable events, run the below command:

```bash
php artisan queue:work
```

## TESTING GUIDE

To test your application, ensure your environment is properly setup. For example update (`.env.testing`)

```bash
DB_CONNECTION=mysql
DB_DATABASE=your_test_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run the migration to setup test database:

```bash
php artisan migrate --env=testing
```

Run all the test cases:

```bash
php artisan test
```

Run specific test file:

```bash
php artisan test --filter=UserControllerTest
```

Run specific test method:

```bash
php artisan test --filter="UserControllerTest::it_fetches_the_authenticated_user_profile"
```

## SETUP CRON JOB

To setup cron on ubuntu server, run (`crontab -e`). Add the below command at the end of file.

```bash
* * * * * cd /var/www/html/LaravelSanctum && php artisan schedule:run >> /var/log/cron.log 2>&1
```

To check the cron status

```bash
sudo systemctl status cron
```

To run the cron job

```bash
sudo systemctl start cron
```

## SUPERVISOR

To Check Supervisor

```bash
sudo systemctl stop supervisor
sudo systemctl start supervisor
sudo systemctl status supervisor
```

To view supervisor conf.d file. Open (`/etc/supervisor/conf.d`)

Reload Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
```

To Start Laravel Queue

```bash
sudo supervisorctl start "laravel-worker:*"
```

## INSTALLED PACKAGES

### Swagger UI
> https://github.com/hussein4alaa/laravel-g4t-swagger-auto-generate
> https://www.youtube.com/watch?v=bI1BY9tAwOw

### CODE SNIPPETS
> https://www.twilio.com/en-us/blog/queueing-in-laravel
> https://laraveldaily.com/tip/force-json-response-for-api-requests