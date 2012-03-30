<?php
namespace Forms;

use	Models\Comment\CommentModel,
	Models\Comment\ICommentable,
	Nette\Application\UI\Form;

class CommentForm extends EntityForm
{	
	/** @var Models\Comment\ICommentable */
	private $commentableEntity;
	
	/**
	 * @var Models\Comment\CommentModel
	 * @return Forms\CommentForm
	 */
	public function __construct(CommentModel $commentModel, ICommentable $commentableEntity)
	{
		parent::__construct($commentModel);
		
		$this->commentableEntity = $commentableEntity;
		
		$this->addText('username', 'Meno', 24, 48)
			->addRule(Form::FILLED, 'Zadajte Vaše meno!');
		$this->addText('email', 'Email', 24, 48)
			->addRule(Form::FILLED, 'Zadajte Vášu emailovú adresu!')
			->addRule(Form::EMAIL, 'Zadaná emailová adresa má nesprávny tvar!');
		$this->addTextArea('content', 'Komentár', 48, 5)
			->addRule(Form::FILLED, 'Váš komentár neobsahuje žiadny text!');
		$this->addSubmit('send', 'Pridať komentár');
		
		$this->onSuccess[] = callback($this, 'handleForm');
	}
	
	public function handleForm()
	{
		$this->entity = $this->entityModel->create((array)$this->values);
		$this->commentableEntity->addComment($this->entity);
		$this->entityModel->save($this->entity);
		
		$this->presenter->flashMessage('Ďakujeme, Váš komentár bol pridaný.', 'success');
		$this->presenter->redirect('this');
	}
}