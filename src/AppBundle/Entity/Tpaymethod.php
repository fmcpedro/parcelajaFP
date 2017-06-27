<?php

namespace AppBundle\Entity;

/**
 * Tpaymethod
 */
class Tpaymethod
{
    /**
     * @var string
     */
    private $fpname;

    /**
     * @var integer
     */
    private $fpmonths;

    /**
     * @var integer
     */
    private $fpaymethodid;


    /**
     * Set fpname
     *
     * @param string $fpname
     *
     * @return Tpaymethod
     */
    public function setFpname($fpname)
    {
        $this->fpname = $fpname;

        return $this;
    }

    /**
     * Get fpname
     *
     * @return string
     */
    public function getFpname()
    {
        return $this->fpname;
    }

    /**
     * Set fpmonths
     *
     * @param integer $fpmonths
     *
     * @return Tpaymethod
     */
    public function setFpmonths($fpmonths)
    {
        $this->fpmonths = $fpmonths;

        return $this;
    }

    /**
     * Get fpmonths
     *
     * @return integer
     */
    public function getFpmonths()
    {
        return $this->fpmonths;
    }

    /**
     * Get fpaymethodid
     *
     * @return integer
     */
    public function getFpaymethodid()
    {
        return $this->fpaymethodid;
    }
}
