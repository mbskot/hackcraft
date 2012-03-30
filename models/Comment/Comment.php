<?php
namespace Models\Comment;

use Datetime,
	Doctrine\ORM\Mapping as ORM,
	Models\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Models\BaseRepository")
 * 
 * @property-read int $id
 * @property-read string $username
 * @property-read string $email
 * @property-read int $comment
 */
class Comment extends BaseEntity
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
	private $username;
	/**
	 * @ORM\Column
	 * @var string
	 */
	private $email;
	/**
	 * @ORM\Column
	 * @var string
	 */
	private $content;
	/**
	 * @ORM\Column(type="datetime")
	 * @var string
	 */
	private $sent;
	
	
	/**
	 * @param array
	 * @return Models\Comment\Comment
	 */
	public function __construct(array $values = array())
	{
		$this->sent = new DateTime();
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
		$this->email = $email;
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
	 * @return \DateTime
	 */
	public function getSent()
	{
		return $this->sent;
	}
	
	/**
	 * @param \DateTime
	 */
	public function setSent(\DateTime $sent)
	{
		$this->sent = $sent;
	}
}