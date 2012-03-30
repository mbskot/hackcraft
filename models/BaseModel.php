<?php
namespace Models;

use Doctrine\ORM\EntityManager,
	Nette\Object;

class BaseModel extends Object
{
	/** @var Doctrine\ORM\EntityManager */
	protected $entityManager;
	/** @var Doctrine\ORM\EntityRepository */
	protected $repository;
	/**	@var string */
	protected $entityName;
	
	
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @param string
	 * @return Models\BaseModel
	 */
	public function __construct(EntityManager $entityManager, $entityName)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository($entityName);
		$this->entityName = $entityName;
	}
	
	/**
	 * @return Models\BaseRepository
	 */
	public function getRepository()
	{
		return $this->repository;
	}
	
	/**
	 * @param array
	 * @return Models\BaseEntity
	 */
	public function create(array $values = array())
	{
		$entity = new $this->entityName();
		$entity->setData($values);
		return $entity;
	}
	
	/**
	 * @param Models\BaseEntity
	 * @return Models\BaseEntity
	 */
	public function save(BaseEntity $entity)
	{
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
		return $entity;
	}
	
	/**
	 * @param Models\BaseEntity
	 * @param bool
	 */
	public function delete(BaseEntity $entity)
	{
		$this->entityManager->remove($entity);
		$this->entityManager->flush();
		return TRUE;
	}
	
	/**
	 * @param  string  method name
	 * @param  array   arguments
	 * @return mixed
	 * @throws MemberAccessException
	 */
	public function __call($name, $args)
	{
		if(!$this->reflection->hasMethod($name) && preg_match('/^find/', $name))
		{
			return callback($this->repository, $name)->invokeArgs($args);
		}
		else
		{
			parent::__call($name, $args);
		}
	}
}