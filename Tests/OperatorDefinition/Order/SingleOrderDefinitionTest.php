<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Order;

use function GuzzleHttp\Promise\queue;
use Kora\DataProvider\OperatorDefinition\Order\SingleOrderDefinition;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class SingleOrderDefinitionTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class SingleOrderDefinitionTest extends TestCase
{
	protected $colParamName = '_col';

	protected $orderParamName = '_ord';


	/**
	 * @dataProvider initDataProvider
	 * @param array $allowedColumns
	 * @param array $data
	 * @param       $orderColumn
	 * @param       $orderDir
	 */
	public function testInitData(array $allowedColumns, array $data, $orderColumn, $orderDir)
	{
		$orderDefinition = new SingleOrderDefinition($allowedColumns, $this->colParamName, $this->orderParamName);
		$orderDefinition->initData($data);

		$this->assertEquals($orderColumn, $orderDefinition->getColumnName());
		$this->assertEquals($orderDir, $orderDefinition->getDirection());

		$expectedParams = empty($orderColumn) ? [] : [
			$this->colParamName   => $orderColumn,
			$this->orderParamName => $orderDir,
		];

		$this->assertEquals($expectedParams, $orderDefinition->getParamValue());
	}

	public function initDataProvider()
	{
		return [
			[['id'], [$this->colParamName => 'id'], 'id', OrderOperatorDefinitionInterface::DIR_DESC],

			[['id'], [$this->colParamName => 'id', $this->orderParamName => OrderOperatorDefinitionInterface::DIR_ASC],
				'id', OrderOperatorDefinitionInterface::DIR_ASC],

			[['id'], [$this->colParamName => 'id', $this->orderParamName => 'sadf'],
				'id', OrderOperatorDefinitionInterface::DIR_DESC],

			[['id'], [$this->colParamName => 'ida'], null, null],

			[[], [$this->colParamName => 'id', $this->orderParamName => 'sadf'], null, null]
		];
	}

	public function testAddOrderColumn()
	{
		$orderColumn = 'id';
		$data = [
			$this->colParamName => $orderColumn
		];

		$orderDefinition = new SingleOrderDefinition([], $this->colParamName, $this->orderParamName);
		$orderDefinition->initData($data);

		$this->assertEquals(null, $orderDefinition->getColumnName());
		$this->assertEquals(null, $orderDefinition->getDirection());

		$orderDefinition->addOrderColumn('id');

		$orderDefinition->initData($data);
		$this->assertEquals($orderColumn, $orderDefinition->getColumnName());
		$this->assertEquals(OrderOperatorDefinitionInterface::DIR_DESC, $orderDefinition->getDirection());
	}


	/**
	 * @dataProvider getColumnOrderParamsProvider
	 * @param array  $allowedColumns
	 * @param array  $data
	 * @param array  $additionalParams
	 * @param string $columnName
	 * @param        $expectedParams
	 */
	public function testGetColumnOrderParams(array $allowedColumns, array $data, array $additionalParams, string $columnName, $expectedParams)
	{
		$orderDefinition = new SingleOrderDefinition($allowedColumns, $this->colParamName, $this->orderParamName);
		$orderDefinition->initData($data);
		$orderDefinition->setExtraOrderParams($additionalParams);

		$orderParams = $orderDefinition->getColumnOrderParams($columnName);

		$this->assertEquals($expectedParams, $orderParams);
	}

	public function getColumnOrderParamsProvider()
	{
		$idCol = 'id';
		return [
			//Simple column
			[[$idCol], [], [], $idCol, [
				$this->colParamName   => $idCol,
				$this->orderParamName => OrderOperatorDefinitionInterface::DIR_DESC
			]],

			//Provide reverted order
			[[$idCol], [
				$this->colParamName   => $idCol,
				$this->orderParamName => OrderOperatorDefinitionInterface::DIR_DESC
			], [], $idCol, [
				$this->colParamName   => $idCol,
				$this->orderParamName => OrderOperatorDefinitionInterface::DIR_ASC
			]],

			[[$idCol], [
				$this->colParamName   => $idCol,
				$this->orderParamName => OrderOperatorDefinitionInterface::DIR_DESC
			], [], $idCol, [
				$this->colParamName   => $idCol,
				$this->orderParamName => OrderOperatorDefinitionInterface::DIR_ASC
			]],
		];
	}

	/**
	 * @dataProvider getColumnCurrentOrderDirectionProvider
	 * @param array  $allowedColumns
	 * @param array  $data
	 * @param string $columnName
	 * @param        $expectedDirection
	 */
	public function testGetColumnCurrentOrderDirection(array $allowedColumns, array $data, string $columnName, $expectedDirection)
	{
		$orderDefinition = new SingleOrderDefinition($allowedColumns, $this->colParamName, $this->orderParamName);
		$orderDefinition->initData($data);

		$columnDirection = $orderDefinition->getColumnCurrentOrderDirection($columnName);

		$this->assertEquals($expectedDirection, $columnDirection);
	}

	public function getColumnCurrentOrderDirectionProvider()
	{
		$idCol = 'id';
		return [
			[[$idCol], [], $idCol, null],
			[[$idCol], [$this->colParamName => $idCol], $idCol, OrderOperatorDefinitionInterface::DIR_DESC],
			[[$idCol], [$this->colParamName => $idCol, $this->orderParamName => OrderOperatorDefinitionInterface::DIR_ASC], $idCol, OrderOperatorDefinitionInterface::DIR_ASC],
			[[$idCol], [], 'asdf', null],
		];
	}
}
