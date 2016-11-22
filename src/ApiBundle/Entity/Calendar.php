<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendar
 *
 * @ORM\Table(name="Calendar", indexes={@ORM\Index(name="fk_Calendar_FloorMap1_idx", columns={"idFloorMap"}), @ORM\Index(name="fk_Calendar_Event1_idx", columns={"idEvent"})})
 * @ORM\Entity
 */
class Calendar {
	/**
	 *
	 * @var integer @ORM\Column(name="id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 *
	 * @var integer @ORM\Column(name="year", type="integer", nullable=true)
	 */
	private $year;
	/**
	 *
	 * @var integer @ORM\Column(name="monthOfTheYear", type="integer", nullable=true)
	 */
	private $monthoftheyear;
	/**
	 *
	 * @var integer @ORM\Column(name="dayOfTheMonth", type="integer", nullable=true)
	 */
	private $dayofthemonth;
	/**
	 *
	 * @var integer @ORM\Column(name="hour", type="integer", nullable=true)
	 */
	private $hour;
	/**
	 *
	 * @var integer @ORM\Column(name="duration", type="integer", nullable=true)
	 */
	private $duration;
	/**
	 *
	 * @var string @ORM\Column(name="durationUnit", type="string", length=10, nullable=true)
	 */
	private $durationunit;
	/**
	 *
	 * @var \Event @ORM\ManyToOne(targetEntity="Event")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="idEvent", referencedColumnName="id")
	 *      })
	 */
	private $idevent;
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
	 * Set year
	 *
	 * @param integer $year        	
	 * @return Calendar
	 */
	public function setYear($year) {
		$this->year = $year;
		return $this;
	}

	/**
	 * Get year
	 *
	 * @return integer
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * Set monthoftheyear
	 *
	 * @param integer $monthoftheyear        	
	 * @return Calendar
	 */
	public function setMonthoftheyear($monthoftheyear) {
		$this->monthoftheyear = $monthoftheyear;
		return $this;
	}

	/**
	 * Get monthoftheyear
	 *
	 * @return integer
	 */
	public function getMonthoftheyear() {
		return $this->monthoftheyear;
	}

	/**
	 * Set dayofthemonth
	 *
	 * @param integer $dayofthemonth        	
	 * @return Calendar
	 */
	public function setDayofthemonth($dayofthemonth) {
		$this->dayofthemonth = $dayofthemonth;
		return $this;
	}

	/**
	 * Get dayofthemonth
	 *
	 * @return integer
	 */
	public function getDayofthemonth() {
		return $this->dayofthemonth;
	}

	/**
	 * Set hour
	 *
	 * @param integer $hour        	
	 * @return Calendar
	 */
	public function setHour($hour) {
		$this->hour = $hour;
		return $this;
	}

	/**
	 * Get hour
	 *
	 * @return integer
	 */
	public function getHour() {
		return $this->hour;
	}

	/**
	 * Set duration
	 *
	 * @param integer $duration        	
	 * @return Calendar
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
		return $this;
	}

	/**
	 * Get duration
	 *
	 * @return integer
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Set durationunit
	 *
	 * @param string $durationunit        	
	 * @return Calendar
	 */
	public function setDurationunit($durationunit) {
		$this->durationunit = $durationunit;
		return $this;
	}

	/**
	 * Get durationunit
	 *
	 * @return string
	 */
	public function getDurationunit() {
		return $this->durationunit;
	}

	/**
	 * Set idevent
	 *
	 * @param \ApiBundle\Entity\Event $idevent        	
	 * @return Calendar
	 */
	public function setIdevent(\ApiBundle\Entity\Event $idevent = null) {
		$this->idevent = $idevent;
		return $this;
	}

	/**
	 * Get idevent
	 *
	 * @return \ApiBundle\Entity\Event
	 */
	public function getIdevent() {
		return $this->idevent;
	}

	/**
	 * Set idfloormap
	 *
	 * @param \ApiBundle\Entity\Floormap $idfloormap        	
	 * @return Calendar
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

	/**
	 * get the start date
	 *
	 * @return \DateTime
	 */
	public function getStartDate() {
		$date = date('Y-m-d H:i:s', strtotime($this->year . '-' . $this->monthoftheyear . '-' . $this->dayofthemonth . ' ' . $this->hour . ':00:00'));
		return new \DateTime($date);
	}

	/**
	 * get the end date
	 *
	 * @return \DateTime
	 */
	public function getEndDate() {
		$date = date('Y-m-d H:i:s', strtotime($this->year . '-' . $this->monthoftheyear . '-' . ($this->dayofthemonth + 1) . ' ' . $this->hour . ':00:00'));
		return new \DateTime($date);
	}
}
