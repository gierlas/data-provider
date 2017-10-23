<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProviderInterface;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;


/**
 * Class ChoiceFilterDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class ChoiceFilterDefinition implements FilterOperatorDefinitionInterface
{
	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var ChoiceProviderInterface
	 */
	private $choiceProvider;

	/**
	 * @var bool
	 */
	private $multi;

	/**
	 * @var int
	 */
	private $filterType;

	/**
	 * ChoiceFilterDefinition constructor.
	 * @param string                  $name
	 * @param ChoiceProviderInterface $choiceProvider
	 * @param bool                    $multi
	 * @param int                     $filterType
	 * @internal param array $choices
	 */
	public function __construct($name, ChoiceProviderInterface $choiceProvider, bool $multi = false, $filterType = FILTER_SANITIZE_STRING)
	{
		$this->name = $name;
		$this->choiceProvider = $choiceProvider;
		$this->multi = $multi;
		$this->filterType = $filterType;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getChoices(): array
	{
		return $this->choiceProvider->getAvailableChoices();
	}

	/**
	 * @param array $choices
	 * @return ChoiceFilterDefinition
	 */
	public function setChoices(array $choices): ChoiceFilterDefinition
	{
		$this->choices = $choices;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isMulti(): bool
	{
		return $this->multi;
	}

	/**
	 * @param bool $multi
	 * @return ChoiceFilterDefinition
	 */
	public function setMulti(bool $multi): ChoiceFilterDefinition
	{
		$this->multi = $multi;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getFilterType(): int
	{
		return $this->filterType;
	}

	/**
	 * @param int $filterType
	 * @return ChoiceFilterDefinition
	 */
	public function setFilterType(int $filterType): ChoiceFilterDefinition
	{
		$this->filterType = $filterType;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		if(!isset($params[$this->name])) return;

		$value = $params[$this->name];

		if($this->multi) {
			$choices = $this->filterType !== null ? $this->filterMulti($value) : $value;
			$this->value = $this->choiceProvider->validateChoices($choices);
			return;
		}

		$choice = $this->filterType !== null ? filter_var($value, $this->filterType) : $value;
		$this->value = $this->choiceProvider->validateChoice($choice);
	}

	/**
	 * @param array $value
	 * @return array
	 */
	protected function filterMulti(array $value)
	{
		return array_map(function($value) { return filter_var($value, $this->filterType); }, $value);
	}

	/**
	 * @return array|null
	 */
	public function getParamValue()
	{
		return !empty($this->value) ? [$this->name => $this->value] : null;
	}
}