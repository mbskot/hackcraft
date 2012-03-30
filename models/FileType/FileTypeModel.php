<?php
namespace Models\FileType;

use Doctrine\ORM\EntityManager,
	Models\BaseModel;

class FileTypeModel extends BaseModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\FileType\FileTypeModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\FileType');
	}
}