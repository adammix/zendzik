<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories", indexes={@ORM\Index(name="IDX_3AF3466816A2507F", columns={"idProductTypes"})})
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
     * @var integer
     *
     * @ORM\Column(name="parentId", type="integer", nullable=false)
     */
    private $parentid;

    /**
     * @var \Application\Entity\ProductTypes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ProductTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProductTypes", referencedColumnName="id")
     * })
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
