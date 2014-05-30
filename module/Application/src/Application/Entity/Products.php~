<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="fk_products_product_types1_idx", columns={"id_product_types"})})
 * @ORM\Entity
 */
class Products
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
     * @var \Application\Entity\ProductTypes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ProductTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product_types", referencedColumnName="id_product_types")
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
