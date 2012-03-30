<?php
namespace Models\Article;

use Doctrine\ORM\EntityManager,
	Models\BaseEntity,
	Models\Comment\CommentModel,
	Models\Text\TextModel,
	Nette\Http\FileUpload;

class ArticleModel extends TextModel
{
	/** @var Models\Comment\CommentModel */
	private $commentModel;
	
	
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @param Models\Comment\CommentModel
	 * @return Models\Article\ArticleModel
	 */
	public function __construct(EntityManager $entityManager, CommentModel $commentModel)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\Article');
		
		$this->commentModel = $commentModel;
	}
	
	/**
	 * @param Models\BaseEntity
	 */
	public function delete(BaseEntity $article)
	{
		if(!$article instanceof Article)
		{
			throw new \InvalidArgumentException('Article must be instance of Models\Article\Article!');
		}
		
		foreach($article->comments as $comment)
		{
			$this->commentModel->delete($comment, $article);
		}
		
		parent::delete($article);
	}
}