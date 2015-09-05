<?php

// src/AppBundle/Entity/BillingInputs.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class BillingInputs
{
	/**
     * @Assert\NotBlank()
	 *
     */
    protected $estimated;

    /**
     * @Assert\NotBlank()
	 * @Assert\Range(
     *   	min = 0,
     *      max = 1,
     *      minMessage = "Cannot remove less than {{ limit }}% of the artefacts",
     *      maxMessage = "Cannot remove more than 100% of the artefacts"
	 *  )
     */
    protected $duplicates;
	
	/**
     * @Assert\NotBlank()
	 * @Assert\Range(
     *   	min = 0,
     *      max = 100,
     *      minMessage = "Cannot fold less than {{ limit }}% of the artefacts",
     *      maxMessage = "Cannot fold more than 100% of the artefacts"
	 *  )
     */
    protected $versions;

    public function getEstimated()
    {
        return $this->estimated;
    }

    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;
    }

	public function getDuplicates()
    {
        return $this->duplicates;
    }

    public function setDuplicates($duplicates)
    {
        $this->duplicates = $duplicates;
    }
	
	public function getVersions()
    {
        return $this->versions;
    }

    public function setVersions($versions)
    {
        $this->versions = $versions;
    }
}
?>