<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity
 */
class Categories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="parentId", type="integer", nullable=false)
     */
    private $parentId;
	
	/**
     * @var \Application\Entity\ProductTypes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ProductTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProductTypes", referencedColumnName="id")
     * })
     */
    private $idProductTypes;
	



    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Categories
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Categories
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set idProductTypes
     *
     * @param \Application\Entity\ProductTypes $idProductTypes
     * @return Categories
     */
    public function setIdProductTypes(\Application\Entity\ProductTypes $idProductTypes = null)
    {
        $this->idProductTypes = $idProductTypes;

        return $this;
    }

    /**
     * Get idProductTypes
     *
     * @return \Application\Entity\ProductTypes 
     */
    public function getIdProductTypes()
    {
        return $this->idProductTypes;
    }
}
