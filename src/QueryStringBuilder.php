<?php
declare(strict_types = 1);

namespace mepihindeveloper\components\query;

use mepihindeveloper\components\query\exceptions\QueryStringNotFoundException;
use mepihindeveloper\components\query\param\exceptions\ParamDataException;
use mepihindeveloper\components\query\param\interfaces\ParamInterface;
use mepihindeveloper\components\query\param\ParamBuilder;

/**
 * Класс QueryStringBuilder
 *
 * @package mepihindeveloper\components\query
 */
class QueryStringBuilder extends QueryStringAbstract {

    /** @var string Класс объекта QueryString. Реализуется через Object::class */
    protected string $queryString;

    /**
     * QueryStringBuilder конструктор.
     *
     * @param string $queryString Класс объекта QueryString. Реализуется через Object::class
     */
    public function __construct(string $queryString = QueryString::class) {
        $this->queryString = $queryString;
    }

    /**
     * Устанавливает параметр
     *
     * @param ParamInterface $param Объект параметра
     *
     * @return $this
     */
    public function setParam(ParamInterface $param): self {
        $this->params[$param->getName()] = $param;

        return $this;
    }

    /**
     * Устанавливает параметры
     *
     * @param ParamInterface[] $params Массив объектов параметров
     *
     * @return $this
     */
    public function setParams(array $params): self {
        foreach ($params as $param) {
            $this->params[$param->getName()] = $param;
        }

        return $this;
    }

    /**
     * Устанавливает параметры и фрагмент из переданной строки
     *
     * @param string $uri URI
     *
     * @return QueryStringBuilder
     * @throws QueryStringNotFoundException|ParamDataException
     */
    public function setQueryDataByUri(string $uri): self {
        $uriParts = parse_url($uri);

        if ((array_key_exists('query', $uriParts) === false) || empty($uriParts['query'])) {
            throw new QueryStringNotFoundException("Ошибка формирования строки запроса: не найден обязательный параметр query в $uri");
        }

        parse_str($uriParts['query'], $params);

        foreach ($params as $name => $value) {
            $param = (new ParamBuilder)->setName($name)->setValue($value)->build();
            $this->params[$param->getName()] = $param;
        }

        if (array_key_exists('fragment', $uriParts)) {
            $this->fragment = $uriParts['fragment'];
        }

        return $this;
    }

    /**
     * Устанавливает фрагмент запроса
     *
     * @param string $fragment Фрагмент
     *
     * @return $this
     * @link https://www.ietf.org/rfc/rfc3986.txt
     *
     */
    public function setFragment(string $fragment): self {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * Формирует объект QueryString. Может быть изменен в конструкторе класса
     *
     * @return QueryString
     */
    public function build(): QueryString {
        return new $this->queryString($this);
    }
}