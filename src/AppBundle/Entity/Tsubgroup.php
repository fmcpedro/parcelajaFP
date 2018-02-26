<?php

namespace AppBundle\Entity;


use Symfony\Component\HttpFoundation\File\File;

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
     * @var string
     */
    private $flogo;
    private $imageFile;
    
    
        /**
     * @var \DateTime
     */
    private $updatedAt;
    
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

    
    
        /**
     * Set flogo
     *
     * @param string $flogo
     *
     * @return Tagency
     */
    public function setFlogo($flogo) {
        $this->flogo = $flogo;

        return $this;
    }

    /**
     * Get flogo
     *
     * @return string
     */
    public function getFlogo() {
        return $this->flogo;
    }

    
    
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getAbsolutePath() {
        return null === $this->flogo ? null : $this->getUploadRootDir() . '/' . $this->flogo;
    }

    public function getWebPath() {
        return null === $this->flogo ? null : $this->getUploadDir() . '/' . $this->flogo;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/subgrupos';
    }

    
    
    
    
    public function __toString() {
        return $this->getFsubgroupid()." - ".$this->getFsubgroupname();
    }
    
    
    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }


    
    

}
