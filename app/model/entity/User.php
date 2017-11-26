<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * User
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * 
 * @ORM\Entity
 */
class User
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;

	/**
	 * Returns id
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Returns username
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->username;
	}

	/**
	 * Sets username
	 * @param string $title
	 * @return void
	 */
	public function setUsername(string $username)
	{
		$this->username = $username;
	}

	/**
	 * Returns password
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * Sets password
	 * @param string $title
	 * @return void
	 */
	public function setPassword(string $password)
	{
		$this->password = $password;
	}

}
