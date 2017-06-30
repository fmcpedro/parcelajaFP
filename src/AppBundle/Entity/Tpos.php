<?php

namespace AppBundle\Entity;

/**
 * Tpos
 */
class Tpos {

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
     * @var \AppBundle\Entity\Tagency
     */
    private $fagency;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $payments_list;

    /**
     * Constructor
     */
    public function __construct() {
        $this->payments_list = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fserial
     *
     * @param string $fserial
     *
     * @return Tpos
     */
    public function setFserial($fserial) {
        $this->fserial = $fserial;

        return $this;
    }

    /**
     * Get fserial
     *
     * @return string
     */
    public function getFserial() {
        return $this->fserial;
    }

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tpos
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
     * Set fsoftversion
     *
     * @param string $fsoftversion
     *
     * @return Tpos
     */
    public function setFsoftversion($fsoftversion) {
        $this->fsoftversion = $fsoftversion;

        return $this;
    }

    /**
     * Get fsoftversion
     *
     * @return string
     */
    public function getFsoftversion() {
        return $this->fsoftversion;
    }

    /**
     * Get fposid
     *
     * @return integer
     */
    public function getFposid() {
        return $this->fposid;
    }

    /**
     * Set fagency
     *
     * @param \AppBundle\Entity\Tagency $fagency
     *
     * @return Tpos
     */
    public function setFagency(\AppBundle\Entity\Tagency $fagency = null) {
        $this->fagency = $fagency;

        return $this;
    }

    /**
     * Get fagency
     *
     * @return \AppBundle\Entity\Tagency
     */
    public function getFagency() {

        if ($this->fagency):
            return $this->fagency;
        else:
            return null;
        endif;
    }

    /**
     * Add paymentsList
     *
     * @param \AppBundle\Entity\TerminalPayment $paymentsList
     *
     * @return Tpos
     */
    public function addPaymentsList(\AppBundle\Entity\TerminalPayment $paymentsList) {
        $this->payments_list[] = $paymentsList;

        return $this;
    }

    /**
     * Remove paymentsList
     *
     * @param \AppBundle\Entity\TerminalPayment $paymentsList
     */
    public function removePaymentsList(\AppBundle\Entity\TerminalPayment $paymentsList) {
        $this->payments_list->removeElement($paymentsList);
    }

    /**
     * Get paymentsList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentsList() {
        return $this->payments_list;
    }

    public function __toString() {


        return $this->fposid . ' - ' . $this->fserial;
    }

}
