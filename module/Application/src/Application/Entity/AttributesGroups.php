<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributesGroups
 */
class AttributesGroups
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entity\ProductTypes
     */
    private $idProductType;

    /**
     * @var \Application\Entity\Attributes
     */
    private $idAttributes;


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
     * Set idProductType
     *
     * @param \Application\Entity\ProductTypes $idProductType
     * @return AttributesGroups
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

    /**
     * Set idAttributes
     *
     * @param \Application\Entity\Attributes $idAttributes
     * @return AttributesGroups
     */
    public function setIdAttributes(\Application\Entity\Attributes $idAttributes = null)
    {
        $this->idAttributes = $idAttributes;

        return $this;
    }

    /**
     * Get idAttributes
     *
     * @return \Application\Entity\Attributes 
     */
    public function getIdAttributes()
    {
        return $this->idAttributes;
    }
}
