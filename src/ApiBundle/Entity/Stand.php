<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stand
 *
 * @ORM\Table(name="Stand", indexes={@ORM\Index(name="fk_Stand_FloorMap1_idx", columns={"idFloorMap"})})
 * @ORM\Entity
 */
class Stand {
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
	 * @var integer @ORM\Column(name="posX", type="integer", nullable=true)
	 */
	private $posx;
	/**
	 *
	 * @var integer @ORM\Column(name="posY", type="integer", nullable=true)
	 */
	private $posy;
	/**
	 *
	 * @var integer @ORM\Column(name="height", type="integer", nullable=true)
	 */
	private $height;
	/**
	 *
	 * @var integer @ORM\Column(name="width", type="integer", nullable=true)
	 */
	private $width;
	/**
	 *
	 * @var integer @ORM\Column(name="timeSlot", type="integer", nullable=true)
	 */
	private $timeslot;
	/**
	 *
	 * @var float @ORM\Column(name="priceSlot", type="float", precision=8, scale=3, nullable=true)
	 */
	private $priceslot;
	/**
	 *
	 * @var string @ORM\Column(name="timeSlotUnit", type="string", length=10, nullable=true)
	 */
	private $timeslotunit;
	/**
	 *
	 * @var string @ORM\Column(name="picPath", type="string", length=255, nullable=true)
	 */
	private $picpath;
	/**
	 *
	 * @var \Floormap @ORM\ManyToOne(targetEntity="Floormap")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idFloorMap", referencedColumnName="id")
	 *      })
	 */
	private $idfloormap;

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
	 * @return Stand
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
	 * Set posx
	 *
	 * @param integer $posx        	
	 * @return Stand
	 */
	public function setPosx($posx) {
		$this->posx = $posx;
		return $this;
	}

	/**
	 * Get posx
	 *
	 * @return integer
	 */
	public function getPosx() {
		return $this->posx;
	}

	/**
	 * Set posy
	 *
	 * @param integer $posy        	
	 * @return Stand
	 */
	public function setPosy($posy) {
		$this->posy = $posy;
		return $this;
	}

	/**
	 * Get posy
	 *
	 * @return integer
	 */
	public function getPosy() {
		return $this->posy;
	}

	/**
	 * Set height
	 *
	 * @param integer $height        	
	 * @return Stand
	 */
	public function setHeight($height) {
		$this->height = $height;
		return $this;
	}

	/**
	 * Get height
	 *
	 * @return integer
	 */
	public function getHeight() {
		return $this->height;
	}

	/**
	 * Set width
	 *
	 * @param integer $width        	
	 * @return Stand
	 */
	public function setWidth($width) {
		$this->width = $width;
		return $this;
	}

	/**
	 * Get width
	 *
	 * @return integer
	 */
	public function getWidth() {
		return $this->width;
	}

	/**
	 * Set timeslot
	 *
	 * @param integer $timeslot        	
	 * @return Stand
	 */
	public function setTimeslot($timeslot) {
		$this->timeslot = $timeslot;
		return $this;
	}

	/**
	 * Get timeslot
	 *
	 * @return integer
	 */
	public function getTimeslot() {
		return $this->timeslot;
	}

	/**
	 * Set priceslot
	 *
	 * @param float $priceslot        	
	 * @return Stand
	 */
	public function setPriceslot($priceslot) {
		$this->priceslot = $priceslot;
		return $this;
	}

	/**
	 * Get priceslot
	 *
	 * @return float
	 */
	public function getPriceslot() {
		return $this->priceslot;
	}

	/**
	 * Set timeslotunit
	 *
	 * @param string $timeslotunit        	
	 * @return Stand
	 */
	public function setTimeslotunit($timeslotunit) {
		$this->timeslotunit = $timeslotunit;
		return $this;
	}

	/**
	 * Get timeslotunit
	 *
	 * @return string
	 */
	public function getTimeslotunit() {
		return $this->timeslotunit;
	}

	/**
	 * Set picpath
	 *
	 * @param string $picpath        	
	 * @return Stand
	 */
	public function setPicpath($picpath) {
		$this->picpath = $picpath;
		return $this;
	}

	/**
	 * Get picpath
	 *
	 * @return string
	 */
	public function getPicpath() {
		return $this->picpath;
	}

	/**
	 * Set idfloormap
	 *
	 * @param \ApiBundle\Entity\Floormap $idfloormap        	
	 * @return Stand
	 */
	public function setIdfloormap(\ApiBundle\Entity\Floormap $idfloormap = null) {
		$this->idfloormap = $idfloormap;
		return $this;
	}

	/**
	 * Get idfloormap
	 *
	 * @return \ApiBundle\Entity\Floormap
	 */
	public function getIdfloormap() {
		return $this->idfloormap;
	}
}
