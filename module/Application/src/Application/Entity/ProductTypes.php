<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTypes
 */
class ProductTypes
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
     * @var boolean
     */
    private $isCategory;

    /**
     * @var string
     */
    private $domains;


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
     * Set isCategory
     *
     * @param boolean $isCategory
     * @return ProductTypes
     */
    public function setIsCategory($isCategory)
    {
        $this->isCategory = $isCategory;

        return $this;
    }

    /**
     * Get isCategory
     *
     * @return boolean 
     */
    public function getIsCategory()
    {
        return $this->isCategory;
    }

    /**
     * Set domains
     *
     * @param string $domains
     * @return ProductTypes
     */
    public function setDomains($domains)
    {
        $this->domains = $domains;

        return $this;
    }

    /**
     * Get domains
     *
     * @return string 
     */
    public function getDomains()
    {
        return $this->domains;
    }
}
