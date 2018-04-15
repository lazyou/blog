## Laravel 5.4: Specified key was too long error
* https://laravel-news.com/laravel-5-4-key-too-long-error

* Laravel 5.4 made a change to the default database character set, and it’s now `utf8mb4` which includes support for storing emojis. This only affects new applications and as long as you are running MySQL v5.7.7 and higher you do not need to do anything.

* For those running MariaDB or older versions of MySQL you may hit this error when trying to run migrations:
    > [Illuminate\Database\QueryException]
    > SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table users add unique users_email_unique(email))
    > [PDOException]
    > SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes

* As outlined in the Migrations guide to fix this all you have to do is edit your `AppServiceProvider.php` file and inside the boot method set a default string length:
```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```
