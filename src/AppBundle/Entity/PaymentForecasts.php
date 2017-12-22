<?php

namespace AppBundle\Entity;

/**
 * PaymentForecasts
 */
class PaymentForecasts
{
    /**
     * @var float
     */
    private $valueEvoPayments;

    /**
     * @var string
     */
    private $date;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set valueEvoPayments
     *
     * @param float $valueEvoPayments
     *
     * @return PaymentForecasts
     */
    public function setValueEvoPayments($valueEvoPayments)
    {
        $this->valueEvoPayments = $valueEvoPayments;

        return $this;
    }

    /**
     * Get valueEvoPayments
     *
     * @return float
     */
    public function getValueEvoPayments()
    {
        return $this->valueEvoPayments;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return PaymentForecasts
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
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
}

