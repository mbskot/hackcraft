<?php
namespace Forms\Controls;

use Models\BaseEntity,
	Nette\Forms\Controls\SelectBox;

/**
 * EntitySelect
 *
 * @author Jan Marek
 */
class EntitySelectBox extends SelectBox
{
	/** @var array */
	private $entities = array();
	/** @var string */
	private $idKey;
	/** @var string */
	private $nameKey;
	
	
	/**
	 * @param string
	 * @param array
	 * @param string
	 * @param string
	 * @return Forms\Controls\EntitySelect
	 */
	public function __construct($label = NULL, array $entities = NULL, $idKey = 'id', $nameKey = 'name')
	{
		$this->entities = $entities;
		$this->idKey = $idKey;
		$this->nameKey = $nameKey;

		parent::__construct($label);

		if(count($entities))
		{
			$this->setItems($entities);
		}
	}

	/**
	 * @param array
	 * @param bool
	 * @return array
	 */
	public function setItems(array $entities, $useKeys = TRUE)
	{
		$items = array();
		
		foreach($entities as $entity)
		{
			$items[$entity->{'get' . $this->idKey}()] = $entity->{'get' . $this->nameKey}();
		}
		
		parent::setItems($items);
	}
	
	/**
	 * @param Models\BaseEntity|string
	 */
	public function setValue($value)
	{
		if($value instanceof BaseEntity)
		{
			$value = $value->{'get' . $this->idKey}();
		}
		
		parent::setValue($value);
	}
	
	/**
	 * @return mixin
	 */
	public function getValue()
	{
		$back = debug_backtrace();
		
		if(isset($back[1]['function']) && isset($back[1]['class']) && $back[1]['function'] === 'getControl' && $back[1]['class'] === 'Nette\Forms\Controls\SelectBox')
		{
			return parent::getValue();
		}
		
		$val = parent::getValue();
		
		foreach($this->entities as $entity)
		{
			if($entity->{'get' . $this->idKey}() == $val)
			{
				return $entity;
			}
		}
		
		return NULL;
	}
}
