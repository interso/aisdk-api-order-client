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


#### Список заказов
``` php
$orders = $client->getOrders();
```
или 
``` php
$orders = $client->getOrders($page=3);
```

Возвращает массив заявок. По умолчанию 1 страницу.
Каждая заявка является ассоциативным массив с ключами.

id - Идентификатор заявки

engine_type - Тип двигателя
* none - Нет
* ice - Бензин
* diesel - Дизель
* pressure_gas - Сжатый газ
* liquefied_gas - Сжиженный газ
    
run - Пробег (в км)

tires - Используемая марка шин

axle_count - Кол-во осей у транспортного средства

vin - VIN номер транспортного средства

reg_number - Регистрационный номер

vehicle_str - Название модели

vehicle_type - Категория транспортного средства

    A, B, C, D, E

vehicle_type2 - Классификация транспортного средства

    L, M1, M2, M3, N1, N2, N3, O1, O2, O3, O4

max_weight - Максимально разрешенная масса (кг)

weight - Масса транспортного средства без нагрузки (кг)

prod_year - Год выпуска

document_type - Тип документов на транспортное средство
* pts - ПТС
* license - Свидетельство
     
document_serial - Серия документа

document_number - Номер документа

document_dt - Дата выдачи документа

document_owner - Кем выдан документ

notes - Примечание к заявке от агента

dt_add - Дата добавления заявки

dt_update - Дата обновления заявки

body_number - Номер кузова

chassis_number - Номер шасси

vehicle_goal - Назначение транспортного средства
* taxi - Такси
* personal - Личная
* none - Нет отметок
* learn - Для учебной езды
* route - Для маршрутных перевозок
* danger - Для опасных грузов
    
brake_system - Тип тормозной системы
* hydra - Гидравлические
* pneu - Пневматические
* mechanical - Механические
* combined - Комбинированные

owner_fname - Имя предоставившего сведения о ТС

owner_lname - Фамилия предоставившего сведения о ТС

owner_mname - Отчество предоставившего сведения о ТС
 
organization - Организация владеющая данным ТС


#### Информация об одном заказе
``` php
$order = $client->getOrder(1234)
```
Возвращает данные одной заявки. Формат аналогичен указанному в методе getOrders.


#### Информация о диагностической карте одного заказа
``` php
$dcard = $client->getDcardForOrder(1234);
```

Возвращает найденную для заявки диагностическую карту в виде ассоциативного массива со следуюшими полями:

order_id - идентификатор заявки

expiration_date - дата до которой выдана диагностическая карта

start_date - дата с которой диагностическая карта выдана

number - номер в ЕАИСТО

url - URL для доступа к PDF файлу с диагностической картой


#### Мета информация об одном заказе
``` php
$meta = $client->getMetaForOrder(1234);
```

Возвращает найденную для заявки мета информацию со следующими полями:

order_id - идентификатор заявки

status - статус заявки
* new - новая
* proceed - в процессе
* complete - завершена
* canceled - отменена
* error - ошибка

station_id - идентификатор станции

station - название станции

