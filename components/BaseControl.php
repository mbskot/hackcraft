<?php
namespace Components;

use Nette\MemberAccessException,
	Nette\Application\UI\Control;

abstract class BaseControl extends Control
{
	public function getContext()
	{
		return $this->presenter->context;
	}
	
	public function getUser()
	{
		return $this->presenter->user;
	}
	
	public function getModels()
	{
		return $this->presenter->models;
	}
}