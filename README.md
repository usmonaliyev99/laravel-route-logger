
# laravel-route-logger

This project can write some data of request and response to log file. 




## Installation

Install my-project with [composer](https://getcomposer.org/)

```bash
composer require usmonaliyev/laravel-route-logger

```

You can control log file name, path, format by `config/laravel-router-log.php`. 
To create it in your `config` folder, you should run this command.
```bash
php artisan vendor:publish --provider="Usmonaliyev\LaravelRouteLogger\LaravelRouteLoggerServiceProvider"
```


## Usage/Examples

In my `routes/api.php` file.
```php
Route::middleware("laravel-route-logger")->get("get-foo", [FooController::class, "getFoo"]);
```

In my `config/laravel-route-logger.php` file.
```php
<?php

return [
    "path" => "../storage/logs/",
    "file" => 'laravel-route-logger.log',
    "format" => "status_message status client_ip method path_info error_message {'request':[],'response': []} execution_time auth_id user_agent now\n"
];
```

Options of format:
| Options       | Values              | Description  |
| ------------- |:-------------:|:-----|
| status_message | SUCCESS or FAIL or EXCEPTION | SUCCESS = 200 <= status > 300, EXCEPTION = staus == 500, FAIL = others |
| status | $response->getStatusCode(); | Status code of response |
| client_ip | $request->ip(); | Ip of request |
| method | $request->method(); | Method of request |
| path_info | $request->getPathInfo(); | Path of request |
| error_message | Error message of null | Message if error otherwise null |
| {'request':[],'response': []} | json | Data of request and response |
| execution_time | double | How much time did request take |
| auth_id | integer | When user is auth auth_id will auth()->id() otherwise it will null |
| user_agent | $request->userAgent(); | User agent is any software |
| now | now(); | Date time of request |


## Result

When your routes handle requests, this project creates `laravel-route-logger.log` 
file in your `storage/logs` folder.

In my `storage/logs/laravel-route-logger.log`
```
SUCCESS 200 127.0.0.1 GET /api/log null {"request":{"query_param":"data"},"response":{"message":"log"}} 0.012042999267578 null Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:105.0) Gecko/20100101 Firefox/105.0 2022-10-27 10:05:36
```
## License

[MIT](https://choosealicense.com/licenses/mit/)

