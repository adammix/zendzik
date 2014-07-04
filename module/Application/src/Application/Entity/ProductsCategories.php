<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsCategories
 */
class ProductsCategories
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entity\Domains
     */
    private $domains;

    /**
     * @var \Application\Entity\Products
     */
    private $products;

    /**
     * @var \Application\Entity\Categories
     */
    private $categories;


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
     * Set domains
     *
     * @param \Application\Entity\Domains $domains
     * @return ProductsCategories
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

    /**
     * Set products
     *
     * @param \Application\Entity\Products $products
     * @return ProductsCategories
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
     * Set categories
     *
     * @param \Application\Entity\Categories $categories
     * @return ProductsCategories
     */
    public function setCategories(\Application\Entity\Categories $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \Application\Entity\Categories 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
