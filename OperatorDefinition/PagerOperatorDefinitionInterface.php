<?php


namespace Kora\DataProvider\OperatorDefinition;

use Kora\DataProvider\OperatorDefinitionInterface;


/**
 * Interface PagerOperatorInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface PagerOperatorDefinitionInterface extends OperatorDefinitionInterface
{
	public function getPaginator(int $nbResults, array $additionalParams): PaginatorInterface;

}