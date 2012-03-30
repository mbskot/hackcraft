<?php
namespace UserModule;

use Components\Article\ArticleControl,
	Nette\Application\BadRequestException,
	Nette\Application\UI\Multiplier;

class FrontendPresenter extends BasePresenter
{
	/** @var Models\User\User */
	private $userEntity;
	/** @var Models\User\UserModel */
	private $userModel;
	
	public function startup()
	{
		parent::startup();
		
		$this->userModel = $this->models->users;
		
		if($this->getParam('username') != NULL)
		{
			$this->userEntity = $this->userModel->findOneByUsername($this->getParam('username'));
			
			if(!$this->userEntity)
			{
				throw new BadRequestException('Užívateľ sa nenašiel!', 404);
			}
		}
	}
	
	/**
	 * @param string
	 */
	public function renderDefault($username)
	{
		$paginator = $this['paginator']->paginator;
		$paginator->itemCount = $this->userEntity->articles->count();
		
		$this->template->articles = $this->userEntity->articles->slice($paginator->offset, $paginator->itemsPerPage);	
		$this->template->userEntity = $this->userEntity;
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
		
		return $paginator;
	}
}