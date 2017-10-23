<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;


/**
 * Class AbstractNameDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
abstract class AbstractNameDefinition implements FilterOperatorDefinitionInterface
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * AbstractNameDefinition constructor.
	 * @param string $name
	 */
	public function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

}