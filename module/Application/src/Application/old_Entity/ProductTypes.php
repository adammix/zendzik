<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTypes
 *
 * @ORM\Table(name="product_types")
 * @ORM\Entity
 */
class ProductTypes
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
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;



    /**
     * Get idProductTypes
     *
     * @return integer 
     */
    public function getIdProductTypes()
    {
        return $this->idProductTypes;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ProductTypes
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}