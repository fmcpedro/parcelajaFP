<?php

namespace AppBundle\Entity;

/**
 * Tschedulepay
 */
class Tschedulepay
{
    /**
     * @var string
     */
    private $frefcontractnum;

    /**
     * @var string
     */
    private $flastpayid;

    /**
     * @var string
     */
    private $fcpc;

    /**
     * @var string
     */
    private $fcedc;

    /**
     * @var string
     */
    private $fccvvc;

    /**
     * @var boolean
     */
    private $ffase;

    /**
     * @var boolean
     */
    private $fnumpayleft;

    /**
     * @var \DateTime
     */
    private $frenewdate;

    /**
     * @var boolean
     */
    private $ftries;

    /**
     * @var float
     */
    private $fvalpreauth;

    /**
     * @var boolean
     */
    private $freqstatus;

    /**
     * @var boolean
     */
    private $fncstatus;

    /**
     * @var integer
     */
    private $fncerror;

    /**
     * @var string
     */
    private $fncerrorplus;

    /**
     * @var boolean
     */
    private $fpayerror;

    /**
     * @var integer
     */
    private $fpurchaseid;


    /**
     * Set frefcontractnum
     *
     * @param string $frefcontractnum
     *
     * @return Tschedulepay
     */
    public function setFrefcontractnum($frefcontractnum)
    {
        $this->frefcontractnum = $frefcontractnum;

        return $this;
    }

    /**
     * Get frefcontractnum
     *
     * @return string
     */
    public function getFrefcontractnum()
    {
        return $this->frefcontractnum;
    }

    /**
     * Set flastpayid
     *
     * @param string $flastpayid
     *
     * @return Tschedulepay
     */
    public function setFlastpayid($flastpayid)
    {
        $this->flastpayid = $flastpayid;

        return $this;
    }

    /**
     * Get flastpayid
     *
     * @return string
     */
    public function getFlastpayid()
    {
        return $this->flastpayid;
    }

    /**
     * Set fcpc
     *
     * @param string $fcpc
     *
     * @return Tschedulepay
     */
    public function setFcpc($fcpc)
    {
        $this->fcpc = $fcpc;

        return $this;
    }

    /**
     * Get fcpc
     *
     * @return string
     */
    public function getFcpc()
    {
        return $this->fcpc;
    }

    /**
     * Set fcedc
     *
     * @param string $fcedc
     *
     * @return Tschedulepay
     */
    public function setFcedc($fcedc)
    {
        $this->fcedc = $fcedc;

        return $this;
    }

    /**
     * Get fcedc
     *
     * @return string
     */
    public function getFcedc()
    {
        return $this->fcedc;
    }

    /**
     * Set fccvvc
     *
     * @param string $fccvvc
     *
     * @return Tschedulepay
     */
    public function setFccvvc($fccvvc)
    {
        $this->fccvvc = $fccvvc;

        return $this;
    }

    /**
     * Get fccvvc
     *
     * @return string
     */
    public function getFccvvc()
    {
        return $this->fccvvc;
    }

    /**
     * Set ffase
     *
     * @param boolean $ffase
     *
     * @return Tschedulepay
     */
    public function setFfase($ffase)
    {
        $this->ffase = $ffase;

        return $this;
    }

    /**
     * Get ffase
     *
     * @return boolean
     */
    public function getFfase()
    {
        return $this->ffase;
    }

    /**
     * Set fnumpayleft
     *
     * @param boolean $fnumpayleft
     *
     * @return Tschedulepay
     */
    public function setFnumpayleft($fnumpayleft)
    {
        $this->fnumpayleft = $fnumpayleft;

        return $this;
    }

    /**
     * Get fnumpayleft
     *
     * @return boolean
     */
    public function getFnumpayleft()
    {
        return $this->fnumpayleft;
    }

    /**
     * Set frenewdate
     *
     * @param \DateTime $frenewdate
     *
     * @return Tschedulepay
     */
    public function setFrenewdate($frenewdate)
    {
        $this->frenewdate = $frenewdate;

        return $this;
    }

    /**
     * Get frenewdate
     *
     * @return \DateTime
     */
    public function getFrenewdate()
    {
        return $this->frenewdate;
    }

    /**
     * Set ftries
     *
     * @param boolean $ftries
     *
     * @return Tschedulepay
     */
    public function setFtries($ftries)
    {
        $this->ftries = $ftries;

        return $this;
    }

    /**
     * Get ftries
     *
     * @return boolean
     */
    public function getFtries()
    {
        return $this->ftries;
    }

    /**
     * Set fvalpreauth
     *
     * @param float $fvalpreauth
     *
     * @return Tschedulepay
     */
    public function setFvalpreauth($fvalpreauth)
    {
        $this->fvalpreauth = $fvalpreauth;

        return $this;
    }

    /**
     * Get fvalpreauth
     *
     * @return float
     */
    public function getFvalpreauth()
    {
        return $this->fvalpreauth;
    }

    /**
     * Set freqstatus
     *
     * @param boolean $freqstatus
     *
     * @return Tschedulepay
     */
    public function setFreqstatus($freqstatus)
    {
        $this->freqstatus = $freqstatus;

        return $this;
    }

    /**
     * Get freqstatus
     *
     * @return boolean
     */
    public function getFreqstatus()
    {
        return $this->freqstatus;
    }

    /**
     * Set fncstatus
     *
     * @param boolean $fncstatus
     *
     * @return Tschedulepay
     */
    public function setFncstatus($fncstatus)
    {
        $this->fncstatus = $fncstatus;

        return $this;
    }

    /**
     * Get fncstatus
     *
     * @return boolean
     */
    public function getFncstatus()
    {
        return $this->fncstatus;
    }

    /**
     * Set fncerror
     *
     * @param integer $fncerror
     *
     * @return Tschedulepay
     */
    public function setFncerror($fncerror)
    {
        $this->fncerror = $fncerror;

        return $this;
    }

    /**
     * Get fncerror
     *
     * @return integer
     */
    public function getFncerror()
    {
        return $this->fncerror;
    }

    /**
     * Set fncerrorplus
     *
     * @param string $fncerrorplus
     *
     * @return Tschedulepay
     */
    public function setFncerrorplus($fncerrorplus)
    {
        $this->fncerrorplus = $fncerrorplus;

        return $this;
    }

    /**
     * Get fncerrorplus
     *
     * @return string
     */
    public function getFncerrorplus()
    {
        return $this->fncerrorplus;
    }

    /**
     * Set fpayerror
     *
     * @param boolean $fpayerror
     *
     * @return Tschedulepay
     */
    public function setFpayerror($fpayerror)
    {
        $this->fpayerror = $fpayerror;

        return $this;
    }

    /**
     * Get fpayerror
     *
     * @return boolean
     */
    public function getFpayerror()
    {
        return $this->fpayerror;
    }

    /**
     * Get fpurchaseid
     *
     * @return integer
     */
    public function getFpurchaseid()
    {
        return $this->fpurchaseid;
    }
}
