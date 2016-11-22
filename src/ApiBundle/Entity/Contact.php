<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="Contact", indexes={@ORM\Index(name="fk_Contact_Company1_idx", columns={"idCompany"})})
 * @ORM\Entity
 */
class Contact {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 *
	 * @var string @ORM\Column(name="type", type="string", length=10, nullable=true)
	 */
	private $type;
	/**
	 *
	 * @var string @ORM\Column(name="title", type="string", length=45, nullable=true)
	 */
	private $title;
	/**
	 *
	 * @var string @ORM\Column(name="firstName", type="string", length=45, nullable=true)
	 */
	private $firstname;
	/**
	 *
	 * @var string @ORM\Column(name="lastName", type="string", length=45, nullable=true)
	 */
	private $lastname;
	/**
	 *
	 * @var string @ORM\Column(name="value", type="string", length=255, nullable=true)
	 */
	private $value;
	/**
	 *
	 * @var \Company @ORM\ManyToOne(targetEntity="Company")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idCompany", referencedColumnName="id")
	 *      })
	 */
	private $idcompany;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set type
	 *
	 * @param string $type        	
	 * @return Contact
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * Get type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set title
	 *
	 * @param string $type        	
	 * @return Contact
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set firstname
	 *
	 * @param string $firstname        	
	 * @return Contact
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * Get firstname
	 *
	 * @return string
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * Set lastname
	 *
	 * @param string $lastname        	
	 * @return Contact
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 * Get lastname
	 *
	 * @return string
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * Set value
	 *
	 * @param string $value        	
	 * @return Contact
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	/**
	 * Get value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Set idcompany
	 *
	 * @param \ApiBundle\Entity\Company $idcompany        	
	 * @return Contact
	 */
	public function setIdcompany(\ApiBundle\Entity\Company $idcompany = null) {
		$this->idcompany = $idcompany;
		return $this;
	}

	/**
	 * Get idcompany
	 *
	 * @return \ApiBundle\Entity\Company
	 */
	public function getIdcompany() {
		return $this->idcompany;
	}

	/**
	 *
	 * @param json $json        	
	 * @return array of \ApiBundle\Entity\Contact
	 */
	static public function fromJsonValueOfCollection($json) {
		$Contacts = [];
		if ($arrContacts = json_decode($json)) {
			foreach ($arrContacts as $objContact) {
				$me = new self();
				if (!empty($objContact->type)) $me->setType($objContact->type);
				if (!empty($objContact->title)) $me->setTitle($objContact->title);
				if (!empty($objContact->firstName)) $me->setFirstname($objContact->firstName);
				if (!empty($objContact->lastName)) $me->setLastname($objContact->lastName);
				if (!empty($objContact->value)) $me->setValue($objContact->value);
				if (!empty($objContact->idCompany)) $me->setIdcompany($objContact->idCompany);
				$Contacts[] = $me;
			}
			return $Contacts;
		}
		return false;
	}
}
