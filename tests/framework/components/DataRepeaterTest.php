<?php

namespace framework\components;

use framework\Model;
use framework\View;
use PHPUnit\Framework\TestCase;

/**
 * Test class for DataRepeater.
 * This class focuses on testing the functionality of the __construct method.
 */
class DataRepeaterTest extends TestCase
{
    private $viewMock;
    private $modelMock;

    protected function setUp(): void
    {
        // Mocking View and Model classes
        $this->viewMock = $this->createMock(View::class);
        $this->modelMock = $this->createMock(Model::class);
    }

    /**
     * Test the constructor with no parameters.
     * Ensures no exceptions are thrown and the object initializes correctly.
     */
    public function testConstructorWithNoParameters()
    {
        $dataRepeater = new DataRepeater();
        $this->assertInstanceOf(DataRepeater::class, $dataRepeater);
    }

    /**
     * Test the constructor with a View and Model, without block and datalist.
     * Ensures View and Model are passed and no processing is done.
     */
    public function testConstructorWithViewAndModelNoBlockNoDataList()
    {
        $dataRepeater = new DataRepeater($this->viewMock, $this->modelMock);
        $this->assertInstanceOf(DataRepeater::class, $dataRepeater);
    }

    /**
     * Test the constructor with a block and data list provided.
     * Ensures setContentToBlock and setValuesFromArray are called with correct arguments.
     */
    public function testConstructorWithBlockAndDataList()
    {
        $block = "exampleBlock";
        $dataList = ["key1" => "value1", "key2" => "value2"];

        $dataRepeaterMock = $this->getMockBuilder(DataRepeater::class)
            ->setConstructorArgs([$this->viewMock, $this->modelMock, $block, $dataList])
            ->onlyMethods(['setContentToBlock', 'setValuesFromArray'])
            ->getMock();

        $dataRepeaterMock->expects($this->once())
            ->method('setContentToBlock')
            ->with($this->equalTo($block));

        $dataRepeaterMock->expects($this->once())
            ->method('setValuesFromArray')
            ->with($this->equalTo($dataList));

        $dataRepeaterMock->__construct($this->viewMock, $this->modelMock, $block, $dataList);
    }

    /**
     * Test the constructor with a block and no data list.
     * Ensures setContentToBlock and setValuesFromModel are called.
     */
    public function testConstructorWithBlockNoDataList()
    {
        $block = "exampleBlock";

        $dataRepeaterMock = $this->getMockBuilder(DataRepeater::class)
            ->setConstructorArgs([$this->viewMock, $this->modelMock, $block, null])
            ->onlyMethods(['setContentToBlock', 'setValuesFromModel'])
            ->getMock();

        $dataRepeaterMock->expects($this->once())
            ->method('setContentToBlock')
            ->with($this->equalTo($block));

        $dataRepeaterMock->expects($this->once())
            ->method('setValuesFromModel');

        $dataRepeaterMock->__construct($this->viewMock, $this->modelMock, $block, null);
    }

    /**
     * Test the constructor with all null parameters.
     * Ensures no exceptions are thrown and the object initializes correctly.
     */
    public function testConstructorWithAllNullParameters()
    {
        $dataRepeater = new DataRepeater(null, null, null, null);
        $this->assertInstanceOf(DataRepeater::class, $dataRepeater);
    }
}