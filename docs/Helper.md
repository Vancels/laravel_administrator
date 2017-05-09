### Install Helper
####composer 
- composer require qiniu/php-sdk
- composer require laravelcollective/html
###1.请在 config/app.php 里面 添加
- providers
```php
Vancels\Administrator\AdministratorServiceProvider::class,
Collective\Html\HtmlServiceProvider::class,
```
- aliases
```php
'Input'  => Illuminate\Support\Facades\Input::class,
'form'   => Collective\Html\FormFacade::class,
'html'   => Collective\Html\HtmlFacade::class,
'vTools' => \Vancels\Administrator\Facade\ToolsFacade::class,
```

###2.config/auth.php 新增 

- 'guards'
```
'admin' => [
    'driver'   => 'session',
    'provider' => 'admins',
],
 ```
- providers
 ```
'admins' => [
    'driver' => 'eloquent',
    'model'  => \Vancels\Administrator\Models\AdminUser::class,
],
```
```php
php artisan make:auth
```



###3.app/Http/Kernel.php 
$routeMiddleware中  替换
```php
'auth' => \Vancels\Administrator\Middleware\AdminMiddleware::class,
```