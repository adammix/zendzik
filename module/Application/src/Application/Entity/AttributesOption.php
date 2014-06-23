<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributesOption
 *
 * @ORM\Table(name="attributes_option", indexes={@ORM\Index(name="IDX_86F0C9EE94111EA7", columns={"id_attributes"})})
 * @ORM\Entity
 */
class AttributesOption
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
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @var \Application\Entity\Attributes
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Attributes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_attributes", referencedColumnName="id")
     * })
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
