<?php

namespace Kora\DataProvider;


/**
 * Class DataProviderOperatorImplementations
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class OperatorImplementationsList
{
	/**
	 * @var OperatorImplementationInterface[]
	 */
	protected $implementations = [];

	/**
	 * @param string                          $code
	 * @param OperatorImplementationInterface $implementation
	 * @return OperatorImplementationsList
	 */
	public function addImplementation(string $code, OperatorImplementationInterface $implementation): self
	{
		$this->implementations[$code] = $implementation;
		return $this;
	}

	/**
	 * @param string $code
	 * @return bool
	 */
	public function hasImplementation(string $code): bool
	{
		return isset($this->implementations[$code]);
	}

	/**
	 * @param string $code
	 * @return OperatorImplementationInterface
	 */
	public function getImplementation(string $code): OperatorImplementationInterface
	{
		return $this->implementations[$code];
	}

	/**
	 * @param OperatorDefinitionInterface $definition
	 * @return string
	 */
	public static function getOperatorCode(OperatorDefinitionInterface $definition): string
	{
		return get_class($definition);
	}
}