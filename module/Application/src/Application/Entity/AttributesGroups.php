<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributesGroups
 *
 * @ORM\Table(name="attributes_groups", indexes={@ORM\Index(name="fk_attributes_groups_product_types1_idx", columns={"id_product_types"}), @ORM\Index(name="fk_attributes_groups_attributes1_idx", columns={"id_attributes"})})
 * @ORM\Entity
 */
class AttributesGroups
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
     * @var \Application\Entity\Attributes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Attributes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_attributes", referencedColumnName="id")
     * })
     */
    private $idAttributes;

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

    /**
     * Set idProductTypes
     *
     * @param \Application\Entity\ProductTypes $idProductTypes
     * @return AttributesGroups
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
