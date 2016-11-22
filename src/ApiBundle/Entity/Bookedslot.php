<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bookedslot
 *
 * @ORM\Table(name="BookedSlot", indexes={@ORM\Index(name="fk_BookedSlot_Company1_idx", columns={"idCompany"}), @ORM\Index(name="fk_BookedSlot_Stand1_idx", columns={"idStand"})})
 * @ORM\Entity
 */
class Bookedslot {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 *
	 * @var \DateTime @ORM\Column(name="fromTime", type="datetime", nullable=true)
	 */
	private $fromtime;
	/**
	 *
	 * @var \DateTime @ORM\Column(name="toTime", type="datetime", nullable=true)
	 */
	private $totime;
	/**
	 *
	 * @var float @ORM\Column(name="price", type="float", precision=8, scale=3, nullable=true)
	 */
	private $price;
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
	 * @var \Stand @ORM\ManyToOne(targetEntity="Stand")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idStand", referencedColumnName="id")
	 *      })
	 */
	private $idstand;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set fromtime
	 *
	 * @param \DateTime $fromtime        	
	 * @return Bookedslot
	 */
	public function setFromtime($fromtime) {
		$this->fromtime = $fromtime;
		return $this;
	}

	/**
	 * Get fromtime
	 *
	 * @return \DateTime
	 */
	public function getFromtime() {
		return $this->fromtime;
	}

	/**
	 * Set totime
	 *
	 * @param \DateTime $totime        	
	 * @return Bookedslot
	 */
	public function setTotime($totime) {
		$this->totime = $totime;
		return $this;
	}

	/**
	 * Get totime
	 *
	 * @return \DateTime
	 */
	public function getTotime() {
		return $this->totime;
	}

	/**
	 * Set price
	 *
	 * @param float $price        	
	 * @return Bookedslot
	 */
	public function setPrice($price) {
		$this->price = $price;
		return $this;
	}

	/**
	 * Get price
	 *
	 * @return float
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Set idcompany
	 *
	 * @param \ApiBundle\Entity\Company $idcompany        	
	 * @return Bookedslot
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
	 * Set idstand
	 *
	 * @param \ApiBundle\Entity\Stand $idstand        	
	 * @return Bookedslot
	 */
	public function setIdstand(\ApiBundle\Entity\Stand $idstand = null) {
		$this->idstand = $idstand;
		return $this;
	}

	/**
	 * Get idstand
	 *
	 * @return \ApiBundle\Entity\Stand
	 */
	public function getIdstand() {
		return $this->idstand;
	}
}
