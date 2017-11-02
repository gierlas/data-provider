<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;


/**
 * Class DateRangeDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateRangeFilterDefinition extends AbstractNameDefinition
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
	 * @return DateRangeFilterDefinition
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
	 * @return DateRangeFilterDefinition
	 */
	public function setTimezone($timezone)
	{
		$this->timezone = $timezone;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasDatePart(): bool
	{
		return $this->hasDatePart;
	}

	/**
	 * @param bool $hasDatePart
	 * @return DateRangeFilterDefinition
	 */
	public function setHasDatePart(bool $hasDatePart): DateRangeFilterDefinition
	{
		$this->hasDatePart = $hasDatePart;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasTimePart(): bool
	{
		return $this->hasTimePart;
	}

	/**
	 * @param bool $hasTimePart
	 * @return DateRangeFilterDefinition
	 */
	public function setHasTimePart(bool $hasTimePart): DateRangeFilterDefinition
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
	 * @return DateRangeFilterDefinition
	 */
	public function setStartName(string $startName): DateRangeFilterDefinition
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
	 * @return DateRangeFilterDefinition
	 */
	public function setEndName(string $endName): DateRangeFilterDefinition
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
		$rangeValue = $params[$this->name] ?? [];

		if(empty($rangeValue)) return;

		$this->dateStart = $this->getDate($rangeValue[$this->startName] ?? null);
		$this->dateEnd = $this->getDate($rangeValue[$this->endName] ?? null);
	}

	/**
	 * @return \DateTime|null
	 * @throws \InvalidArgumentException
	 */
	protected function getDate($value)
	{
		if ($value === null) {
			return null;
		}

		if ($value instanceof \DateTime) {
			return $value;
		}

		if(!is_string($value)) {
			throw new \InvalidArgumentException("$value is not proper date.");
		}

		$date = $this->format !== null
			? \DateTime::createFromFormat($this->format, $value, $this->timezone)
			: new \DateTime($value, $this->timezone);

		if(is_bool($date)) {
			throw new \InvalidArgumentException("$value is not proper date.");
		}

		return $date;
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