<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestHelper.php';
require_once RELATIVE_PATH . 'framework/Model.php';

final class ModelTest extends TestCase
{
    private function createModel(): \framework\Model
    {
        $reflection = new ReflectionClass(\framework\Model::class);
        /** @var \framework\Model $model */
        $model = $reflection->newInstanceWithoutConstructor();

        return $model;
    }

    public function testSetAndGetResultSet(): void
    {
        $model = $this->createModel();
        $result = new stdClass();

        $model->setResultSet($result);

        $this->assertSame($result, $model->getResultSet());
    }

    public function testEnvelopeSqlWrapsCurrentQuery(): void
    {
        $model = $this->createModel();
        $reflection = new ReflectionClass($model);
        $property = $reflection->getProperty('sql');
        $property->setAccessible(true);
        $property->setValue($model, 'SELECT * FROM users');

        $model->envelopeSql();

        $this->assertSame('SELECT mvc_sql_evelop.* FROM (SELECT * FROM users) mvc_sql_evelop', $property->getValue($model));
    }
}
