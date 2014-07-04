<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DomainsProducts
 *
 * @ORM\Table(name="domains_products", indexes={@ORM\Index(name="IDX_2E6B2E2A52E616ED", columns={"id_domains"}), @ORM\Index(name="IDX_2E6B2E2AE361B6CF", columns={"id_products"})})
 * @ORM\Entity
 */
class DomainsProducts
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
     * @var \Application\Entity\Domains
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains", referencedColumnName="id")
     * })
     */
    private $idDomains;

    /**
     * @var \Application\Entity\Products
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_products", referencedColumnName="id")
     * })
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
    /**
     * @var string
     */
    private $status;


    /**
     * Set status
     *
     * @param string $status
     * @return DomainsProducts
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
