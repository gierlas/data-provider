<?php

namespace Kora\DataProvider\OperatorDefinition;


/**
 * Interface PaginatorInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface PaginatorInterface
{
	/**
	 * @return bool
	 */
	public function isThereMore(): bool;

	/**
	 * @return int
	 */
	public function getNbPages(): int;

	/**
	 * @return bool
	 */
	public function isOnFirstPage(): bool;

	/**
	 * @return bool
	 */
	public function isOnLastPage(): bool;

	/**
	 * @return int
	 */
	public function getCurrentPage(): int;

	/**
	 * @param string|int $page if string then allow: last, first, previous, next
	 * @return array
	 * @throws \Exception
	 */
	public function getPageParams($page): array;
}