<?php
namespace HomepageModule;

use Components\Article\ArticleControl,
	Nette\Application\UI\Multiplier;

class FrontendPresenter extends \BasePresenter
{
	/** @var Models\Article\ArticleModel */
	private $articleModel;
	
	public function startup()
	{
		parent::startup();
		$this->articleModel = $this->models->articles;
	}
	
	public function renderDefault()
	{
		$paginator = $this['paginator']->paginator;
		
		$articles = $this->articleModel->findRecently($paginator->itemsPerPage, $paginator->offset);
		$paginator->itemCount = $articles->count();
		
		$this->template->articles = $articles;
	}
	
	/**
	 * @return Components\Article\ArticleControl
	 */
	public function createComponentArticle($name)
	{
		$articleModel = $this->articleModel;
		
		return new Multiplier(function($name) use ($articleModel) {
			return new ArticleControl($articleModel, $articleModel->find($name));
		});
	}
	
	/**
	 * @param string
	 * @return \VisualPaginator
	 */
	public function createComponentPaginator($name)
	{
		$paginator = new \VisualPaginator($this, $name);
		$paginator->paginator->itemsPerPage = 10;
		
		return $paginator;
	}
}