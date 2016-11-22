<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="Location")
 * @ORM\Entity
 */
class Location {
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
	 * @var string @ORM\Column(name="country", type="string", length=45, nullable=true)
	 */
	private $country;
	/**
	 *
	 * @var string @ORM\Column(name="state", type="string", length=45, nullable=true)
	 */
	private $state;
	/**
	 *
	 * @var string @ORM\Column(name="city", type="string", length=45, nullable=true)
	 */
	private $city;
	/**
	 *
	 * @var string @ORM\Column(name="zipCode", type="string", length=20, nullable=true)
	 */
	private $zipcode;
	/**
	 *
	 * @var float @ORM\Column(name="latitude", type="float", precision=10, scale=6, nullable=true)
	 */
	private $latitude;
	/**
	 *
	 * @var float @ORM\Column(name="longitude", type="float", precision=10, scale=6, nullable=true)
	 */
	private $longitude;
	/**
	 *
	 * @var string @ORM\Column(name="address", type="string", length=255, nullable=true)
	 */
	private $address;

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
	 * @return Location
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
	 * Set country
	 *
	 * @param string $country        	
	 * @return Location
	 */
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}

	/**
	 * Get country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Set state
	 *
	 * @param string $state        	
	 * @return Location
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * Get state
	 *
	 * @return string
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Set city
	 *
	 * @param string $city        	
	 * @return Location
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}

	/**
	 * Get city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Set zipcode
	 *
	 * @param string $zipcode        	
	 * @return Location
	 */
	public function setZipcode($zipcode) {
		$this->zipcode = $zipcode;
		return $this;
	}

	/**
	 * Get zipcode
	 *
	 * @return string
	 */
	public function getZipcode() {
		return $this->zipcode;
	}

	/**
	 * Set latitude
	 *
	 * @param float $latitude        	
	 * @return Location
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
		return $this;
	}

	/**
	 * Get latitude
	 *
	 * @return float
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Set longitude
	 *
	 * @param float $longitude        	
	 * @return Location
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
		return $this;
	}

	/**
	 * Get longitude
	 *
	 * @return float
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Set address
	 *
	 * @param string $address        	
	 * @return Location
	 */
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}

	/**
	 * Get address
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}
}
