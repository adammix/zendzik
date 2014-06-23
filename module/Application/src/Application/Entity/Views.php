<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Views
 *
 * @ORM\Table(name="views", indexes={@ORM\Index(name="IDX_11F09C873700F4DC", columns={"domains_id"}), @ORM\Index(name="IDX_11F09C87E361B6CF", columns={"id_products"})})
 * @ORM\Entity
 */
class Views
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_views", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idViews;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     */
    private $isDefault;

    /**
     * @var \Application\Entity\Domains
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="domains_id", referencedColumnName="id")
     * })
     */
    private $domains;

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
