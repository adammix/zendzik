<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;


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
     * @var \Application\Entity\Products
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="products_id", referencedColumnName="id")
     * })
     */
    private $products;

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
     * @var \Application\Entity\Domains
     */
    private $domains;


    /**
     * Set domains
     *
     * @param \Application\Entity\Domains $domains
     * @return ProductsAttributes
     */
    public function setDomains(\Application\Entity\Domains $domains = null)
    {
        $this->domains = $domains;

        return $this;
    }

    /**
     * Get domains
     *
     * @return \Application\Entity\Domains 
     */
    public function getDomains()
    {
        return $this->domains;
    }
}
