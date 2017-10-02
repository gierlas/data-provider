<?php

namespace Kora\DataProvider\OperatorDefinition\Pager\Paginator;

use Kora\DataProvider\OperatorDefinition\PaginatorInterface;


/**
 * Class LimitOffsetPaginator
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class LimitOffsetPaginator implements PaginatorInterface
{
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
	 * @param int|string $nb
	 * @return array
	 * @throws \Exception
	 */
	public function getPageParams($nb): array
	{
		$limit = $this->limit;

		if($nb === 'last') {
			return array_merge($this->additionalParams, [
				$this->offsetParamName => ($this->lastPage - 1) * $limit,
				$this->limitParamName => $limit
			]);
		}

		if($nb === 'first') {
			return array_merge($this->additionalParams, [
				$this->offsetParamName => 0,
				$this->limitParamName => $limit
			]);
		}

		if($nb === 'previous') {
			$offset = $this->offset - $this->limit;
			return array_merge($this->additionalParams, [
				$this->offsetParamName => $offset < 0 ? 0 : $offset,
				$this->limitParamName => $limit
			]);
		}

		if($nb === 'next') {
			$offset = $this->offset + $this->limit;
			return array_merge($this->additionalParams, [
				$this->offsetParamName => $offset > $this->totalNb ? ($this->lastPage - 1) * $limit : $offset,
				$this->limitParamName => $limit
			]);
		}

		if(is_int($nb)) {
			return array_merge($this->additionalParams, [
				$this->offsetParamName => $limit * ($nb - 1),
				$this->limitParamName => $limit
			]);
		}

		throw new \Exception('Wrong page type');
	}
}