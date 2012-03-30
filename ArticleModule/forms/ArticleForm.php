<?php
namespace ArticleModule\Forms;

use Forms\TextForm,
	Models\Article\ArticleModel,
	Models\Category\CategoryModel,
	Models\Tag\TagModel,
	Nette\Application\UI\Form;

class ArticleForm extends TextForm
{
	/** @var Models\Category\CategoryModel */
	private $categoryModel;
	/** @var Models\Tag\TagModel */
	private $tagModel;
	
	
	/**
	 * @var Models\Article\ArticleModel
	 * @var Models\Category\CategoryModel
	 * @var Models\Tag\TagModel
	 * @return ArticleModule\Forms\ArticleForm
	 */
	public function __construct(ArticleModel $articleModel, CategoryModel $categoryModel, TagModel $tagModel)
	{
		parent::__construct($articleModel);
		
		$this->categoryModel = $categoryModel;
		$this->tagModel = $tagModel;
		
		$this->addEntitySelect('category', 'Kategória', $this->categoryModel->findAll());
		$this->addText('slug', 'URL', 32, 64)
			->setRequired('Povinné pole nesmie zostať prázdne!');
		$this->addDatePicker('published', 'Zverejnený')
			->setRequired('Povinné pole nesmie zostať prázdne!');
		$this->addSubmit('save', 'Ulož');
		
		$this->onSuccess[] = callback($this, 'handleForm');
	}
	
	public function handleForm()
	{
		try
		{
			if($this->entity == NULL)
			{
				$this->entity->published = new \DateTime();
				//$this->entity->author = 
			}
			
			$this->handleEntity((array)$this->values);
			
			$this->presenter->flashMessage('Článok bol uložený.');
			$this->presenter->redirect('Article:', $this->entity->slug);
		}
		catch(\PDOException $e)
		{
			$this['slug']->addError('Článok s rovnakou URL už existuje!');
			$this['slug']->setValue($this->values->slug . '2');
		}
	}
}