<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Views
 */
class Views
{
    /**
     * @var integer
     */
    private $idViews;

    /**
     * @var boolean
     */
    private $isDefault;

    /**
     * @var \Application\Entity\Domains
     */
    private $domains;

    /**
     * @var \Application\Entity\Products
     */
    private $idProducts;


    /**
     * Get idViews
     *
     * @return integer 
     */
    public function getIdViews()
    {
        return $this->idViews;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Views
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean 
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set domains
     *
     * @param \Application\Entity\Domains $domains
     * @return Views
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
     * Set idProducts
     *
     * @param \Application\Entity\Products $idProducts
     * @return Views
     */
    public function setIdProducts(\Application\Entity\Products $idProducts = null)
    {
        $this->idProducts = $idProducts;

        return $this;
    }

    /**
     * Get idProducts
     *
     * @return \Application\Entity\Products 
     */
    public function getIdProducts()
    {
        return $this->idProducts;
    }
}
