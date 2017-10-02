<?php

namespace Kora\DataProvider\OperatorDefinition;

use Kora\DataProvider\OperatorDefinitionInterface;


/**
 * Interface FilterOperatorInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface FilterOperatorDefinitionInterface extends OperatorDefinitionInterface
{
	public function getName(): string;
}