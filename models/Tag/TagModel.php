<?php
namespace Models\Tag;

use Doctrine\ORM\EntityManager,
	Models\BaseModel;

class TagModel extends BaseModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\Tag\TagModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\Tag');
	}
}