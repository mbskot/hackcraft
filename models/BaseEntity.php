<?php
namespace Models;

use Nette\Object;

abstract class BaseEntity extends Object
{
	/**
	 * @param array
	 * @return Models\BaseEntity
	 */
	public function __construct(array $values = array())
	{
		$this->setData($values);
	}
	
	/**
	 * @param array
	 */
	public function setData(array $values)
	{
		foreach($values as $key => $value)
		{
			$method = 'set' . ucfirst($key);

			if($this->reflection->hasMethod($method))
			{
				$this->$method($value);
			}
		}
	}
}