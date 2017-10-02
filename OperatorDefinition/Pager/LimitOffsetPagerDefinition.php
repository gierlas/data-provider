<?php

namespace Kora\DataProvider\OperatorDefinition\Pager;

use Kora\DataProvider\OperatorDefinition\Pager\Paginator\LimitOffsetPaginator;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PaginatorInterface;


/**
 * Class LimitOffsetPager
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class LimitOffsetPagerDefinition implements PagerOperatorDefinitionInterface
{
	/**
	 * @var string
	 */
	private $limitParamName;

	/**
	 * @var string
	 */
	private $offsetParamName;

	/**
	 * @var int
	 */
	private $defaultOffset;

	/**
	 * @var int
	 */
	private $defaultLimit;

	/**
	 * @var int
	 */
	private $limit;

	/**
	 * @var int
	 */
	private $offset;

	/**
	 * LimitOffsetPager constructor.
	 * @param int    $defaultOffset
	 * @param int    $defaultLimit
	 * @param string $limitParamName
	 * @param string $offsetParamName
	 */
	public function __construct(
		int $defaultOffset = 0, int $defaultLimit = 20, string $limitParamName = '_limit', string $offsetParamName = '_offset'
	)
	{
		$this->limitParamName = $limitParamName;
		$this->offsetParamName = $offsetParamName;
		$this->defaultOffset = $defaultOffset;
		$this->defaultLimit = $defaultLimit;
		$this->limit = $this->defaultLimit;
		$this->offset = $this->defaultOffset;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		if(!empty($params[$this->limitParamName])) {
			$limit = filter_var($params[$this->limitParamName], FILTER_SANITIZE_NUMBER_INT);
			$limit = $limit <= 0 ? $this->defaultLimit : $limit;
			$this->limit = (int)$limit;
		}

		if(!empty($params[$this->offsetParamName])) {
			$offset = filter_var($params[$this->offsetParamName], FILTER_SANITIZE_NUMBER_INT);
			$offset = $offset <= 0 ? $this->defaultOffset : $offset;
			$this->offset = (int)$offset;
		}
	}

	/**
	 * @return int
	 */
	public function getLimit(): int
	{
		return $this->limit;
	}

	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->offset;
	}

	/**
	 * @return array
	 */
	public function getParamValue()
	{
		return [
			$this->offsetParamName => $this->offset,
			$this->limitParamName => $this->limit
		];
	}

	/**
	 * @param int   $nbResults
	 * @param array $additionalParams
	 * @return PaginatorInterface
	 */
	public function getPaginator(int $nbResults, array $additionalParams): PaginatorInterface
	{
		return new LimitOffsetPaginator(
			$this->offset, $this->limit, $nbResults, $additionalParams,
			$this->limitParamName, $this->offsetParamName
		);
	}

}