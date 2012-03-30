<?php
namespace Forms;

use Doctrine\Common\Collections\ArrayCollection,
	Doctrine\ORM\PersistentCollection,
	Models\BaseEntity,
	Models\BaseModel;

/**
 * @author Jan Marek
 */
class EntityForm extends BaseForm
{
	/** @var Models\BaseEntity */
	protected $entity;
	/** @var Models\BaseModel */
	protected $entityModel;
	
	
	/**
	 * @param Models\BaseModel
	 * @return Forms\EntityForm
	 */
	public function __construct(BaseModel $entityModel)
	{
		parent::__construct();
		
		$this->entityModel = $entityModel;
	}
	
	/**
	 * @return Models\BaseEntity
	 */
	public function getEntity()
	{
		return $this->entity;
	}
	
	/**
	 * @param Models\BaseEntity
	 */
	public function bindEntity(BaseEntity $entity)
	{
		$this->entity = $entity;
		
		foreach($this->getComponents() as $name => $input)
		{
			if(method_exists($entity, 'get' . $name))
			{
				$method = 'get' . $name;
			}
			else if(method_exists($entity, 'is' . $name))
			{
				$method = 'is' . $name;
			}
			else
			{
				continue;
			}
			
			$value = $entity->$method();
			
			if($value instanceof BaseEntity)
			{
				$value = $value->getId();
			}
			else if($value instanceof ArrayCollection || $value instanceof PersistentCollection)
			{
				$value = array_map(function(BaseEntity $entity) {
					return $entity->getId();
				}, $value->toArray());
			}
			
			$input->setDefaultValue($value);
		}
	}
	
	/**
	 * @param array
	 */
	protected function handleEntity(array $values)
	{
		if($this->entity == NULL)
		{
			$this->entity = $this->entityModel->create();
		}
		
		$this->entity->setData($values);
		$this->entityModel->save($this->entity);
	}
}