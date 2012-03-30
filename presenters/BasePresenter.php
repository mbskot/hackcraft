<?php

use Nette\Application\UI\Presenter;

/**
 * @author mbskot
 */
abstract class BasePresenter extends Presenter
{
	public function getModels()
	{
		return $this->context->models;
	}
	
	protected function beforeRender()
	{
		$this->template->page = $this->context->parameters['page'];
		$this->template->categories = $this->models->categories->findAll();
		
		$this->template->viewName = $this->view;
		$this->template->root = dirname(realpath(APP_DIR));

		$a = strrpos($this->name, ':');
		
		if ($a === FALSE)
		{
			$this->template->moduleName = '';
			$this->template->presenterName = $this->name;
		}
		else
		{
			$this->template->moduleName = substr($this->name, 0, $a + 1);
			$this->template->presenterName = substr($this->name, $a + 1);
		}
	}
}
