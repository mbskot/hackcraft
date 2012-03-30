<?php
namespace Models\Article;

use DateTime,
	Doctrine\Common\Collections\ArrayCollection,
	Doctrine\ORM\Mapping as ORM,
	Models\Category\Category,
	Models\Comment\Comment,
	Models\Comment\ICommentable,
	Models\Text\Text,
	Models\User\User;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\Article\ArticleRepository")
 * 
 * @property-read Models\User\User $author
 * @property Models\Category\Category $category
 * @property string $slug
 * @property DateTime $published
 * @property Doctrine\Common\Collections\ArrayCollection $comments
 */
class Article extends Text implements ICommentable
{
	/**
	 * @ORM\ManyToOne(targetEntity="Models\Category\Category", inversedBy="articles")
	 * @var Models\Category\Category
	 */
	private $category;
	/**
	 * @ORM\Column(unique=true)
	 * @var string
	 */
	private $slug;
	/**
	 * @ORM\ManyToOne(targetEntity="Models\User\User", inversedBy="articles")
	 * @ORM\JoinColumn(name="user_id")
	 * @var Models\User\User
	 */
	private $author;
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var DateTime
	 */
	private $published;
	/**
	 * @ORM\ManyToMany(targetEntity="Models\Comment\Comment", cascade="ALL", fetch="EXTRA_LAZY")
	 * @ORM\OrderBy({"sent"="ASC"})
	 * @var Doctrine\Common\Collections\ArrayCollection
	 */
	private $comments;
	
	
	/**
	 * @param array
	 * @return Models\Article\Article
	 */
	public function __construct(array $values = array())
	{
		parent::__construct($values);
		
		$this->comments = new ArrayCollection();
	}
	
	/**
	 * @return Models\Category\Category
	 */
	public function getCategory()
	{
		return $this->category;
	}
	
	/**
	 * @param Models\Category\Category
	 */
	public function setCategory(Category $category)
	{
		$this->category = $category;
		$category->addArticle($this);
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
		$this->slug = $slug;
	}
	
	/**
	 * @return Models\User\User
	 */
	public function getAuthor()
	{
		return $this->author;
	}
	
	/**
	 * @param Models\User\User
	 */
	public function setAuthor(User $author)
	{
		$author->addArticle($this);
		$this->author = $author;
	}
	
	/**
	 * @return DateTime
	 */
	public function getPublished()
	{
		return $this->published;
	}
	
	/**
	 * @param DateTime
	 */
	public function setPublished(DateTime $published)
	{
		$this->published = $published;
	}
	
	/**
	 * @return Doctrine\Common\Collections\ArrayCollection
	 */
	public function getComments()
	{
		return $this->comments;
	}
	
	/**
	 * @param Models\Comment\Comment
	 */
	public function addComment(Comment $comment)
	{
		$this->comments->add($comment);
	}
	
	/**
	 * @param Models\Comment\Comment
	 */
	public function removeComment(Comment $comment)
	{
		return $this->comments->removeElement($comment);
	}
}