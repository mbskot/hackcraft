<?php
namespace CategoryModule;

use Components\Article\ArticleControl,
	Nette\Application\BadRequestException,
	Nette\Application\UI\Multiplier;

class FrontendPresenter extends \BasePresenter
{
	/** @var Models\Category\CategoryModel */
	protected $categoryModel;
	/** @var Models\Category\Category */
	protected $category;
	
	
	/**
	 * @throws Nette\Application\BadRequestException
	 */
	public function startup()
	{
		parent::startup();
		
		$this->categoryModel = $this->models->categories;
		
		if($this->getParam('slug') !== NULL)
		{
			$this->category = $this->categoryModel->findOneBySlug($this->getParam('slug'));
			
			if(!$this->category)
			{
				throw new BadRequestException('Kategória sa nenašla!', 404);
			}
		}
	}
	
	/**
	 * @param string
	 */
	public function renderDefault($slug)
	{
		$paginator = $this['paginator']->paginator;
		
		$this->template->articles = $this->category->articles->slice($paginator->offset, $paginator->itemsPerPage);	
		$this->template->category = $this->category;
	}
	
	/**
	 * @return Components\Article\ArticleControl
	 */
	public function createComponentArticle($name)
	{
		$articleModel = $this->models->articles;
		
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
		$paginator->paginator->itemCount = $this->category->articles->count();
		
		return $paginator;
	}
}