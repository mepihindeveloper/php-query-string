# php-query-string

![release](https://img.shields.io/github/v/release/mepihindeveloper/php-query-string?label=version)
[![Packagist Version](https://img.shields.io/packagist/v/mepihindeveloper/php-query-string)](https://packagist.org/packages/mepihindeveloper/php-query-string)
[![PHP Version Require](http://poser.pugx.org/mepihindeveloper/php-query-string/require/php)](https://packagist.org/packages/mepihindeveloper/php-query-string)
![license](https://img.shields.io/github/license/mepihindeveloper/php-query-string)

![build](https://github.com/mepihindeveloper/php-query-string/actions/workflows/php.yml/badge.svg?branch=stable)
[![codecov](https://codecov.io/gh/mepihindeveloper/php-query-string/branch/stable/graph/badge.svg?token=36PP7VKHKG)](https://codecov.io/gh/mepihindeveloper/php-query-string)

Компонент для работы со строкой запроса. Основной функционал направлен на формирование строки запроса посредством реализации шаблона проектирования "Строитель". 
Строка запроса - то, что находится в URI после `?`.

# Структура

```
src/
--- exceptions/
------ QueryStringNotFoundException.php
--- interfaces/
------ QueryStringInterface.php
--- QueryString.php
--- QueryStringAbstract.php
--- QueryStringBuilder.php
```

В директории `interfaces` хранятся необходимые интерфейсы, которые необходимо имплементировать в при реализации 
собственного класса `QueryString`. Класс `QueryString` выступает в качестве объекта строки запроса. 
В директории `exceptions` хранятся необходимые исключения. Исключение `QueryStringNotFoundException` необходимо
для идентификации ошибки отсутствия необходимых ключей.

Класс `QueryString` реализует саму строку запроса. Собственные классы параметры должны наследоваться от класса `QueryString`.

Класс `QueryStringAbstract` реализует общую логику для всех строк запроса. В данном случае, хранит в себе необходимые свойства объектов.

Класс `QueryStringBuilder` реализует логику формирования объекта класса `QueryString`.

Примерная реализация формирования параметра:

```php
<?php

declare(strict_types = 1);

use mepihindeveloper\components\query\param\ParamBuilder;
use mepihindeveloper\components\query\QueryStringBuilder;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'vendor/autoload.php';

$uri = 'foo://example.com:8042/over/there?name=ferret&a[]=11&a[]=22#nose';
$query = (new QueryStringBuilder())->setQueryDataByUri($uri)->build();
$query2 = (new QueryStringBuilder())->setParams([
    (new ParamBuilder())->setName('name')->setValue('ferret')->build(),
    (new ParamBuilder())->setName('a')->setValue([11, 22])->build(),
])->setFragment('nose')->build();
```


# Доступные методы

## QueryStringInterface

| Метод                    | Аргументы                 | Возвращаемые данные                                                                                                                                                | Исключения                   | Описание                                                                   |
|--------------------------|---------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------|----------------------------------------------------------------------------|
| get(?string $key = null) | Ключ (название) параметра | Param\|Param[] Возвращает объект или массив объектов класса Param. Param класс возвращается по умолчанию, но, можно реализовать свой класс, наследующийся от Param | QueryStringNotFoundException | Получает параметр(ы). Если ключ не задан, то получает все параметры        |
| getFragment()            |                           | string\|null Возвращает строку фрагмента строки запроса или NULL в случае его отсутствия                                                                           |                              | Получает фрагмент из строки запроса (https://www.ietf.org/rfc/rfc3986.txt) |
| toString()               |                           | string Возвращает строку запроса с параметрами                                                                                                                     |                              | Формирует строку запроса                                                   |                                                                      |                                                   | array               |                                                   | Получает всех слушателей всех событий             |

## QueryStringBuilder

| Метод                                                 | Аргументы                                                  | Возвращаемые данные | Исключения                                       | Описание                                                               |
|-------------------------------------------------------|------------------------------------------------------------|---------------------|--------------------------------------------------|------------------------------------------------------------------------|
| __construct(string $queryString = QueryString::class, string $param = Param::class) | Класс объекта QueryString. Реализуется через Object::class. Класс объекта Param. Реализуется через Object::class |                     |                                                  |                                                                        |
| setParam(ParamInterface $param)                       | Объект параметра                                           | QueryStringBuilder  |                                                  | Устанавливает параметр                                                 |
| setParams(array $params)                              | ParamInterface[] $params Массив объектов параметров        | QueryStringBuilder  |                                                  | Устанавливает параметры массива объектов ParamInterface                                                |
| setParamsArray(array $params)                         | Массив параметров                                          | QueryStringBuilder  | QueryStringNotFoundException\|ParamDataException | Устанавливает параметры и фрагмент из переданной строки                |
| setQueryDataByUri(string $uri)                        | URI                                                        | QueryStringBuilder  | QueryStringNotFoundException\|ParamDataException | Устанавливает параметры и фрагмент из переданной строки                |
| setFragment(string $fragment)                         | Фрагмент                                                   | QueryStringBuilder  |                                                  | Устанавливает фрагмент запроса (https://www.ietf.org/rfc/rfc3986.txt)  |
| build()                                               |                                                            | QueryStringInterface         |                                                  | Формирует объект QueryString. Может быть изменен в конструкторе класса |

# Контакты

Вы можете связаться со мной в социальной сети ВКонтакте: [ВКонтакте: Максим Епихин](https://vk.com/maksimepikhin)

Если удобно писать на почту, то можете воспользоваться этим адресом: mepihindeveloper@gmail.com

Мой канал на YouTube, который посвящен разработке веб и игровых
проектов: [YouTube: Максим Епихин](https://www.youtube.com/channel/UCKusRcoHUy6T4sei-rVzCqQ)

Поддержать меня можно переводом на Яндекс.Деньги: [Денежный перевод](https://yoomoney.ru/to/410012382226565)