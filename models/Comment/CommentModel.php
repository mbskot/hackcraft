<?php
namespace Models\Comment;

use Doctrine\ORM\EntityManager,
	Models\BaseEntity,
	Models\BaseModel;

class CommentModel extends BaseModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\Comment\CommentModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\Comment');
	}
	
	/**
	 * @param Models\BaseEntity
	 * @param Models\Comment\ICommentable
	 * @throws \InvalidArgumentException
	 */
	public function save(BaseEntity $comment, ICommentable $entity = NULL)
	{
		if(!$comment instanceof Comment)
		{
			throw new \InvalidArgumentException('Comment must be instance of Models\Comment\Comment!');
		}
		
		if($entity != NULL)
		{
			$entity->addComment($comment);
		}
		
		return parent::save($comment);
	}
	
	/**
	 * @param Models\BaseEntity
	 * @param Models\Comment\ICommentable
	 * @throws \InvalidArgumentException
	 */
	public function delete(BaseEntity $comment, ICommentable $entity = NULL)
	{
		if(!$comment instanceof Comment)
		{
			throw new \InvalidArgumentException('Comment must be instance of Models\Comment\Comment!');
		}
		
		if($entity != NULL)
		{
			if(!$entity->comments->contains($comment))
			{
				return FALSE;
			}
			
			$entity->removeComment($comment);
		}
		
		return parent::delete($comment);
	}
}