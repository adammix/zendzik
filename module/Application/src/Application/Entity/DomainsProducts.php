<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainsProducts
 */
class DomainsProducts
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Entity\Domains
     */
    private $idDomains;

    /**
     * @var \Application\Entity\Products
     */
    private $idProducts;


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
     * Set idDomains
     *
     * @param \Application\Entity\Domains $idDomains
     * @return DomainsProducts
     */
    public function setIdDomains(\Application\Entity\Domains $idDomains = null)
    {
        $this->idDomains = $idDomains;

        return $this;
    }

    /**
     * Get idDomains
     *
     * @return \Application\Entity\Domains 
     */
    public function getIdDomains()
    {
        return $this->idDomains;
    }

    /**
     * Set idProducts
     *
     * @param \Application\Entity\Products $idProducts
     * @return DomainsProducts
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
