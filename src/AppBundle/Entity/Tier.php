<?php
// src/AppBundle/Entity/Tier.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tier")
 */
class Tier
{
   	/**
     * @ORM\Column(type="string", length=50)
	 * @ORM\Id
     */	
	protected $tierName;
	
	/**
     * @ORM\Column(type="decimal", scale=2)
     */	
	protected $pricePerArtefact;
	
	/**
     * @ORM\Column(type="integer")
     */	
	protected $rangeMinimum;
	
	/**
     * @ORM\Column(type="integer")
     */	
	protected $rangeMaximum;

	
    /**
     * Set tierName
     *
     * @param string $tierName
     * @return Tier
     */
    public function setTierName($tierName)
    {
        $this->tierName = $tierName;

        return $this;
    }

    /**
     * Get tierName
     *
     * @return string 
     */
    public function getTierName()
    {
        return $this->tierName;
    }

    /**
     * Set pricePerArtefact
     *
     * @param string $pricePerArtefact
     * @return Tier
     */
    public function setPricePerArtefact($pricePerArtefact)
    {
        $this->pricePerArtefact = $pricePerArtefact;

        return $this;
    }

    /**
     * Get pricePerArtefact
     *
     * @return string 
     */
    public function getPricePerArtefact()
    {
        return $this->pricePerArtefact;
    }

    /**
     * Set rangeMinimum
     *
     * @param integer $rangeMinimum
     * @return Tier
     */
    public function setRangeMinimum($rangeMinimum)
    {
        $this->rangeMinimum = $rangeMinimum;

        return $this;
    }

    /**
     * Get rangeMinimum
     *
     * @return integer 
     */
    public function getRangeMinimum()
    {
        return $this->rangeMinimum;
    }

    /**
     * Set rangeMaximum
     *
     * @param integer $rangeMaximum
     * @return Tier
     */
    public function setRangeMaximum($rangeMaximum)
    {
        $this->rangeMaximum = $rangeMaximum;

        return $this;
    }

    /**
     * Get rangeMaximum
     *
     * @return integer 
     */
    public function getRangeMaximum()
    {
        return $this->rangeMaximum;
    }
}
