<?php
namespace Models\User;

use Doctrine\ORM\EntityManager,
	Models\BaseModel;

class UserModel extends BaseModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\User\UserModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\User');
	}
}