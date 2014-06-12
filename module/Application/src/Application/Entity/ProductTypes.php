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
     * @var boolean
     */
    private $is_category;


    /**
     * Set is_category
     *
     * @param boolean $isCategory
     * @return ProductTypes
     */
    public function setIsCategory($isCategory)
    {
        $this->is_category = $isCategory;

        return $this;
    }

    /**
     * Get is_category
     *
     * @return boolean 
     */
    public function getIsCategory()
    {
        return $this->is_category;
    }
}
