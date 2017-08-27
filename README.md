# aisdk-api-order-client

Aisdk API клиент для заявок
=================

PHP библиотека для работы с сервисом aisdk с помощью REST API


## Установка

Установка через [composer](https://getcomposer.org/):

```sh
composer require interso/aisdk-api-order-client
```

## Использование

``` php
$client = new \Aisdk\Client('http://127.0.0.1:8090/api',new \GuzzleHttp\Client());
$client->auth('login', 'password');
```

или

``` php
$client = new \Aisdk\Client('http://127.0.0.1:8090/api',new \GuzzleHttp\Client(), ['token'=>'w340349if903f0weifjqewoifjewo']);
```


### Методы для клиента

``` php
$orders = $client->getOrders();
```

