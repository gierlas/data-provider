<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;

/**
 * Class CallbackFilterDefinition
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class CallbackFilterDefinition extends AbstractValueDefinition
{
	/**
	 * @var callable
	 */
	private $callback;

	/**
	 * @var mixed
	 */
	private $wholePayload;

	/**
	 * CallbackFilterDefinition constructor.
	 * @param string   $name
	 * @param callable $callback
	 * @param bool     $allowUseEmpty
	 * @param int      $filterType
	 */
	public function __construct(string $name, callable $callback, bool $allowUseEmpty = false, $filterType = FILTER_SANITIZE_STRING)
	{
		parent::__construct($name, $allowUseEmpty, $filterType);
		$this->name = $name;
		$this->callback = $callback;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		parent::initData($params);
		$this->wholePayload = $params;
	}

	/**
	 * @return callable
	 */
	public function getCallback(): callable
	{
		return $this->callback;
	}

	/**
	 * @return mixed
	 */
	public function getWholePayload()
	{
		return $this->wholePayload;
	}
}