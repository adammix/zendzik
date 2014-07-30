<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ViewsDomains
 */
class ViewsDomains
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $isDefault;

    /**
     * @var \Application\Entity\Domains
     */
    private $idDomains;

    /**
     * @var \Application\Entity\Views
     */
    private $idViews;


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
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return ViewsDomains
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
     * Set idDomains
     *
     * @param \Application\Entity\Domains $idDomains
     * @return ViewsDomains
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
     * Set idViews
     *
     * @param \Application\Entity\Views $idViews
     * @return ViewsDomains
     */
    public function setIdViews(\Application\Entity\Views $idViews = null)
    {
        $this->idViews = $idViews;

        return $this;
    }

    /**
     * Get idViews
     *
     * @return \Application\Entity\Views 
     */
    public function getIdViews()
    {
        return $this->idViews;
    }
}
