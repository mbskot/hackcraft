<?php
namespace Models\Text;

use Doctrine\Common\Collections\ArrayCollection,
	Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity,
	Models\File\File;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"article"="Models\Article\Article", "text"="Models\StaticPage\StaticPage"})
 * 
 * @property-read int $id
 * @property string $title
 * @property string $content
 * @property Doctrine\Common\Collections\ArrayCollection $files
 */
abstract class Text extends BaseEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	private $id;
	/**
	 * @ORM\Column
	 * @var string
	 */
	private $title;
	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $content;
	/**
     * @ORM\ManyToMany(targetEntity="Models\File\File")
	 * @var Doctrine\Common\Collections\ArrayCollection
     */
	private $files;
	
	
	/**
	 * @param array
	 * @return Models\Text\Text
	 */
	public function __construct(array $values = array())
	{
		parent::__construct($values);
		$this->files = new ArrayCollection();
	}
	
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
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * @param string
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
	
	/**
	 * @param string
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}
	
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getFiles()
	{
		return $this->files;
	}
	
	/**
	 * @param Models\File\File
	 */
	public function addFile(File $file)
	{
		$this->files->add($file);
	}
	
	/**
	 * @param Models\File\File
	 */
	public function removeFile(File $file)
	{
		$this->files->removeElement($file);
	}
}