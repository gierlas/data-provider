<?php

namespace Kora\DataProvider\Exception;

use Kora\DataProvider\DataProviderInterface;


/**
 * Class MissingOperatorsImplementationsException
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class MissingOperatorsImplementationsException extends \Exception
{
	/**
	 * @var DataProviderInterface
	 */
	private $dataProvider;

	/**
	 * MissingOperatorsImplementationsException constructor.
	 *
	 * @param DataProviderInterface $dataProvider
	 */
	public function __construct(DataProviderInterface $dataProvider)
	{
		$class = get_class($dataProvider);
		parent::__construct("There are no operator implementation for provider $class");

		$this->dataProvider = $dataProvider;
	}

	/**
	 * @return DataProviderInterface
	 */
	public function getDataProvider(): DataProviderInterface
	{
		return $this->dataProvider;
	}
}