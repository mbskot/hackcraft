<?php
namespace ArticleModule;

use	ArticleModule\Forms\ArticleForm,
	Components\Comments\CommentsControl,
	Nette\Application\BadRequestException;

class FrontendPresenter extends \BasePresenter
{
	/** @var Models\Article\ArticleModel */
	private $articleModel;
	/** @var Models\Article\Article */
	private $article;
	
	
	/**
	 * @throws Nette\Application\BadRequestException
	 */
	public function startup()
	{
		parent::startup();
		
		$this->articleModel = $this->models->articles;
		
		if($this->getParam('slug') != NULL)
		{
			$this->article = $this->articleModel->findOneBySlug($this->getParam('slug'));
			
			if(!$this->article)
			{
				throw new BadRequestException('Článok sa nenašiel!', 404);
			}
		}
	}
	
	/**
	 * @param string
	 */
	public function renderDefault($slug)
	{
		$this->template->article = $this->article;
	}
	
	/**
	 * @return Components\Comments\CommentsControl
	 */
	public function createComponentComments()
	{
		return new CommentsControl($this->models->comments, $this->article);
	}
}