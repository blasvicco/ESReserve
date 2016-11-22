<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visitor
 *
 * @ORM\Table(name="Visitor", indexes={@ORM\Index(name="fk_Visitors_Company1_idx", columns={"idCompany"}), @ORM\Index(name="fk_Visitors_Contact1_idx", columns={"idContact"})})
 * @ORM\Entity
 */
class Visitor {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 *
	 * @var string @ORM\Column(name="birthDate", type="string", length=45, nullable=true)
	 */
	private $birthdate;
	/**
	 *
	 * @var string @ORM\Column(name="occupation", type="string", length=45, nullable=true)
	 */
	private $occupation;
	/**
	 *
	 * @var string @ORM\Column(name="interest", type="string", length=45, nullable=true)
	 */
	private $interest;
	/**
	 *
	 * @var string @ORM\Column(name="comment", type="string", length=45, nullable=true)
	 */
	private $comment;
	/**
	 *
	 * @var \Company @ORM\ManyToOne(targetEntity="Company")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idCompany", referencedColumnName="id")
	 *      })
	 */
	private $idcompany;
	/**
	 *
	 * @var \Contact @ORM\ManyToOne(targetEntity="Contact")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idContact", referencedColumnName="id")
	 *      })
	 */
	private $idcontact;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set birthdate
	 *
	 * @param string $birthdate        	
	 * @return Visitor
	 */
	public function setBirthdate($birthdate) {
		$this->birthdate = $birthdate;
		return $this;
	}

	/**
	 * Get birthdate
	 *
	 * @return string
	 */
	public function getBirthdate() {
		return $this->birthdate;
	}

	/**
	 * Set occupation
	 *
	 * @param string $occupation        	
	 * @return Visitor
	 */
	public function setOccupation($occupation) {
		$this->occupation = $occupation;
		return $this;
	}

	/**
	 * Get occupation
	 *
	 * @return string
	 */
	public function getOccupation() {
		return $this->occupation;
	}

	/**
	 * Set interest
	 *
	 * @param string $interest        	
	 * @return Visitor
	 */
	public function setInterest($interest) {
		$this->interest = $interest;
		return $this;
	}

	/**
	 * Get interest
	 *
	 * @return string
	 */
	public function getInterest() {
		return $this->interest;
	}

	/**
	 * Set comment
	 *
	 * @param string $comment        	
	 * @return Visitor
	 */
	public function setComment($comment) {
		$this->comment = $comment;
		return $this;
	}

	/**
	 * Get comment
	 *
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Set idcompany
	 *
	 * @param \ApiBundle\Entity\Company $idcompany        	
	 * @return Visitor
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
	 * Set idcontact
	 *
	 * @param \ApiBundle\Entity\Contact $idcontact        	
	 * @return Visitor
	 */
	public function setIdcontact(\ApiBundle\Entity\Contact $idcontact = null) {
		$this->idcontact = $idcontact;
		return $this;
	}

	/**
	 * Get idcontact
	 *
	 * @return \ApiBundle\Entity\Contact
	 */
	public function getIdcontact() {
		return $this->idcontact;
	}
}
