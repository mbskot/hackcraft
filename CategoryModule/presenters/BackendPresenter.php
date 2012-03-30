<?php
namespace CategoryModule;

use CategoryModule\Forms\CategoryForm;

class BackendPresenter extends FrontendPresenter
{
	public function actionCreate()
	{
		$this->setView('edit');
		$this->template->title = 'Vytvorenie novej kategórie';
	}
	
	/**
	 * @param string
	 */
	public function actionEdit($slug)
	{
		$this['categoryForm']->bindEntity($this->category);
		$this->template->title = 'Editácia kategórie';
	}
	
	/**
	 * @param string
	 */
	public function handleDelete($slug)
	{
		$this->categoryModel->delete($this->category);
		
		$this->flashMessage('Kategória bola zmazaná.', 'success');
		$this->redirect('Homepage:');
	}
	
	/**
	 * @param string
	 * @return CategoryModule\Forms\CategoryForm
	 */
	public function createComponentCategoryForm()
	{
		return new CategoryForm($this->categoryModel, $this->models->tags);
	}
}