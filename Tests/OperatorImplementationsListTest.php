<?php

namespace Kora\DataProvider\Tests;

use Kora\DataProvider\OperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementationInterface;
use Kora\DataProvider\OperatorImplementationsList;
use PHPUnit\Framework\TestCase;

/**
 * Class DataProviderOperatorImplementationsTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class OperatorImplementationsListTest extends TestCase
{
	public function testAdd()
	{
		$operatorDefinition = $this->getMockBuilder(OperatorDefinitionInterface::class)->getMock();
		$operatorImplementation = $this->getMockBuilder(OperatorImplementationInterface::class)->getMock();

		$operatorDefinitionCode = OperatorImplementationsList::getOperatorCode($operatorDefinition);
		$implementationList = new OperatorImplementationsList();

		$this->assertFalse($implementationList->hasImplementation($operatorDefinitionCode));

		$implementationList->addImplementation($operatorDefinitionCode, $operatorImplementation);

		$this->assertTrue($implementationList->hasImplementation($operatorDefinitionCode));
		$this->assertEquals($operatorImplementation, $implementationList->getImplementation($operatorDefinitionCode));
	}
}