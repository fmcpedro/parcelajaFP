<?php

namespace AppBundle\Entity;

/**
 * Tagency
 */
class Tagency {

    /**
     * @var integer
     */
    private $fsubgroupid;

    /**
     * @var string
     */
    private $fagencyname;

    /**
     * @var string
     */
    private $ffiscalname;

    /**
     * @var string
     */
    private $ftaxidnumber;

    /**
     * @var string
     */
    private $faddress;

    /**
     * @var string
     */
    private $fpostalcode1;

    /**
     * @var string
     */
    private $fpostalcode2;

    /**
     * @var string
     */
    private $flocation;

    /**
     * @var string
     */
    private $femail1;

    /**
     * @var string
     */
    private $femail2;

    /**
     * @var string
     */
    private $fcontactperson;

    /**
     * @var string
     */
    private $ftelephone;

    /**
     * @var string
     */
    private $fmobilephone;

    /**
     * @var string
     */
    private $fwebsite;

    /**
     * @var string
     */
    private $fbank;

    /**
     * @var string
     */
    private $fiban;

    /**
     * @var string
     */
    private $fbicswift;

    /**
     * @var string
     */
    private $frnavt;

    /**
     * @var string
     */
    private $fpaymethodid;

    /**
     * @var string
     */
    private $flogo;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var integer
     */
    private $fagencyid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fpos_list;

