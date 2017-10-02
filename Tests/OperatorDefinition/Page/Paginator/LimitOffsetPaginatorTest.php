<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Page\Paginator;

use Kora\DataProvider\OperatorDefinition\Pager\LimitOffsetPagerDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Class LimitOffsetPaginatorTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class LimitOffsetPaginatorTest extends TestCase
{
	protected $limName = 'lim';
	protected $offName = 'off';

	protected function getPaginator(int $limit, int $offset, int $nbResults, array $additionalParams)
	{
		$limitName = 'lim';
		$offsetName = 'off';
		$data = [$this->limName => $limit, $this->offName => $offset];

		$limitOffsetPagerDefinition = new LimitOffsetPagerDefinition(0, 20, $limitName, $offsetName);
		$limitOffsetPagerDefinition->initData($data);

		return $limitOffsetPagerDefinition->getPaginator($nbResults, $additionalParams);
	}

	/**
	 * @dataProvider isThereMoreProvider
	 * @param int  $limit
	 * @param int  $nbResults
	 * @param bool $isThereMore
	 */
	public function testIsThereMore(int $limit, int $nbResults, bool $isThereMore)
	{
		$paginator = $this->getPaginator($limit, 0, $nbResults, []);
		$this->assertEquals($isThereMore, $paginator->isThereMore());
	}

	public function isThereMoreProvider()
	{
		return [
			[0, 10, false], //Because default limit val is 20
			[100, 100, false],
			[50, 100, true],
			[120, 100, false],
		];
	}

	/**
	 * @dataProvider getNbPagesProvider
	 * @param int $limit
	 * @param int $nbResults
	 * @param int $nbPages
	 */
	public function testGetNbPages(int $limit, int $nbResults, int $nbPages)
	{
		$paginator = $this->getPaginator($limit, 0, $nbResults, []);
		$this->assertEquals($nbPages, $paginator->getNbPages());
	}

	public function getNbPagesProvider()
	{
		return [
			[10, 50, 5],
			[20, 30, 2],
			[5, 50, 10],
			[13, 40, 4]
		];
	}

	/**
	 * @dataProvider isOnFirstPageProvider
	 * @param int  $limit
	 * @param int  $offset
	 * @param int  $nbResults
	 * @param bool $isOnFirstPage
	 */
	public function testIsOnFirstPage(int $limit, int $offset, int $nbResults, bool $isOnFirstPage)
	{
		$paginator = $this->getPaginator($limit, $offset, $nbResults, []);
		$this->assertEquals($isOnFirstPage, $paginator->isOnFirstPage());
	}

	public function isOnFirstPageProvider()
	{
		return [
			[20, 0, 40, true],
			[20, 20, 40, false],
			[5, 5, 40, false],
			[30, 0, 40, true]
		];
	}

	/**
	 * @dataProvider isOnLastPageProvider
	 * @param int  $limit
	 * @param int  $offset
	 * @param int  $nbResults
	 * @param bool $isOnLastPage
	 */
	public function testIsOnLastPage(int $limit, int $offset, int $nbResults, bool $isOnLastPage)
	{
		$paginator = $this->getPaginator($limit, $offset, $nbResults, []);
		$this->assertEquals($isOnLastPage, $paginator->isOnLastPage());
	}

	public function isOnLastPageProvider()
	{
		return [
			[20, 0, 40, false],
			[20, 20, 40, true],
			[5, 5, 40, false],
			[30, 30, 40, true]
		];
	}

	/**
	 * @dataProvider getCurrentPageProvider
	 * @param int  $limit
	 * @param int  $offset
	 * @param int  $nbResults
	 * @param bool $currentPage
	 */
	public function testGetCurrentPage(int $limit, int $offset, int $nbResults, bool $currentPage)
	{
		$paginator = $this->getPaginator($limit, $offset, $nbResults, []);
		$this->assertEquals($currentPage, $paginator->getCurrentPage());
	}

	public function getCurrentPageProvider()
	{
		return [
			[5, 0, 20, 1],
			[5, 5, 40, 2],
			[10, 20, 10, 1],
			[20, 20, 25, 2],
			[10, 30, 40, 3]
		];
	}

	/**
	 * @dataProvider getPageParamsProvider
	 * @param int   $limit
	 * @param int   $offset
	 * @param int   $nbResults
	 * @param array $additionalParams
	 * @param       $page
	 * @param       $result
	 */
	public function testGetPageParams(int $limit, int $offset, int $nbResults, array $additionalParams, $page, $result)
	{
		$paginator = $this->getPaginator($limit, $offset, $nbResults, $additionalParams);
		$this->assertEquals($result, $paginator->getPageParams($page));
	}


	public function getPageParamsProvider()
	{
		$additionalParams = [
			'test' => 'test'
		];

		return [
			[5, 0, 20, [], 1, $this->getParams(5, 0)],
			[5, 0, 20, [], 'first', $this->getParams(5, 0)],
			[5, 0, 20, [], 'next', $this->getParams(5, 5)],
			[5, 10, 20, [], 'previous', $this->getParams(5, 5)],
			[5, 0, 20, [], 'last', $this->getParams(5, 15)],
			[5, 0, 20, $additionalParams, 1, $this->getParams(5, 0) + $additionalParams],
		];
	}

	protected function getParams(int $limit, int $offset): array
	{
		return [
			$this->limName => $limit,
			$this->offName => $offset
		];
	}

}