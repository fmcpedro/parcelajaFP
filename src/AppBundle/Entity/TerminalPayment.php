<?php

namespace AppBundle\Entity;

/**
 * TerminalPayment
 */
class TerminalPayment
{
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
     * @var \AppBundle\Entity\TPos
     */
    private $terminal;


    /**
     * Set month
     *
     * @param integer $month
     *
     * @return TerminalPayment
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return TerminalPayment
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return TerminalPayment
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set terminal
     *
     * @param \AppBundle\Entity\TPos $terminal
     *
     * @return TerminalPayment
     */
    public function setTerminal(\AppBundle\Entity\TPos $terminal = null)
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * Get terminal
     *
     * @return \AppBundle\Entity\TPos
     */
    public function getTerminal()
    {
        return $this->terminal;
    }
}

