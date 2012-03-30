<?php
namespace Models\Tag;

use Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * 
 * @property-read int $id
 * @property string $name
 */
class Tag extends BaseEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	private $id;
	/**
	 * @ORM\Column(unique=true)
	 * @var string
	 */
	private $name;
	
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
}