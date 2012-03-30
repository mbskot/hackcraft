<?php
namespace Models\File;

use Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity,
	Models\FileType\FileType,
	Nette\Http\FileUpload,
	Nette\Utils\Strings;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @property-read int $id
 * @property-read Models\FileType\FileType $fileType
 * @property-read string $path
 * @property string $name
 */
class File extends BaseEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	private $id;
	/**
	 * @ORM\ManyToOne(targetEntity="Models\FileType\FileType", fetch="EAGER")
	 * @var Models\FileType\FileType
	 */
	private $fileType;
	/**
	 * @ORM\Column
	 * @var string
	 */
	private $fileName;
	/**
	 * @ORM\Column
	 * @var string
	 */
	private $name;
	/**
	 * @var Nette\Http\FileUpload
	 */
	private $file;
	
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return Models\FileType\FileType
	 */
	public function getFileType()
	{
		return $this->fileType;
	}
	
	/**
	 * @param Models\FileType\FileType
	 */
	public function setFileType(FileType $fileType)
	{
		$this->fileType = $fileType;
	}
	
	/**
	 * @return string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}
	
	/**
	 * @param string
	 */
	public function setFileName($fileName)
	{
		$this->path = Strings::webalize($fileName);
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
	
	/**
	 * @return string
	 */
	public function getPath()
	{
		return FILES_DIR . '/' . $this->id . '-' . $this->fileName;
	}
	
	/**
	 * @param Nette\Http\FileUpload
	 */
	public function setFile(FileUpload $fileUpload)
	{
		$this->file = $fileUpload;
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if($this->file != NULL)
		{
			if($this->name == NULL)
			{
				$this->name = $this->file->name;
			}

			if($this->fileName == NULL)
			{
				$this->fileName = $this->file->sanitizedName;
			}
		}
	}
	
	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function postUpload()
	{
		if($this->file != NULL)
		{
			$this->file->move($this->path);
			unset($this->file);
		}
	}
	
	/**
	 * @ORM\PostRemove()
	 */
	public function postRemove()
	{
		unlink($this->path);
	}
}