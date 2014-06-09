<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 */
class Categories
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
     * @var integer
     */
    private $parentid;

    /**
     * @var \Application\Entity\ProductTypes
     */
    private $idproducttypes;


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
     * Set parentid
     *
     * @param integer $parentid
     * @return Categories
     */
    public function setParentid($parentid)
    {
        $this->parentid = $parentid;

        return $this;
    }

    /**
     * Get parentid
     *
     * @return integer 
     */
    public function getParentid()
    {
        return $this->parentid;
    }

    /**
     * Set idproducttypes
     *
     * @param \Application\Entity\ProductTypes $idproducttypes
     * @return Categories
     */
    public function setIdproducttypes(\Application\Entity\ProductTypes $idproducttypes = null)
    {
        $this->idproducttypes = $idproducttypes;

        return $this;
    }

    /**
     * Get idproducttypes
     *
     * @return \Application\Entity\ProductTypes 
     */
    public function getIdproducttypes()
    {
        return $this->idproducttypes;
    }
}
