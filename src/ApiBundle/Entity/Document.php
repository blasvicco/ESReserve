<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="Document", indexes={@ORM\Index(name="fk_Document_Company1_idx", columns={"idCompany"})})
 * @ORM\Entity
 */
class Document {
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
	 * @var string @ORM\Column(name="filePath", type="string", length=255, nullable=true)
	 */
	private $filepath;
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
	 * @return Document
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
	 * Set filepath
	 *
	 * @param string $filepath        	
	 * @return Document
	 */
	public function setFilepath($filepath) {
		$this->filepath = $filepath;
		return $this;
	}

	/**
	 * Get filepath
	 *
	 * @return string
	 */
	public function getFilepath() {
		return $this->filepath;
	}

	/**
	 * Set idcompany
	 *
	 * @param \ApiBundle\Entity\Company $idcompany        	
	 * @return Document
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
	 * @return array of \ApiBundle\Entity\Document
	 */
	static public function fromJsonValueOfCollection($json) {
		$Documents = [];
		if ($arrDocuments = json_decode($json)) {
			foreach ($arrDocuments as $objDocument) {
				$me = new self();
				if (!empty($objDocument->type)) $me->setType($objDocument->type);
				if (!empty($objDocument->type)) $me->setFilepath($objDocument->filePath);
				if (!empty($objDocument->type)) $me->setIdcompany($objDocument->idCompany);
				$Documents[] = $me;
			}
			return $Documents;
		}
		return false;
	}
}
