<?php
namespace Forms;

use Models\Text\TextModel;

abstract class TextForm extends EntityForm
{
	public function __construct(TextModel $textModel)
	{
		parent::__construct($textModel);
		
		$this->addText('title', 'Titulok', 64, 255)
			->setRequired('Povinné pole nesmie zostať prázdne!');
		$this->addTextArea('content', 'Obsah')
			->setAttribute('class', 'tinymce');
	}
}