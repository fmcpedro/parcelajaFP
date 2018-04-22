<?php

namespace AppBundle\Entity;


use Symfony\Component\HttpFoundation\File\File;

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

    function getFlogo() {
        return $this->flogo;
    }

    function setFlogo($flogo) {
        $this->flogo = $flogo;
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
        return 'uploads/grupos'; //Create THIS!
    }
    
    
    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
