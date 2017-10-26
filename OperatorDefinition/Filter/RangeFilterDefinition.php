<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;


/**
 * Class RangeFilterDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class RangeFilterDefinition extends AbstractNameDefinition
{
	/**
	 * @var int
	 */
	protected $filter;

	/**
	 * @var int|float|null
	 */
	protected $min;

	/**
	 * @var int|float|null
	 */
	protected $max;

	/**
	 * @var string
	 */
	protected $minName = 'min';

	/**
	 * @var string
	 */
	protected $maxName = 'max';


	/**
	 * RangeFilterDefinition constructor.
	 * @param string $name
	 * @param int    $filter
	 */
	public function __construct(string $name, $filter = FILTER_SANITIZE_NUMBER_INT)
	{
		parent::__construct($name);
		$this->filter = $filter;
	}

	/**
	 * @return string
	 */
	public function getMinName(): string
	{
		return $this->minName;
	}

	/**
	 * @param string $minName
	 * @return RangeFilterDefinition
	 */
	public function setMinName(string $minName): RangeFilterDefinition
	{
		$this->minName = $minName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMaxName(): string
	{
		return $this->maxName;
	}

	/**
	 * @param string $maxName
	 * @return RangeFilterDefinition
	 */
	public function setMaxName(string $maxName): RangeFilterDefinition
	{
		$this->maxName = $maxName;
		return $this;
	}

	/**
	 * @return float|int|null
	 */
	public function getMin()
	{
		return $this->min;
	}

	/**
	 * @return float|int|null
	 */
	public function getMax()
	{
		return $this->max;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		$filterData = $params[$this->name] ?? [];
		$this->min = $this->getFilteredValue($filterData, $this->minName);
		$this->max = $this->getFilteredValue($filterData, $this->maxName);
	}

	/**
	 * @param $params
	 * @param $path
	 * @return null|int|float
	 */
	protected function getFilteredValue($params, $path)
	{
		return isset($params[$path])
			? ($this->filter ? filter_var($params[$path], $this->filter) : $params[$path])
			: null;
	}

	/**
	 * @return array
	 */
	public function getParamValue()
	{
		$ret = [];

		if($this->min) {
			$ret[$this->minName] = $this->min;
		}

		if($this->max) {
			$ret[$this->max] = $this->max;
		}

		if(!empty($ret)) {
			return [
				$this->name => $ret
			];
		}

		return [];
	}
}