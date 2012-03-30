<?php
namespace Models\Article;

use Models\BaseRepository;

class ArticleRepository extends BaseRepository
{
	/** @var string */
	protected $alias = 'article';
	/** @var string */
	protected $userAlias = 'user';
	/** @var string */
	protected $userEntity = 'Models\User\User';
	
	/**
	 * @param array
	 * @param int
	 * @param int
	 * @return Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function findByTags(array $tags, $limit = NULL, $offset = NULL)
	{
		$qb = $this->createQueryBuilder($this->alias);
		
		return $this->getPaginated($qb, $limit, $offset);
	}
	
	/**
	 * @param string
	 * @param int
	 * @param int
	 * @return Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function findByUser($username, $limit = NULL, $offset = NULL)
	{
		$qb = $this->createQueryBuilder($this->alias)
			->join($this->userEntity, $this->userAlias)
			->where($qb->expr()->eq($this->userAlias . '.username', $username))
			->orderBy($this->alias . '.published', 'DESC');
		
		return $this->getPaginated($qb, $limit, $offset);
	}
	
	/**
	 * @param int
	 * @param int
	 * @return Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function findRecently($limit = NULL, $offset = NULL)
	{
		$qb = $this->createQueryBuilder($this->alias)
			->orderBy($this->alias . '.published', 'DESC');
		
		return $this->getPaginated($qb, $limit, $offset);
	}
}