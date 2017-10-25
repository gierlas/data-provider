<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;


/**
 * Class DateFilterDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateFilterDefinition extends AbstractNameDefinition
{
	/**
	 * @var \DateTime|null
	 */
	protected $date;

	/**
	 * @var null|string
	 */
	protected $format;

	/**
	 * @var null|\DateTimeZone
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
	 * DateFilterDefinition constructor.
	 * @param string $name
	 * @param string $format
	 * @param null   $timezone
	 */
	public function __construct($name, string $format = 'Y-m-d H:i:s', $timezone = null)
	{
		parent::__construct($name);
		$this->format = $format;
		$this->timezone = $timezone;
	}

	/**
	 * @return null|string
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param null|string $format
	 * @return DateFilterDefinition
	 */
	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	}

	/**
	 * @return \DateTimeZone|null
	 */
	public function getTimezone()
	{
		return $this->timezone;
	}

	/**
	 * @param \DateTimeZone|null $timezone
	 * @return DateFilterDefinition
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
	 * @return DateFilterDefinition
	 */
	public function setHasDatePart(bool $hasDatePart): DateFilterDefinition
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
	 * @return DateFilterDefinition
	 */
	public function setHasTimePart(bool $hasTimePart): DateFilterDefinition
	{
		$this->hasTimePart = $hasTimePart;
		return $this;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param array $params
	 * @throws \InvalidArgumentException
	 */
	public function initData(array $params)
	{
		if (!isset($params[$this->name])) {
			return;
		}

		$dateValue = $params[$this->name];

		if ($dateValue instanceof \DateTime) {
			$this->date = $dateValue;
			return;
		}

		$this->date = $this->format !== null ? \DateTime::createFromFormat($this->format, $dateValue, $this->timezone)
			: new \DateTime($dateValue, $this->timezone);

		$this->assertInit($dateValue);
	}

	/**
	 * @param $input
	 * @throws \InvalidArgumentException
	 */
	protected function assertInit($input)
	{
		if (!$this->date instanceof \DateTime) {
			throw new \InvalidArgumentException("$input is not proper value.");
		}
	}

	/**
	 * @return array
	 */
	public function getParamValue()
	{
		if ($this->date === null) {
			return null;
		}

		return [$this->name => $this->date->format($this->format)];
	}
}