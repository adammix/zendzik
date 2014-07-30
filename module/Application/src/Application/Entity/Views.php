<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Views
 */
class Views
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var \Application\Entity\ProductTypes
     */
    private $idProductType;


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
     * @return Views
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Views
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Views
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set idProductType
     *
     * @param \Application\Entity\ProductTypes $idProductType
     * @return Views
     */
    public function setIdProductType(\Application\Entity\ProductTypes $idProductType = null)
    {
        $this->idProductType = $idProductType;

        return $this;
    }

    /**
     * Get idProductType
     *
     * @return \Application\Entity\ProductTypes 
     */
    public function getIdProductType()
    {
        return $this->idProductType;
    }
}
