<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 */
class Products
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entity\ProductTypes
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
     * Set idProductTypes
     *
     * @param \Application\Entity\ProductTypes $idProductTypes
     * @return Products
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
