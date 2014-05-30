<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsAttributes
 *
 * @ORM\Table(name="products_attributes", indexes={@ORM\Index(name="fk_products_attributes_products1_idx", columns={"products_id"}), @ORM\Index(name="fk_products_attributes_views1_idx", columns={"views_id_views"}), @ORM\Index(name="fk_products_attributes_attributes1_idx", columns={"attributes_id"})})
 * @ORM\Entity
 */
class ProductsAttributes
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
     * @ORM\Column(name="attribute_value", type="string", length=45, nullable=true)
     */
    private $attributeValue;

    /**
     * @var \Application\Entity\Attributes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Attributes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="attributes_id", referencedColumnName="id")
     * })
     */
    private $attributes;

    /**
     * @var \Application\Entity\Products
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="products_id", referencedColumnName="id")
     * })
     */
    private $products;

    /**
     * @var \Application\Entity\Views
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Views")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="views_id_views", referencedColumnName="id_views")
     * })
     */
    private $viewsViews;



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
     * Set attributeValue
     *
     * @param string $attributeValue
     * @return ProductsAttributes
     */
    public function setAttributeValue($attributeValue)
    {
        $this->attributeValue = $attributeValue;

        return $this;
    }

    /**
     * Get attributeValue
     *
     * @return string 
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * Set attributes
     *
     * @param \Application\Entity\Attributes $attributes
     * @return ProductsAttributes
     */
    public function setAttributes(\Application\Entity\Attributes $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return \Application\Entity\Attributes 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set products
     *
     * @param \Application\Entity\Products $products
     * @return ProductsAttributes
     */
    public function setProducts(\Application\Entity\Products $products = null)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \Application\Entity\Products 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set viewsViews
     *
     * @param \Application\Entity\Views $viewsViews
     * @return ProductsAttributes
     */
    public function setViewsViews(\Application\Entity\Views $viewsViews = null)
    {
        $this->viewsViews = $viewsViews;

        return $this;
    }

    /**
     * Get viewsViews
     *
     * @return \Application\Entity\Views 
     */
    public function getViewsViews()
    {
        return $this->viewsViews;
    }
}
