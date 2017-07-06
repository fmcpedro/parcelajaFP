<?php

namespace AppBundle\Entity;

/**
 * Tpos
 */
class Tpos
{
    /**
     * @var string
     */
    private $fserial;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var string
     */
    private $fsoftversion;

    /**
     * @var integer
     */
    private $fposid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $paymentList;

    /**
     * @var \AppBundle\Entity\Tagency
     */
    private $agency;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paymentList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fserial
     *
     * @param string $fserial
     *
     * @return Tpos
     */
    public function setFserial($fserial)
    {
        $this->fserial = $fserial;

        return $this;
    }

    /**
     * Get fserial
     *
     * @return string
     */
    public function getFserial()
    {
        return $this->fserial;
    }

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tpos
     */
    public function setFstate($fstate)
    {
        $this->fstate = $fstate;

        return $this;
    }

    /**
     * Get fstate
     *
     * @return boolean
     */
    public function getFstate()
    {
        return $this->fstate;
    }

    /**
     * Set fsoftversion
     *
     * @param string $fsoftversion
     *
     * @return Tpos
     */
    public function setFsoftversion($fsoftversion)
    {
        $this->fsoftversion = $fsoftversion;

        return $this;
    }

    /**
     * Get fsoftversion
     *
     * @return string
     */
    public function getFsoftversion()
    {
        return $this->fsoftversion;
    }

    /**
     * Get fposid
     *
     * @return integer
     */
    public function getFposid()
    {
        return $this->fposid;
    }

    /**
     * Add paymentList
     *
     * @param \AppBundle\Entity\TerminalPayment $paymentList
     *
     * @return Tpos
     */
    public function addPaymentList(\AppBundle\Entity\TerminalPayment $paymentList)
    {
        $this->paymentList[] = $paymentList;

        return $this;
    }

    /**
     * Remove paymentList
     *
     * @param \AppBundle\Entity\TerminalPayment $paymentList
     */
    public function removePaymentList(\AppBundle\Entity\TerminalPayment $paymentList)
    {
        $this->paymentList->removeElement($paymentList);
    }

    /**
     * Get paymentList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentList()
    {
        return $this->paymentList;
    }

    /**
     * Set agency
     *
     * @param \AppBundle\Entity\Tagency $agency
     *
     * @return Tpos
     */
    public function setAgency(\AppBundle\Entity\Tagency $agency = null)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \AppBundle\Entity\Tagency
     */
    public function getAgency()
    {
        return $this->agency;
    }
    
    
     
    public function __toString() {


        return $this->fposid . ' - ' . $this->fserial;
    }
}

