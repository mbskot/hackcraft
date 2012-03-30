<?php
namespace Components\Article;

use Components\BaseControl,
	Models\Article\Article,
	Models\Article\ArticleModel,
	Nette\ComponentModel\IContainer;

class ArticleControl extends BaseControl
{
	/** @var Models\Article\ArticleModel */
	private $articleModel;
	/**	@var Models\Article\Article */
	private $article;
	
	
	/**
	 * @var Nette\ComponentModel\IContainer
	 * @var string
	 * @return Components\Article\ArticleControl
	 */
	public function __construct(ArticleModel $articleModel, Article $article)
	{
		parent::__construct();
		
		$this->articleModel = $articleModel;
		$this->article = $article;
	}
	
	public function handleDelete()
	{
		$this->articleModel->delete($this->article);
		$this->presenter->flashMessage('Článok bol zmazaný.', 'success');
	}
	
	public function render()
	{
		$this->template->article = $this->article;
		$this->template->setFile(__DIR__ . '/ArticleControl.phtml');
		$this->template->render();
	}
}