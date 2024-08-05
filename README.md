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
DB_CONNECTION=mysql
DB_DATABASE=your_test_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run the migration to setup test environment:

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
php artisan test --filter="UserControllerTest::testAddDeviceToken"
```

## TESTING GUIDE

## INSTALLED PACKAGES

To test your application, ensure your environment is properly setup. Example update (`.env.testing`)

```bash
php artisan queue:work
```


### Swagger UI
> https://github.com/hussein4alaa/laravel-g4t-swagger-auto-generate
> https://www.youtube.com/watch?v=bI1BY9tAwOw

### CODE SNIPPETS
> https://www.twilio.com/en-us/blog/queueing-in-laravel
> https://laraveldaily.com/tip/force-json-response-for-api-requests