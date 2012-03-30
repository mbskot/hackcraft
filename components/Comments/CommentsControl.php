<?php
namespace Components\Comments;

use Forms\CommentForm,
	Components\BaseControl,
	Models\Comment\CommentModel,
	Models\Comment\ICommentable,
	Nette\Application\BadRequestException;

class CommentsControl extends BaseControl
{
	/** @var Models\Comment\CommentModel */
	private $commentModel;
	/** @var Models\Comment\ICommentable */
	private $entity;
	
	
	/**
	 * @param Models\Comment\CommentModel
	 * @param Models\Comment\ICommentable
	 * @return Components\Comments\CommentsControl
	 */
	public function __construct(CommentModel $commentModel, ICommentable $entity)
	{
		parent::__construct();
		
		$this->commentModel = $commentModel;
		$this->entity = $entity;
	}
	
	public function render()
	{
		$this->template->comments = $this->entity->comments;
		$this->template->setFile(__DIR__ . '/CommentsControl.phtml');
		$this->template->render();
	}
	
	/**
	 * @param int
	 */
	public function handleDelete($commentId)
	{
		$comment = $this->commentModel->find($commentId);
		
		if(!$comment )//|| !$this->commentModel->delete($comment, $this->entity))
		{
			throw new BadRequestException('Požadovaný komentár sa nenašiel!', '404');
		}
		
		$this->presenter->flashMessage('Komentár bol zmazaný.', 'success');
		
		if($this->presenter->isAjax())
		{
			$this->presenter->invalidateControl();
		}
		else
		{
			$this->redirect('this');
		}
	}
	
	/**
	 * @return Forms\CommentForm
	 */
	public function createComponentCommentForm()
	{
		return new CommentForm($this->commentModel, $this->entity);
	}
}