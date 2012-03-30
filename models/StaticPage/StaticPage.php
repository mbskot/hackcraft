<?php
namespace Models\StaticPage;

use Doctrine\ORM\Mapping as ORM,
	Models\Text\Text;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * 
 * @property string $slug
 */
class StaticPage extends Text
{
	/**
	 * @ORM\Column(unique=true)
	 * @var string
	 */
	private $slug;
	
	
	/**
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}
	
	/**
	 * @param string
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;
	}
}