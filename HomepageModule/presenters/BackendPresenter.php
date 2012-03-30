<?php
namespace HomepageModule;

class BackendPresenter extends FrontendPresenter
{
	public function renderDefault()
	{
		parent::renderDefault();
		
		$this->template->setFile(APP_DIR . '/HomepageModule/templates/Frontend/default.phtml');
	}
}