<?php
namespace Models\StaticPage;

use Doctrine\ORM\EntityManager,
	Models\Text\TextModel;

class StaticPageModel extends TextModel
{
	/**
	 * @param Doctrine\ORM\EntityManager
	 * @return Models\StaticPage\StaticPageModel
	 */
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager, __NAMESPACE__ . '\StaticPage');
	}
}