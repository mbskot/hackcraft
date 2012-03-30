<?php
namespace Models\Category;

use Doctrine\ORM\EntityManager,
	Models\BaseModel;

class CategoryModel extends BaseModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\Category\CategoryModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\Category');
	}
}