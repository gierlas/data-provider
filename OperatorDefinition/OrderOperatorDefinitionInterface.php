<?php


namespace Kora\DataProvider\OperatorDefinition;

use Kora\DataProvider\OperatorDefinitionInterface;


/**
 * Interface OrderOperatorInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface OrderOperatorDefinitionInterface extends OperatorDefinitionInterface
{
	const DIR_DESC = 'DESC';

	const DIR_ASC = 'ASC';

	/**
	 * @param string $columnName
	 * @return OrderOperatorDefinitionInterface
	 */
	public function addOrderColumn(string $columnName): OrderOperatorDefinitionInterface;

	/**
	 * @param array $orderColumns
	 * @return OrderOperatorDefinitionInterface
	 */
	public function setOrderColumns(array $orderColumns): OrderOperatorDefinitionInterface;

	/**
	 * @param array $params
	 */
	public function setExtraOrderParams(array $params);

	/**
	 * @param string $columnName
	 * @return bool
	 */
	public function isColumnOrdered(string $columnName): bool;

	/**
	 * @param string $columnName
	 * @return array
	 */
	public function getColumnOrderParams(string $columnName): array;

	/**
	 * @param string $columnName
	 * @return string|null
	 */
	public function getColumnCurrentOrderDirection(string $columnName);
}