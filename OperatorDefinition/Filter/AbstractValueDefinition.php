<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;


/**
 * Class AbstractValueDefinition
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
abstract class AbstractValueDefinition extends AbstractNameDefinition
{
	/**
	 * @var bool
	 */
	protected $allowEmpty;

	/**
	 * @var int
	 */
	protected $filterType;

	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * AbstractValueDefinition constructor.
	 * @param string   $name
	 * @param int|null $filterType
	 * @param bool     $allowUseEmpty
	 */
	public function __construct(string $name, bool $allowUseEmpty = false, $filterType = FILTER_SANITIZE_STRING)
	{
		parent::__construct($name);
		$this->allowEmpty = $allowUseEmpty;
		$this->filterType = $filterType;
	}

	/**
	 * Init value
	 * @param array $params
	 */
	public function initData(array $params)
	{
		if (!empty($params[$this->name])) {
			$this->value = $this->filterType
				? filter_var($params[$this->name], $this->filterType) : $params[$this->name];
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return array|null
	 */
	public function getParamValue()
	{
		return $this->shouldApply() ? [$this->name => $this->value] : null;
	}

	/**
	 * @return bool
	 */
	public function allowUseEmpty(): bool
	{
		return $this->allowEmpty;
	}

	/**
	 * @return bool
	 */
	public function shouldApply(): bool
	{
		return $this->allowEmpty || !empty($this->value);
	}
}