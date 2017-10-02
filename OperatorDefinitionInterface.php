<?php

namespace Kora\DataProvider;


/**
 * Interface DataProviderOperatorInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface OperatorDefinitionInterface
{
	/**
	 * @param array $params
	 */
	public function initData(array $params);

	/**
	 * @return array|null
	 */
	public function getParamValue();
}