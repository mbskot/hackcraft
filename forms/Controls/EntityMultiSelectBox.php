<?php
namespace Forms\Controls;

use Nette\Forms\Controls\MultiSelectBox;

/**
 * EntitySelect
 *
 * @author Jan Marek
 */
class EntityMultiSelectBox extends MultiSelectBox
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
	public function __construct($label = NULL, array $entities = NULL, $size = NULL, $idKey = 'id', $nameKey = 'name')
	{
		$this->entities = $entities;
		$this->idKey = $idKey;
		$this->nameKey = $nameKey;

		parent::__construct($label, NULL, $size);

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
	 * @param array
	 */
	private function prepareItems($value)
	{
		if($value === NULL)
		{
			return array();
		}
		
		$items = array();

		foreach ($value as $item)
		{
			if(is_object($item))
			{
				$items[] = $item->{'get' . $this->idKey}();
			}
			else
			{
				$items[] = $item;
			}
		}
		
		return $items;
	}
	
	/**
	 * @param mixin
	 */
	public function setValue($value)
	{
		parent::setValue($this->prepareItems($value));
	}
	
	/**
	 * @param mixin
	 */
	public function setDefaultValue($value)
	{
		parent::setDefaultValue($this->prepareItems($value));
	}
	
	/**
	 * @return array
	 */
	public function getValue()
	{
		$back = debug_backtrace();
		
		if(isset($back[1]["function"]) && isset($back[1]["class"]) && $back[1]["function"] === "getControl" && $back[1]["class"] === "Nette\Forms\Controls\SelectBox")
		{
			return parent::getValue();
		}
		
		$keys = parent::getValue();
		$values = array();
		
		foreach($keys as $key)
		{
			foreach($this->entities as $entity)
			{
				if($entity->{'get' . $this->idKey}() == $key)
				{
					$values[] = $entity;
				}
			}
		}
		
		return $values;
	}
}
