<?php
namespace Forms;

use Doctrine\ORM\EntityRepository,
	Forms\Controls\DatePicker,
	Forms\Controls\EntitySelectBox,
	Forms\Controls\EntityMultiSelectBox,
	Nette\Application\UI\Form,
	Nette\Forms\Container;

/**
 * @author mbskot
 */
abstract class BaseForm extends Form
{
	/**
	 * @return Nette\DI\Container
	 */
	public function getContext()
	{
		return $this->presenter->context;
	}
	
	/**
	 * @return Nette\Security\User
	 */
	public function getUser()
	{
		return $this->presenter->user;
	}
}


Container::extensionMethod('addDatePicker', function ($_this, $name, $label, $cols = 10, $maxLength = 10) {
      return $_this[$name] = new DatePicker($label, $cols, $maxLength);
});

Container::extensionMethod('addEntitySelect', function ($_this, $name, $label = NULL, array $entities = NULL, $idKey = 'id', $nameKey = 'name') {
      return $_this[$name] = new EntitySelectBox($label, $entities, $idKey, $nameKey);
});

Container::extensionMethod('addEntityMultiSelect', function ($_this, $name, $label = NULL, array $entities = NULL, $size = NULL, $idKey = 'id', $nameKey = 'name') {
	return $_this[$name] = new EntityMultiSelectBox($label, $entities, $size, $idKey, $nameKey);
});