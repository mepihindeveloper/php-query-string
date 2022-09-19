<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\query;

use mepihindeveloper\components\query\param\Param;

/**
 * Класс QueryStringAbstract
 *
 * @package mepihindeveloper\components\query
 */
abstract class QueryStringAbstract {

    /** @var Param[] Массив параметров */
    protected array $params = [];
    /** @var string|null Фрагмент сроки запроса */
    protected ?string $fragment = null;
}