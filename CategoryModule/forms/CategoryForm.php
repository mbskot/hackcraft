<?php
namespace CategoryModule\Forms;

use Forms\EntityForm,
	Models\Category\CategoryModel,
	Models\Tag\TagModel,
	Nette\Application\UI\Form;

class CategoryForm extends EntityForm
{
	/** @var Models\Tag\TagModel */
	private $tagModel;
	
	
	/**
	 * @param Models\Category\CategoryModel
	 * @param Models\Tag\TagModel
	 * @return CategoryModule\Forms\CategoryForm
	 */
	public function __construct(CategoryModel $categoryModel, TagModel $tagModel)
	{
		parent::__construct($categoryModel);
		
		$this->tagModel = $tagModel;
		
		$this->addText('name', 'Názov', 32, 255)
			->setRequired('Povinné pole nesmie zostať prázdne!');
		$this->addText('slug', 'URL', 32, 255)
			->setRequired('Povinné pole nesmie zostať prázdne!');
		$this->addEntityMultiSelect('tags', 'Kľúčové slová', $this->tagModel->findAll());
		$this->addSubmit('save', 'Uložiť');
		
		$this->onSuccess[] = callback($this, 'handleForm');
	}
	
	public function handleForm()
	{
		try
		{
			$this->handleEntity((array)$this->values);
			
			$this->presenter->flashMessage('Kategória bola uložená.');
			$this->presenter->redirect('Category:', $this->entity->slug);
		}
		catch(\PDOException $e)
		{
			$this['slug']->addError('Kategória s rovnakou URL už existuje!');
			$this['slug']->setValue($this->values->slug . '2');
		}
	}
}