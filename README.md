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

To recieve events then run the below command:

```bash
php artisan queue:work
```

## INSTALLED PACKAGES

### Swagger UI
> https://github.com/hussein4alaa/laravel-g4t-swagger-auto-generate
> https://www.youtube.com/watch?v=bI1BY9tAwOw

### JSON Force Response
> https://laraveldaily.com/tip/force-json-response-for-api-requests