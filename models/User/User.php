<?php
namespace Models\User;

use Doctrine\ORM\Mapping as ORM,
	Models\Article\Article,
	Models\BaseEntity,
	Nette\Utils\Strings;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * 
 * @property-read int $id
 * @property-read string $username
 * @property string $email
 * @property string $password
 * @property Doctrine\Common\Collections\ArrayCollection $articles
 */
class User extends BaseEntity
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
	private $username;
	/**
	 * @ORM\Column(unique=true)
	 * @var string
	 */
	private $email;
	/**
	 * @ORM\Column(length=64)
	 * @var string
	 */
	private $password;
	/**
	 * @ORM\OneToMany(targetEntity="Models\Article\Article", mappedBy="author", fetch="EXTRA_LAZY")
	 * @ORM\OrderBy({"published" = "DESC"})
	 * @var Doctrine\Common\Collections\ArrayCollection
	 */
	private $articles;
	
	
	/**
	 * @param array
	 * @return Models\User\User
	 */
	public function __construct(array $values = array())
	{
		$this->articles = new ArrayCollection();
		
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
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * @param string
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * @param string
	 */
	public function setEmail($email)
	{
		$this->email = Strings::trim($email);
	}
	
	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * @param string
	 */
	public function setPassword($password)
	{
		$this->password = sha1(Strings::trim($password));
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
		return $this->articles->remove($article);
	}
}
