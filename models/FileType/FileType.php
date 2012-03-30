<?php
namespace Models\FileType;

use Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * 
 * @property-read int $id
 * @property-read string $mime
 * @property-read string $extension
 */
class FileType extends BaseEntity
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
	private $mime;
	/**
	 * @ORM\Column(length=5)
	 * @var string
	 */
	private $extension;
	
	
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
	public function getMime()
	{
		return $this->mime;
	}
	
	/**
	 * @return string
	 */
	public function getExtension()
	{
		return $this->extension;
	}
	
	/**
	 * @return bool
	 */
	public function isImage()
	{
		return preg_match('/^image/', $this->mime);
	}
}