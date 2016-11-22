<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="Event")
 * @ORM\Entity
 */
class Event {
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
	 * @var \DateTime @ORM\Column(name="startDate", type="datetime", nullable=true)
	 */
	private $startdate;
	/**
	 *
	 * @var \DateTime @ORM\Column(name="endDate", type="datetime", nullable=true)
	 */
	private $enddate;

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
	 * @return Event
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
	 * Set startdate
	 *
	 * @param \DateTime $startdate        	
	 * @return Event
	 */
	public function setStartdate($startdate) {
		$this->startdate = $startdate;
		return $this;
	}

	/**
	 * Get startdate
	 *
	 * @return \DateTime
	 */
	public function getStartdate() {
		return $this->startdate;
	}

	/**
	 * Set enddate
	 *
	 * @param \DateTime $enddate        	
	 * @return Event
	 */
	public function setEnddate($enddate) {
		$this->enddate = $enddate;
		return $this;
	}

	/**
	 * Get enddate
	 *
	 * @return \DateTime
	 */
	public function getEnddate() {
		return $this->enddate;
	}
}