    /**
     * Constructor
     */
    public function __construct() {
        $this->fpos_list = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fsubgroupid
     *
     * @param integer $fsubgroupid
     *
     * @return Tagency
     */
    public function setFsubgroupid($fsubgroupid) {
        $this->fsubgroupid = $fsubgroupid;

        return $this;
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
     * Set fagencyname
     *
     * @param string $fagencyname
     *
     * @return Tagency
     */
    public function setFagencyname($fagencyname) {
        $this->fagencyname = $fagencyname;

        return $this;
    }

    /**
     * Get fagencyname
     *
     * @return string
     */
    public function getFagencyname() {
        return $this->fagencyname;
    }

    /**
     * Set ffiscalname
     *
     * @param string $ffiscalname
     *
     * @return Tagency
     */
    public function setFfiscalname($ffiscalname) {
        $this->ffiscalname = $ffiscalname;

        return $this;
    }

    /**
     * Get ffiscalname
     *
     * @return string
     */
    public function getFfiscalname() {
        return $this->ffiscalname;
    }

    /**
     * Set ftaxidnumber
     *
     * @param string $ftaxidnumber
     *
     * @return Tagency
     */
    public function setFtaxidnumber($ftaxidnumber) {
        $this->ftaxidnumber = $ftaxidnumber;

        return $this;
    }

    /**
     * Get ftaxidnumber
     *
     * @return string
     */
    public function getFtaxidnumber() {
        return $this->ftaxidnumber;
    }

    /**
     * Set faddress
     *
     * @param string $faddress
     *
     * @return Tagency
     */
    public function setFaddress($faddress) {
        $this->faddress = $faddress;

        return $this;
    }

    /**
     * Get faddress
     *
     * @return string
     */
    public function getFaddress() {
        return $this->faddress;
    }

    /**
     * Set fpostalcode1
     *
     * @param string $fpostalcode1
     *
     * @return Tagency
     */
    public function setFpostalcode1($fpostalcode1) {
        $this->fpostalcode1 = $fpostalcode1;

        return $this;
    }

    /**
     * Get fpostalcode1
     *
     * @return string
     */
    public function getFpostalcode1() {
        return $this->fpostalcode1;
    }

    /**
     * Set fpostalcode2
     *
     * @param string $fpostalcode2
     *
     * @return Tagency
     */
    public function setFpostalcode2($fpostalcode2) {
        $this->fpostalcode2 = $fpostalcode2;

        return $this;
    }

    /**
     * Get fpostalcode2
     *
     * @return string
     */
    public function getFpostalcode2() {
        return $this->fpostalcode2;
    }

    /**
     * Set flocation
     *
     * @param string $flocation
     *
     * @return Tagency
     */
    public function setFlocation($flocation) {
        $this->flocation = $flocation;

        return $this;
    }

    /**
     * Get flocation
     *
     * @return string
     */
    public function getFlocation() {
        return $this->flocation;
    }

    /**
     * Set femail1
     *
     * @param string $femail1
     *
     * @return Tagency
     */
    public function setFemail1($femail1) {
        $this->femail1 = $femail1;

        return $this;
    }

    /**
     * Get femail1
     *
     * @return string
     */
    public function getFemail1() {
        return $this->femail1;
    }

    /**
     * Set femail2
     *
     * @param string $femail2
     *
     * @return Tagency
     */
    public function setFemail2($femail2) {
        $this->femail2 = $femail2;

        return $this;
    }

    /**
     * Get femail2
     *
     * @return string
     */
    public function getFemail2() {
        return $this->femail2;
    }

    /**
     * Set fcontactperson
     *
     * @param string $fcontactperson
     *
     * @return Tagency
     */
    public function setFcontactperson($fcontactperson) {
        $this->fcontactperson = $fcontactperson;

        return $this;
    }

    /**
     * Get fcontactperson
     *
     * @return string
     */
    public function getFcontactperson() {
        return $this->fcontactperson;
    }

    /**
     * Set ftelephone
     *
     * @param string $ftelephone
     *
     * @return Tagency
     */
    public function setFtelephone($ftelephone) {
        $this->ftelephone = $ftelephone;

        return $this;
    }

    /**
     * Get ftelephone
     *
     * @return string
     */
    public function getFtelephone() {
        return $this->ftelephone;
    }

    /**
     * Set fmobilephone
     *
     * @param string $fmobilephone
     *
     * @return Tagency
     */
    public function setFmobilephone($fmobilephone) {
        $this->fmobilephone = $fmobilephone;

        return $this;
    }

    /**
     * Get fmobilephone
     *
     * @return string
     */
    public function getFmobilephone() {
        return $this->fmobilephone;
    }

    /**
     * Set fwebsite
     *
     * @param string $fwebsite
     *
     * @return Tagency
     */
    public function setFwebsite($fwebsite) {
        $this->fwebsite = $fwebsite;

        return $this;
    }

    /**
     * Get fwebsite
     *
     * @return string
     */
    public function getFwebsite() {
        return $this->fwebsite;
    }

    /**
     * Set fbank
     *
     * @param string $fbank
     *
     * @return Tagency
     */
    public function setFbank($fbank) {
        $this->fbank = $fbank;

        return $this;
    }

    /**
     * Get fbank
     *
     * @return string
     */
    public function getFbank() {
        return $this->fbank;
    }

    /**
     * Set fiban
     *
     * @param string $fiban
     *
     * @return Tagency
     */
    public function setFiban($fiban) {
        $this->fiban = $fiban;

        return $this;
    }

    /**
     * Get fiban
     *
     * @return string
     */
    public function getFiban() {
        return $this->fiban;
    }

    /**
     * Set fbicswift
     *
     * @param string $fbicswift
     *
     * @return Tagency
     */
    public function setFbicswift($fbicswift) {
        $this->fbicswift = $fbicswift;

        return $this;
    }

    /**
     * Get fbicswift
     *
     * @return string
     */
    public function getFbicswift() {
        return $this->fbicswift;
    }

    /**
     * Set frnavt
     *
     * @param string $frnavt
     *
     * @return Tagency
     */
    public function setFrnavt($frnavt) {
        $this->frnavt = $frnavt;

        return $this;
    }

    /**
     * Get frnavt
     *
     * @return string
     */
    public function getFrnavt() {
        return $this->frnavt;
    }

    /**
     * Set fpaymethodid
     *
     * @param string $fpaymethodid
     *
     * @return Tagency
     */
    public function setFpaymethodid($fpaymethodid) {
        $this->fpaymethodid = $fpaymethodid;

        return $this;
    }

    /**
     * Get fpaymethodid
     *
     * @return string
     */
    public function getFpaymethodid() {
        return $this->fpaymethodid;
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

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tagency
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
     * Get fagencyid
     *
     * @return integer
     */
    public function getFagencyid() {
        return $this->fagencyid;
    }

    /**
     * Add fposList
     *
     * @param \AppBundle\Entity\TPos $fposList
     *
     * @return Tagency
     */
    public function addFposList(\AppBundle\Entity\TPos $fposList) {
        $this->fpos_list[] = $fposList;

        return $this;
    }

    /**
     * Remove fposList
     *
     * @param \AppBundle\Entity\TPos $fposList
     */
    public function removeFposList(\AppBundle\Entity\TPos $fposList) {
        $this->fpos_list->removeElement($fposList);
    }

    /**
     * Get fposList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFposList() {
        return $this->fpos_list;
    }

public function __toString()
{
////     if($this->fagencyname):
////            try{
////    return $this->fagencyname;    
////    } catch (Exception $ex) {
////return null;
////    }
////            else:
////             return null;
////        endif;
//    
//    return "aaa";
//    
    
    return $this->fagencyname; 
}
    
    

}
