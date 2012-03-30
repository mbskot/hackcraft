<?php
namespace Models\Category;

use Doctrine\Common\Collections\ArrayCollection,
	Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity,
	Models\Article\Article,
	Models\Tag\Tag,
	Models\Tag\ITagable,
	Nette\Utils\Strings;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\Category\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property int $ordering
 * @property Doctrine\Common\Collections\ArrayCollection $articles
 * @property Doctrine\Common\Collections\ArrayCollection $tags
 */
class Category extends BaseEntity implements ITagable
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
	 * @ORM\Column(unique=true)
	 * @var string
	 */
	private $slug;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $ordering;
	/**
     * @ORM\OneToMany(targetEntity="Models\Article\Article", mappedBy="category", fetch="EXTRA_LAZY")
	 * @ORM\OrderBy({"published" = "DESC"})
	 * @var Doctrine\Common\Collections\ArrayCollection
     */
	private $articles;
	/**
     * @ORM\ManyToMany(targetEntity="Models\Tag\Tag")
	 * @var Doctrine\Common\Collections\ArrayCollection
     */
	private $tags;
	
	
	/**
	 * @param array
	 * @return Models\Category\Category
	 */
	public function __construct(array $values = array())
	{
		$this->ordering = 0;
		$this->articles = new ArrayCollection();
		$this->tags = new ArrayCollection();
		
		parent::__construct($values);
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
	public function getSlug()
	{
		return $this->slug;
	}
	
	/**
	 * @param string
	 */
	public function setSlug($slug)
	{
		$this->slug = Strings::webalize($slug);
	}
	
	/**
	 * @return int
	 */
	public function getOrdering()
	{
		return $this->ordering;
	}
	
	/**
	 * @ORM\PrePersist
	 * @param int
	 */
	public function setOrdering($ordering = 0)
	{
		$this->ordering = $ordering == 0 ? time() : $ordering;
	}
	
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getArticles()
	{
		return $this->articles;
	}
	
	/**
	 * @param Models\Article\Article
	 */
	public function addArticle(Article $article)
	{
		$this->articles->add($article);
	}
	
	/**
	 * @param Models\Article\Article
	 */
	public function removeArticle(Article $article)
	{
		$this->articles->removeElement($article);
	}
	
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getTags()
	{
		return $this->tags;
	}
	
	/**
	 * @param array
	 */
	public function setTags(array $tags)
	{
		$this->tags->clear();
		
		foreach($tags as $tag)
		{
			$this->tags->add($tag);
		}
	}
}