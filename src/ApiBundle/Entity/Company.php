<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="Company")
 * @ORM\Entity
 */
class Company {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 *
	 * @var string @ORM\Column(name="name", type="string", length=45, nullable=true)
	 */
	private $name;
	/**
	 *
	 * @var string @ORM\Column(name="logoPath", type="string", length=255, nullable=true)
	 */
	private $logopath;
	/**
	 *
	 * @var string @ORM\Column(name="hash", type="string", length=45, nullable=true)
	 */
	private $hash;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 *
	 * @param string $name        	
	 * @return Company
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set logopath
	 *
	 * @param string $logopath        	
	 * @return Company
	 */
	public function setLogopath($logopath) {
		$this->logopath = $logopath;
		return $this;
	}

	/**
	 * Get logopath
	 *
	 * @return string
	 */
	public function getLogopath() {
		return $this->logopath;
	}

	/**
	 * Set hash
	 *
	 * @param string $hash        	
	 * @return Company
	 */
	public function setHash($hash) {
		$this->hash = $hash;
		return $this;
	}

	/**
	 * Get hash
	 *
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 *
	 * @param json $json        	
	 * @return \ApiBundle\Entity\Company
	 */
	static public function fromJsonValue($json) {
		if ($objCompany = json_decode($json)) {
			$me = new self();
			if (!empty($objCompany->name)) $me->setName($objCompany->name);
			if (!empty($objCompany->logoPath)) $me->setLogopath($objCompany->logoPath);
			if (!empty($me->getName())) $me->setHash(md5($me->getName() . date('YmdHis')));
			return $me;
		}
		return false;
	}
}
