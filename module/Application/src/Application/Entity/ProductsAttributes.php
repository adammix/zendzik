<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsAttributes
 */
class ProductsAttributes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $attributeValue;

    /**
     * @var \Application\Entity\Products
     */
    private $products;

    /**
     * @var \Application\Entity\Views
     */
    private $viewsViews;

    /**
     * @var \Application\Entity\Attributes
     */
    private $attributes;


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
}
