<?php

namespace AppBundle\Entity;

/**
 * TerminalPayment
 */
class TerminalPayment {

    /**
     * @var integer
     */
    private $month;

    /**
     * @var integer
     */
    private $year;

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Tpos
     */
    private $terminal;

    /**
     * @var \AppBundle\Entity\Tagency
     */
    private $agency;

    /**
     * @var \AppBundle\Entity\Tsubgroup
     */
    private $subgroup;

    /**
     * @var \AppBundle\Entity\Tgroup
     */
    private $group;

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return TerminalPayment
     */
    public function setMonth($month) {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return TerminalPayment
     */
    public function setYear($year) {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return TerminalPayment
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set terminal
     *
     * @param \AppBundle\Entity\Tpos $terminal
     *
     * @return TerminalPayment
     */
    public function setTerminal(\AppBundle\Entity\Tpos $terminal = null) {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * Get terminal
     *
     * @return \AppBundle\Entity\Tpos
     */
    public function getTerminal() {
        return $this->terminal;
    }

    /**
     * Set agency
     *
     * @param \AppBundle\Entity\Tagency $agency
     *
     * @return Tpos
     */
    public function setAgency(\AppBundle\Entity\Tagency $agency = null) {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \AppBundle\Entity\Tagency
     */
    public function getAgency() {
        return $this->agency;
    }

    /**
     * Set subgroup
     *
     * @param \AppBundle\Entity\Tsubgroup $subgroup
     *
     * @return Tagency
     */
    public function setSubgroup(\AppBundle\Entity\Tsubgroup $subgroup = null) {
        $this->subgroup = $subgroup;

        return $this;
    }

    /**
     * Get subgroup
     *
     * @return \AppBundle\Entity\Tsubgroup
     */
    public function getSubgroup() {
        return $this->subgroup;
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

}
