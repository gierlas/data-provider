<?php

namespace Kora\DataProvider\Tests;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\DataProviderManager;
use Kora\DataProvider\OperatorImplementationsList;
use Kora\DataProvider\Exception\MissingOperatorsImplementationsException;
use Kora\DataProvider\OperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementationInterface;
use Kora\DataProvider\Result;
use PHPUnit\Framework\TestCase;


/**
 * Class DataProviderManagerTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class DataProviderManagerTest extends TestCase
{
	public function testAddImplementationList()
	{
		$implementationListCode = 'testList';
		$implementationList = new OperatorImplementationsList();

		$dataProviderManager = new DataProviderManager();

		$this->assertFalse($dataProviderManager->hasImplementations($implementationListCode));

		$dataProviderManager->addImplementationList($implementationListCode, $implementationList);

		$this->assertTrue($dataProviderManager->hasImplementations($implementationListCode));
	}

	public function testProperImplementationsUsed()
	{
		$implementationListCode = 'testList';
		$implementationList = new OperatorImplementationsList();

		$dataProviderManager = new DataProviderManager();
		$dataProviderManager->addImplementationList($implementationListCode, $implementationList);

		$this->assertEquals($implementationList, $dataProviderManager->getImplementations($implementationListCode));
	}

	public function testFetchDataMissingProvider()
	{
		$this->expectException(MissingOperatorsImplementationsException::class);

		$params = [];
		$dataProviderMock = $this
			->getMockBuilder(DataProviderInterface::class)
			->getMock();

		$dataProviderManager = new DataProviderManager();
		$dataProviderManager->fetchData($dataProviderMock, $params);
	}

	public function testDataProviderManagerFlow()
	{
		$params = [];

		$operatorDefinition = $this->getMockBuilder(OperatorDefinitionInterface::class)->getMock();
		$operatorDefinition->expects($this->once())->method('initData')->with($params);

		$operatorDefinitionNotImplemented = $this->getMockBuilder(OperatorDefinitionInterface::class)
			->setMockClassName('NotImplementedOperator')->getMock();
		$operatorDefinitionNotImplemented
			->expects($this->never())->method('initData');

		$dataProvider = $this->getMockBuilder(DataProviderInterface::class)->getMock();
		$dataProvider
			->expects($this->once())
			->method('getOperators')
			->willReturn([$operatorDefinition, $operatorDefinitionNotImplemented]);

		$dataProvider
			->expects($this->once())
			->method('count');

		$dataProvider
			->expects($this->once())
			->method('fetchData');

		$operatorImplementation = $this->getMockBuilder(OperatorImplementationInterface::class)->getMock();
		$operatorImplementation
			->expects($this->atLeast(1))
			->method('apply')
			->with($dataProvider, $operatorDefinition);

		$dataProviderCode = DataProviderManager::getDataProviderCode($dataProvider);
		$operatorDefinitionCode = OperatorImplementationsList::getOperatorCode($operatorDefinition);

		$operatorImplementationsList = $this->getMockBuilder(OperatorImplementationsList::class)
			->enableProxyingToOriginalMethods()->getMock();

		$operatorImplementationsList->addImplementation($operatorDefinitionCode, $operatorImplementation);
		$operatorImplementationsList
			->expects($this->atLeast(2))
			->method('hasImplementation');

		$dataManager = new DataProviderManager();
		$dataManager->addImplementationList($dataProviderCode, $operatorImplementationsList);

		$result = $dataManager->fetchData($dataProvider, $params);

		$this->assertInstanceOf(Result::class, $result);
	}
}