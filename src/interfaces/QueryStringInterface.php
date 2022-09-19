<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\query\interfaces;

use mepihindeveloper\components\query\exceptions\QueryStringNotFoundException;
use mepihindeveloper\components\query\param\Param;
use mepihindeveloper\components\query\param\ParamBuilder;

/**
 * Класс QueryStringInterface
 *
 * Интерфейс описывает обязательные методы реализации
 *
 * @package mepihindeveloper\components\query
 */
interface QueryStringInterface {

    /**
     * Получает параметр(ы). Если ключ не задан, то получает все параметры
     *
     * @param string|null $key Ключ (название) параметра
     *
     * @return Param|Param[] Возвращает объект или массив объектов класса Param.
     * Param класс возвращается по умолчанию, но, можно реализовать свой класс,
     * наследующийся от Param
     *
     * @throws QueryStringNotFoundException
     * @see ParamBuilder
     *
     */
    public function get(?string $key = null);

    /**
     * Получает фрагмент из строки запроса.
     *
     * @link https://www.ietf.org/rfc/rfc3986.txt
     *
     * @return string|null Возвращает строку фрагмента строки запроса или NULL в случае его отсутствия.
     */
    public function getFragment(): ?string;

    /**
     * Формирует строку запроса
     *
     * @return string Возвращает строку запроса с параметрами
     */
    public function toString(): string;
}