<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Comment
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * 
 * @ORM\Entity
 */
class Comment
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Comment", inversedBy="responses")
	 * @ORM\JoinColumn(name="parent_comment_id", referencedColumnName="id")
	 */
	protected $parentComment;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="parentComment", cascade={"all"})
	 */
	protected $responses;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $user;

	/** 
	 * @ORM\Column(type="datetime") 
	 */
	private $creationDate;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $title;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $message;

	/**
	 * Returns id
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Returns parent comment
	 * @return Comment
	 */
	public function getParentComment(): Comment
	{
		return $this->parentComment;
	}

	/**
	 * Sets parent comment
	 * @param Comment $parentComment
	 * @return void
	 */
	public function setParentComment(Comment $parentComment)
	{
		$this->parentComment = $parentComment;
	}

	/**
	 * Returns responses
	 * @return array
	 */
	public function getResponses()
	{
		if (!isset($this->responses)) {
			return [];
		}

		return $this->responses;
	}

	/**
	 * Adds response to responses
	 * @param Comment $response
	 * @return void
	 */
	public function addResponse(Comment $response)
	{
		$this->responses[] = $response;
		$response->setParentComment($this);
	}

	/**
	 * Returns user
	 * @return User
	 */
	public function getUser(): User
	{
		return $this->user;
	}

	/**
	 * Sets user
	 * @param User $user
	 * @return void
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Returns creation date
	 * @return \DateTime
	 */
	public function getCreationDate(): \DateTime
	{
		return $this->creationDate;
	}

	/**
	 * Sets creation date
	 * @param \DateTime $creationDate
	 * @return void
	 */
	public function setCreationDate(\DateTime $creationDate)
	{
		$this->creationDate = $creationDate;
	}

	/**
	 * Returns title
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * Sets title
	 * @param string $title
	 * @return void
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	/**
	 * Returns message
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * Sets message
	 * @param string $message
	 * @return void
	 */
	public function setMessage(string $message)
	{
		$this->message = $message;
	}

}
