<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\query\exceptions\QueryStringNotFoundException;
use mepihindeveloper\components\query\interfaces\QueryStringInterface;
use mepihindeveloper\components\query\param\ParamBuilder;
use mepihindeveloper\components\query\QueryStringBuilder;

class QueryStringTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSetParam() {
        $param = (new ParamBuilder())->setName('a')->setValue('1')->build();
        $query = (new QueryStringBuilder())->setParam($param)->build();

        static::assertNotEmpty($query->get());
        static::assertArrayHasKey('a', $query->get());
    }

    public function testSetParamWrongType() {
        $this->expectException(TypeError::class);
        $param = (new ParamBuilder())->setName('a')->setValue('1');
        $query = (new QueryStringBuilder())->setParam($param)->build();
    }

    public function testSetParams() {
        $param = (new ParamBuilder())->setName('a')->setValue('1')->build();
        $param2 = (new ParamBuilder())->setName('b')->setValue('2')->build();
        $query = (new QueryStringBuilder())->setParams([$param, $param2])->build();

        static::assertCount(2, $query->get());
        static::assertArrayHasKey('a', $query->get());
        static::assertArrayHasKey('b', $query->get());
    }

    public function testSetFragment() {
        $query = (new QueryStringBuilder())->setFragment('nose')->build();
        static::assertSame('nose', $query->getFragment());
    }

    public function testSetQueryDataByUri() {
        $uri = 'foo://example.com:8042/over/there?name=ferret&a[]=11&a[]=22#nose';
        $query = (new QueryStringBuilder())->setQueryDataByUri($uri)->build();
        static::assertInstanceOf(QueryStringInterface::class, $query);
        static::assertSame('nose', $query->getFragment());
        static::assertSame(['11', '22'], $query->get('a')->getValue());
    }

    public function testSetQueryDataByUriWithException() {
        $this->expectException(QueryStringNotFoundException::class);
        $uri = 'foo://example.com:8042/over/there?#nose';
        $query = (new QueryStringBuilder())->setQueryDataByUri($uri)->build();
    }

    public function testGetParamWithException() {
        $this->expectException(QueryStringNotFoundException::class);
        $uri = 'foo://example.com:8042/over/there?name=ferret&a[]=11&a[]=22#nose';
        $query = (new QueryStringBuilder())->setQueryDataByUri($uri)->build();
        $query->get('b');
    }

    public function testToString() {
        $uri = 'foo://example.com:8042/over/there?name=ferret&a[]=11&a[]=22#nose';
        $query = (new QueryStringBuilder())->setQueryDataByUri($uri)->build();
        self::assertSame('name=ferret&a[0]=11&a[1]=22#nose', urldecode($query->toString()));
    }
}