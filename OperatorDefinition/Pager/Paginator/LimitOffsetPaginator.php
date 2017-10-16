<?php

namespace Kora\DataProvider\OperatorDefinition\Pager\Paginator;

use Kora\DataProvider\OperatorDefinition\PaginatorInterface;


/**
 * Class LimitOffsetPaginator
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class LimitOffsetPaginator implements PaginatorInterface
{
	const PAGE_FIRST = 'first';
	const PAGE_LAST = 'last';
	const PAGE_PREVIOUS = 'previous';
	const PAGE_NEXT = 'next';

	/**
	 * @var int
	 */
	private $offset;

	/**
	 * @var int
	 */
	private $limit;

	/**
	 * @var int
	 */
	private $totalNb;

	/**
	 * @var array
	 */
	private $additionalParams;

	/**
	 * @var int
	 */
	private $lastPage;

	/**
	 * @var int
	 */
	private $currentPage;

	/**
	 * @var string
	 */
	private $limitParamName;

	/**
	 * @var string
	 */
	private $offsetParamName;

	/**
	 * LimitOffsetPaginator constructor.
	 * @param int    $offset
	 * @param int    $limit
	 * @param int    $totalNb
	 * @param array  $additionalParams
	 * @param string $limitParamName
	 * @param string $offsetParamName
	 */
	public function __construct(
		int $offset, int $limit, int $totalNb, array $additionalParams,
		string $limitParamName = '_limit', string $offsetParamName = '_offset'
	)
	{
		$this->offset = $offset;
		$this->limit = $limit;
		$this->totalNb = $totalNb;
		$this->additionalParams = $additionalParams;
		$this->lastPage = (int)ceil($this->totalNb / $this->limit);
		$this->currentPage = (int)ceil(($this->offset + 1) / $this->limit);
		$this->currentPage = $this->currentPage > $this->lastPage ? $this->lastPage : $this->currentPage;
		$this->limitParamName = $limitParamName;
		$this->offsetParamName = $offsetParamName;
	}

	/**
	 * @return bool
	 */
	public function isThereMore(): bool
	{
		return $this->limit < $this->totalNb;
	}

	/**
	 * @return int
	 */
	public function getNbPages(): int
	{
		return $this->lastPage;
	}

	/**
	 * @return bool
	 */
	public function isOnFirstPage(): bool
	{
		return $this->offset == 0;
	}

	/**
	 * @return bool
	 */
	public function isOnLastPage(): bool
	{
		return $this->currentPage == $this->lastPage;
	}

	/**
	 * @return int
	 */
	public function getCurrentPage(): int
	{
		return $this->currentPage;
	}

	/**
	 * @param int|string $page
	 * @return array
	 * @throws \Exception
	 */
	public function getPageParams($page): array
	{
		$limit = $this->limit;

		if(is_int($page)) {
			return array_merge($this->additionalParams, [
				$this->offsetParamName => $limit * ($page - 1),
				$this->limitParamName => $limit
			]);
		}

		if(in_array($page, [self::PAGE_FIRST, self::PAGE_LAST, self::PAGE_PREVIOUS, self::PAGE_NEXT], true)) {
			$pageParams = $this->getStringPageParams($page);
			return array_merge($this->additionalParams, $pageParams);
		}

		throw new \InvalidArgumentException("'$page' is not proper page.");
	}

	/**
	 * @param string $page
	 * @return array
	 */
	protected function getStringPageParams(string $page): array
	{
		if($page === self::PAGE_FIRST) {
			return [
				$this->offsetParamName => 0,
				$this->limitParamName => $this->limit
			];
		}

		if($page === self::PAGE_LAST) {
			return [
				$this->offsetParamName => ($this->lastPage - 1) * $this->limit,
				$this->limitParamName => $this->limit
			];
		}

		if($page === self::PAGE_PREVIOUS) {
			$offset = $this->offset - $this->limit;
			return [
				$this->offsetParamName => $offset < 0 ? 0 : $offset,
				$this->limitParamName => $this->limit
			];
		}

		$offset = $this->offset + $this->limit;
		return [
			$this->offsetParamName => $offset > $this->totalNb ? ($this->lastPage - 1) * $this->limit : $offset,
			$this->limitParamName => $this->limit
		];
	}
}