<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Floormap
 *
 * @ORM\Table(name="FloorMap", indexes={@ORM\Index(name="fk_FloorMap_Location_idx", columns={"idLocation"})})
 * @ORM\Entity
 */
class Floormap {
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
	 * @var \Location @ORM\ManyToOne(targetEntity="Location")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idLocation", referencedColumnName="id")
	 *      })
	 */
	private $idlocation;

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
	 * @return Floormap
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
	 * Set height
	 *
	 * @param integer $height        	
	 * @return Floormap
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
	 * @return Floormap
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
	 * Set idlocation
	 *
	 * @param \ApiBundle\Entity\Location $idlocation        	
	 * @return Floormap
	 */
	public function setIdlocation(\ApiBundle\Entity\Location $idlocation = null) {
		$this->idlocation = $idlocation;
		return $this;
	}

	/**
	 * Get idlocation
	 *
	 * @return \ApiBundle\Entity\Location
	 */
	public function getIdlocation() {
		return $this->idlocation;
	}
}
