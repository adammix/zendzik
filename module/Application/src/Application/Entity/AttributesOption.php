<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributesOption
 */
class AttributesOption
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Application\Entity\Attributes
     */
    private $idAttributes;


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
     * Set value
     *
     * @param string $value
     * @return AttributesOption
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set idAttributes
     *
     * @param \Application\Entity\Attributes $idAttributes
     * @return AttributesOption
     */
    public function setIdAttributes(\Application\Entity\Attributes $idAttributes = null)
    {
        $this->idAttributes = $idAttributes;

        return $this;
    }

    /**
     * Get idAttributes
     *
     * @return \Application\Entity\Attributes 
     */
    public function getIdAttributes()
    {
        return $this->idAttributes;
    }
}
