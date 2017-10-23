<?php

namespace Kora\DataProvider\OperatorDefinition\Filter;


/**
 * Class DateFilterDefinition
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateFilterDefinition extends AbstractNameDefinition
{
	const FORMAT = 'Y-m-d';

	/**
	 * @var \DateTime|null
	 */
	protected $date;

	/**
	 * @var null
	 */
	private $format;

	/**
	 * @var null
	 */
	private $timezone;

	/**
	 * DateFilterDefinition constructor.
	 * @param string $name
	 * @param null   $format
	 * @param null   $timezone
	 */
	public function __construct($name, $format = null, $timezone = null)
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
	 * @return DateFilterDefinition
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
	 * @return DateFilterDefinition
	 */
	public function setTimezone($timezone)
	{
		$this->timezone = $timezone;
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
		$dateValue = $params[$this->name] ?? null;

		if($dateValue === null) {
			return;
		}

		if ($dateValue instanceof \DateTime) {
			$this->date = $dateValue;
			return;
		}

		$this->date = $this->format !== null
			? \DateTime::createFromFormat($this->format, $dateValue, $this->timezone)
			: new \DateTime($dateValue, $this->timezone);

		if(!$this->date instanceof \DateTime) {
			throw new \InvalidArgumentException("$dateValue is not proper value.");
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

		return [$this->name => $this->date->format($this->format ?? self::FORMAT)];
	}
}