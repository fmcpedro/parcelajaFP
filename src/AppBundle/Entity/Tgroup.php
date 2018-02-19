<?php

namespace AppBundle\Entity;

/**
 * Tgroup
 */
class Tgroup {

    /**
     * @var string
     */
    private $fgroupname;

    /**
     * @var string
     */
    private $fgroupslugname;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var integer
     */
    private $fgroupid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $subgroupList;

    /**
     * Constructor
     */
    public function __construct() {
        $this->subgroupList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fgroupname
     *
     * @param string $fgroupname
     *
     * @return Tgroup
     */
    public function setFgroupname($fgroupname) {
        $this->fgroupname = $fgroupname;

        return $this;
    }

    /**
     * Get fgroupname
     *
     * @return string
     */
    public function getFgroupname() {
        return $this->fgroupname;
    }

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tgroup
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
     * Get fgroupid
     *
     * @return integer
     */
    public function getFgroupid() {
        return $this->fgroupid;
    }

    /**
     * Add subgroupList
     *
     * @param \AppBundle\Entity\Tsubgroup $subgroupList
     *
     * @return Tgroup
     */
    public function addSubgroupList(\AppBundle\Entity\Tsubgroup $subgroupList) {
        $this->subgroupList[] = $subgroupList;

        return $this;
    }

    /**
     * Remove subgroupList
     *
     * @param \AppBundle\Entity\Tsubgroup $subgroupList
     */
    public function removeSubgroupList(\AppBundle\Entity\Tsubgroup $subgroupList) {
        $this->subgroupList->removeElement($subgroupList);
    }

    /**
     * Get subgroupList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubgroupList() {
        return $this->subgroupList;
    }

    function getFgroupslugname() {
        return $this->fgroupslugname;
    }

    function setFgroupslugname($fgroupslugname) {
        $this->fgroupslugname = $fgroupslugname;
    }

    public function __toString() {
        return $this->fgroupname;
    }

}
