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
     * @var boolean
     *
     * @ORM\Column(name="is_category", type="boolean", nullable=true)
     */
    private $isCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="domains", type="string", length=100, nullable=true)
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
