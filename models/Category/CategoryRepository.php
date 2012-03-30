<?php
namespace Models\Category;

use Models\BaseEntity,
	Models\BaseRepository;

class CategoryRepository extends BaseRepository
{
	/** @var string */
	protected $alias = 'category';
	
	/**
	 * @return Doctrine\ORM\AbstractQuery
	 */
	public function findAll()
	{
		return $this->createQueryBuilder($this->alias)
			->orderBy($this->alias . '.ordering')
			->getQuery()
			->getResult();
	}
}