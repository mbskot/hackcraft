<?php
namespace ArticleModule;

use	ArticleModule\Forms\ArticleForm,
	Components\Comments\CommentsControl,
	Nette\Application\BadRequestException;

class BackendPresenter extends FrontendPresenter
{
	/**
	 * @param int
	 */
	public function actionCreate($categoryId = NULL)
	{
		if($categoryId !== NULL)
		{
			$this['articleForm']['category']->setValue($categoryId);
		}
		
		$this->setView('edit');
		$this->template->title = 'Vytvorenie nového článku';
	}
	
	/**
	 * @param string
	 */
	public function actionEdit($slug)
	{
		$this['articleForm']->bindEntity($this->article);
		$this->template->title = 'Editácia článku';
	}
	
	/**
	 * @param string
	 */
	public function handleDelete($slug)
	{
		$category = $this->article->category;
		$this->articleModel->delete($this->article);
		
		$this->flashMessage('Článok bol zmazaný.', 'success');
		$this->redirect('Category:', $category->slug);
	}
	
	/**
	 * @return ArticleModule\Forms\ArticleForm
	 */
	public function createComponentArticleForm()
	{
		return new ArticleForm($this->articleModel, $this->models->categories, $this->models->tags);
	}
}