<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;


/**
 * Class DateRangeDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateRangeDefinition extends AbstractNameDefinition
{
	const DATE_START_NAME = 'start';
	const DATE_END_NAME = 'end';

	/**
	 * @var null
	 */
	protected $format;

	/**
	 * @var null
	 */
	protected $timezone;

	/**
	 * @var bool
	 */
	protected $hasDatePart = true;

	/**
	 * @var bool
	 */
	protected $hasTimePart = false;

	/**
	 * @var \DateTime|null
	 */
	protected $dateStart;

	/**
	 * @var \DateTime|null
	 */
	protected $dateEnd;

	/**
	 * @var string
	 */
	protected $startName = self::DATE_START_NAME;

	/**
	 * @var string
	 */
	protected $endName = self::DATE_END_NAME;

	/**
	 * DateRangeDefinition constructor.
	 * @param string $name
	 * @param string $format
	 * @param null   $timezone
	 */
	public function __construct($name, string $format = 'Y-m-d', $timezone = null)
	{
		parent::__construct($name);
		$this->format = $format;
		$this->timezone = $timezone;
	}

	/**
	 * @return null
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param null $format
	 * @return DateRangeDefinition
	 */
	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	}

	/**
	 * @return null
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

	/**
	 * @param null $timezone
	 * @return DateRangeDefinition
	 */
	public function setTimezone($timezone)
	{
		$this->timezone = $timezone;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isHasDatePart(): bool
	{
		return $this->hasDatePart;
	}

	/**
	 * @param bool $hasDatePart
	 * @return DateRangeDefinition
	 */
	public function setHasDatePart(bool $hasDatePart): DateRangeDefinition
	{
		$this->hasDatePart = $hasDatePart;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isHasTimePart(): bool
	{
		return $this->hasTimePart;
	}

	/**
	 * @param bool $hasTimePart
	 * @return DateRangeDefinition
	 */
	public function setHasTimePart(bool $hasTimePart): DateRangeDefinition
	{
		$this->hasTimePart = $hasTimePart;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStartName(): string
	{
		return $this->startName;
	}

	/**
	 * @param string $startName
	 * @return DateRangeDefinition
	 */
	public function setStartName(string $startName): DateRangeDefinition
	{
		$this->startName = $startName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndName(): string
	{
		return $this->endName;
	}

	/**
	 * @param string $endName
	 * @return DateRangeDefinition
	 */
	public function setEndName(string $endName): DateRangeDefinition
	{
		$this->endName = $endName;
		return $this;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getDateStart()
	{
		return $this->dateStart;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getDateEnd()
	{
		return $this->dateEnd;
	}

	/**
	 * @param array $params
	 */
	public function initData(array $params)
	{
		$rangeValue = $params[$this->name];
		$this->dateStart = $this->getDate($rangeValue[$this->startName] ?? null);
		$this->dateEnd = $this->getDate($rangeValue[$this->endName] ?? null);
	}

	/**
	 * @return \DateTime|null
	 */
	protected function getDate($value)
	{
		if ($value === null) {
			return null;
		}

		if ($value instanceof \DateTime) {
			return $value;
		}

		return $this->format !== null
			? \DateTime::createFromFormat($this->format, $value, $this->timezone)
			: new \DateTime($value, $this->timezone);
	}

	/**
	 * @return array|null
	 */
	public function getParamValue()
	{
		if ($this->dateStart === null && $this->dateEnd === null) {
			return null;
		}

		$ret = [];

		if ($this->dateStart !== null) {
			$ret[$this->startName] = $this->dateStart->format($this->format);
		}

		if ($this->dateEnd !== null) {
			$ret[$this->endName] = $this->dateEnd->format($this->format);
		}

		return [$this->name => $ret];
	}
}