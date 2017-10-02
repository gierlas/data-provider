<?php

namespace Kora\DataProvider\OperatorDefinition\Order;

use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;


/**
 * Class SingleOrderDefinition
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class SingleOrderDefinition implements OrderOperatorDefinitionInterface
{
	/**
	 * @var string
	 */
	private $columnParamName;

	/**
	 * @var string
	 */
	private $directionParamName;

	/**
	 * @var string
	 */
	private $columnName;

	/**
	 * @var string
	 */
	private $direction;

	/**
	 * @var array|string[]
	 */
	private $allowedColumns;

	/**
	 * @var array
	 */
	private $extraParams = [];

	/**
	 * SingleOrderDefinition constructor.
	 * @param string[] $allowedColumns
	 * @param string   $columnParamName
	 * @param string   $directionParamName
	 */
	public function __construct(array $allowedColumns = [], string $columnParamName = '_order_col', string $directionParamName = '_order_dir')
	{
		$this->allowedColumns = $allowedColumns;
		$this->columnParamName = $columnParamName;
		$this->directionParamName = $directionParamName;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		$columnName = $params[$this->columnParamName] ?? null;
		if (!$columnName || !in_array($columnName, $this->allowedColumns, true)) return;

		$this->columnName = $params[$this->columnParamName] ?? null;
		$this->direction = $params[$this->directionParamName] ?? OrderOperatorDefinitionInterface::DIR_DESC;
		$this->direction = $this->direction === OrderOperatorDefinitionInterface::DIR_ASC
			? OrderOperatorDefinitionInterface::DIR_ASC : OrderOperatorDefinitionInterface::DIR_DESC;
	}

	/**
	 * @return string
	 */
	public function getColumnName()
	{
		return $this->columnName;
	}

	/**
	 * @return string
	 */
	public function getDirection()
	{
		return $this->direction;
	}

	/**
	 * @param string $columnName
	 * @return OrderOperatorDefinitionInterface
	 */
	public function addOrderColumn(string $columnName): OrderOperatorDefinitionInterface
	{
		$this->allowedColumns[] = $columnName;
		return $this;
	}

	/**
	 * @param array $orderColumns
	 * @return OrderOperatorDefinitionInterface
	 */
	public function setOrderColumns(array $orderColumns): OrderOperatorDefinitionInterface
	{
		$this->allowedColumns = $orderColumns;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParamValue(): array
	{
		if(empty($this->columnName)) return [];

		return [
			$this->columnParamName => $this->columnName,
			$this->directionParamName => $this->direction
		];
	}

	/**
	 * @param array $params
	 */
	public function setExtraOrderParams(array $params)
	{
		$this->extraParams = $params;
	}

	/**
	 * @param string $columnName
	 * @return bool
	 */
	public function isColumnOrdered(string $columnName): bool
	{
		return in_array($columnName, $this->allowedColumns);
	}

	/**
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnOrderParams(string $columnName): array
	{
		if(!in_array($columnName, $this->allowedColumns)) return [];

		$direction = $columnName !== $this->columnName || $this->direction === OrderOperatorDefinitionInterface::DIR_ASC
			? OrderOperatorDefinitionInterface::DIR_DESC : OrderOperatorDefinitionInterface::DIR_ASC;

		return $this->extraParams + [
			$this->columnParamName => $columnName,
			$this->directionParamName => $direction
		];
	}

	/**
	 * @param string $columnName
	 * @return string|null
	 */
	public function getColumnCurrentOrderDirection(string $columnName)
	{
		return in_array($columnName, $this->allowedColumns) && $this->columnName == $columnName
			? $this->direction
			: null;
	}
}