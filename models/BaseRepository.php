<?php
namespace Models;

use Doctrine\ORM\EntityRepository,
	Doctrine\ORM\QueryBuilder,
	Doctrine\ORM\Tools\Pagination\Paginator;

class BaseRepository extends EntityRepository
{
	/** @var string */
	protected $alias = 'entity';
	
	/**
	 * @param Doctrine\ORM\QueryBuilder
	 * @param int
	 * @param int
	 * @return Doctrine\ORM\Tools\Pagination\Paginator
	 */
	protected function getPaginated(QueryBuilder $queryBuilder, $limit = NULL, $offset = NULL)
	{
		$queryBuilder->setMaxResults($limit)
			->setFirstResult($offset);
		
		return new Paginator($queryBuilder);
	}
}