<?php

namespace AppBundle\Entity;

/**
 * Tsubgroup
 */
class Tsubgroup {

    /**
     * @var string
     */
    private $fsubgroupname;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var integer
     */
    private $fsubgroupid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $agencyList;

    /**
     * @var \AppBundle\Entity\Tgroup
     */
    private $group;

    /**
     * Constructor
     */
    public function __construct() {
        $this->agencyList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fsubgroupname
     *
     * @param string $fsubgroupname
     *
     * @return Tsubgroup
     */
    public function setFsubgroupname($fsubgroupname) {
        $this->fsubgroupname = $fsubgroupname;

        return $this;
    }

    /**
     * Get fsubgroupname
     *
     * @return string
     */
    public function getFsubgroupname() {
        return $this->fsubgroupname;
    }

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tsubgroup
     */
    public function setFstate($fstate) {
        $this->fstate = $fstate;

        return $this;
    }

    /**
     * Get fstate
     *
     * @return boolean
     */
    public function getFstate() {
        return $this->fstate;
    }

    /**
     * Get fsubgroupid
     *
     * @return integer
     */
    public function getFsubgroupid() {
        return $this->fsubgroupid;
    }

    /**
     * Add agencyList
     *
     * @param \AppBundle\Entity\Tagency $agencyList
     *
     * @return Tsubgroup
     */
    public function addAgencyList(\AppBundle\Entity\Tagency $agencyList) {
        $this->agencyList[] = $agencyList;

        return $this;
    }

    /**
     * Remove agencyList
     *
     * @param \AppBundle\Entity\Tagency $agencyList
     */
    public function removeAgencyList(\AppBundle\Entity\Tagency $agencyList) {
        $this->agencyList->removeElement($agencyList);
    }

    /**
     * Get agencyList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAgencyList() {
        return $this->agencyList;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Tgroup $group
     *
     * @return Tsubgroup
     */
    public function setGroup(\AppBundle\Entity\Tgroup $group = null) {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Tgroup
     */
    public function getGroup() {
        return $this->group;
    }

    public function __toString() {
        return $this->getFsubgroupid()." - ".$this->getFsubgroupname();
    }

}
