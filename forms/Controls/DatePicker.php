<?php
namespace Forms\Controls;

use DateTime,
	Nette\Application\UI\Form,
	Nette\Forms\Controls\TextInput,
	Nette\Forms\IControl;

class DatePicker extends TextInput
{
	/** @var string */
	private $format = 'd.m.Y';
	/** @var string */
	private $formatLabel = 'dd.mm.yyyy';
	/** @var array */
	private static $formatPhpToJs = array(
		'd' => 'dd',
		'j' => 'd',
		'm' => 'mm',
		'n' => 'm',
		'z' => 'o',
		'Y' => 'yy',
		'y' => 'y',
		'U' => '@',
		'h' => 'h',
		'H' => 'hh',
		'g' => 'g',
		'A' => 'TT',
		'i' => 'mm',
		's' => 'ss',
		'G' => 'h',
	);
	
	
	/**
	 * @param string
	 * @param int
	 * @param int
	 * @return Forms\Controls\DatePicker
	 */
	public function __construct($label = NULL, $cols = NULL, $maxLength = NULL)
	{
		parent::__construct($label, $cols, $maxLength);
		
		$this->setAttribute('class', 'datepicker');
		$this->setAttribute('data-dateformat', $this->translateFormatToJs($this->format));
		
		$this->addCondition(Form::FILLED)
			->addRule(Form::VALID, 'Dátum musí byť zadaný vo formáte "' . $this->formatLabel . '"!');
	}
	
	/**
	 * @param string
	 * @return string
	 */
	protected function translateFormatToJs($format)
	{
		return str_replace(array_keys(static::$formatPhpToJs), array_values(static::$formatPhpToJs), $this->translate($format));
	}
	
	/**
	* @return \DateTime|NULL
	*/
	public function getValue()
	{
		$value = parent::getValue();
		$value = \DateTime::createFromFormat($this->format, $value);
		$err = \DateTime::getLastErrors();
		
		if($err['error_count'])
		{
			$value = FALSE;
		}
		
		return $value;
	}

	/**
	* @param \DateTime
	* @return BaseDateTime
	*/
	public function setValue($value = NULL)
	{
		try
		{
			if($value instanceof \DateTime)
			{
				return parent::setValue($value->format($this->format));
			}
			else
			{
				return parent::setValue($value);
			}
		}
		catch(\Exception $e)
		{
			return parent::setValue(NULL);
		}
	}

	/**
	* @param BaseDateTime
	* @return bool
	*/
	public static function validateValid(IControl $control)
	{
		$value = $control->getValue();
		return is_null($value) || $value instanceof \DateTime;
	}

	/**
	* @return bool
	*/
	public function isFilled()
	{
		return (bool) parent::getValue();
	}
}