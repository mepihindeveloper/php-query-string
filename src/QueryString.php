<?php
declare(strict_types = 1);

namespace mepihindeveloper\components\query;

use mepihindeveloper\components\query\exceptions\QueryStringNotFoundException;
use mepihindeveloper\components\query\interfaces\QueryStringInterface;

/**
 * Класс QueryString
 *
 * @package mepihindeveloper\components\query
 */
class QueryString extends QueryStringAbstract implements QueryStringInterface {

    /**
     * QueryString конструктор.
     *
     * @param QueryStringBuilder $queryStringBuilder Объект строителя строки запроса
     */
    public function __construct(QueryStringBuilder $queryStringBuilder) {
        $this->params = $queryStringBuilder->params;
        $this->fragment = $queryStringBuilder->fragment;
    }

    /**
     * @inheritDoc
     */
    public function get(?string $key = null) {
        if ($key === null) {
            return $this->params;
        }

        if (!array_key_exists($key, $this->params)) {
            throw new QueryStringNotFoundException("Ошибка получения параметра: параметра $key не существует.");
        }

        return $this->params[$key];
    }

    /**
     * @inheritDoc
     */
    public function getFragment(): ?string {
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function toString(): string {
        $params = [];

        foreach ($this->params as $param) {
            $params = array_merge($params, [$param->getName() => $param->getValue()]);
        }

        $fragment = ($this->fragment === null) ? '' : "#$this->fragment";

        return http_build_query($params) . $fragment;
    }
}