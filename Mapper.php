<?php

namespace Kora\DataProvider;


/**
 * Class Mapper
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class Mapper
{
	/**
	 * @var array
	 */
	private $columnMap;

	/**
	 * @var array
	 */
	private $operatorFieldMap;

	/**
	 * Mapper constructor.
	 * @param array $columnMap
	 * @param array $operatorFieldMap
	 */
	public function __construct(array $columnMap = [], array $operatorFieldMap = [])
	{

		$this->columnMap = $columnMap;
		$this->operatorFieldMap = $operatorFieldMap;
	}

	/**
	 * @param string $friendlyName
	 * @param string $providerName
	 * @return Mapper
	 */
	public function mapColumn(string $friendlyName, string $providerName): Mapper
	{
		$this->columnMap[$friendlyName] = $providerName;
		return $this;
	}

	/**
	 * @param string $friendlyName
	 * @param string $providerName
	 * @return Mapper
	 */
	public function mapOperatorField(string $friendlyName, string $providerName): Mapper
	{
		$this->operatorFieldMap[$friendlyName] = $providerName;
		return $this;
	}

	/**
	 * @param string $friendlyName
	 * @param string $providerColumnName
	 * @param string $providerOperatorName
	 * @return Mapper
	 */
	public function map(string $friendlyName, string $providerColumnName, string $providerOperatorName): Mapper
	{
		$this->columnMap[$friendlyName] = $providerColumnName;
		$this->operatorFieldMap[$friendlyName] = $providerOperatorName;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getColumnMap(): array
	{
		return $this->columnMap;
	}

	/**
	 * @return array
	 */
	public function getOperatorFieldMap(): array
	{
		return $this->operatorFieldMap;
	}

	/**
	 * @param array $columnMap
	 * @return Mapper
	 */
	public function setColumnMap(array $columnMap): Mapper
	{
		$this->columnMap = $columnMap;
		return $this;
	}

	/**
	 * @param array $operatorFieldMap
	 * @return Mapper
	 */
	public function setOperatorFieldMap(array $operatorFieldMap): Mapper
	{
		$this->operatorFieldMap = $operatorFieldMap;
		return $this;
	}
}