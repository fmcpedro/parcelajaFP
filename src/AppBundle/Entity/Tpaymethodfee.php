<?php

namespace AppBundle\Entity;

/**
 * Tpaymethodfee
 */
class Tpaymethodfee
{
    /**
     * @var integer
     */
    private $fpaymethodid;

    /**
     * @var float
     */
    private $fstartvalue;

    /**
     * @var float
     */
    private $fendvalue;

    /**
     * @var float
     */
    private $ffee;

    /**
     * @var float
     */
    private $ffixedaddcharge;

    /**
     * @var float
     */
    private $ffee2 = '0';

    /**
     * @var float
     */
    private $ffixedaddcharge2 = '0';

    /**
     * @var float
     */
    private $ffee3 = '0';

    /**
     * @var float
     */
    private $ffixedaddcharge3 = '0';

    /**
     * @var integer
     */
    private $fgroupid = '0';

    /**
     * @var integer
     */
    private $fagencyid = '0';

    /**
     * @var integer
     */
    private $fpaymfeeid;


    /**
     * Set fpaymethodid
     *
     * @param integer $fpaymethodid
     *
     * @return Tpaymethodfee
     */
    public function setFpaymethodid($fpaymethodid)
    {
        $this->fpaymethodid = $fpaymethodid;

        return $this;
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

    /**
     * Set fstartvalue
     *
     * @param float $fstartvalue
     *
     * @return Tpaymethodfee
     */
    public function setFstartvalue($fstartvalue)
    {
        $this->fstartvalue = $fstartvalue;

        return $this;
    }

    /**
     * Get fstartvalue
     *
     * @return float
     */
    public function getFstartvalue()
    {
        return $this->fstartvalue;
    }

    /**
     * Set fendvalue
     *
     * @param float $fendvalue
     *
     * @return Tpaymethodfee
     */
    public function setFendvalue($fendvalue)
    {
        $this->fendvalue = $fendvalue;

        return $this;
    }

    /**
     * Get fendvalue
     *
     * @return float
     */
    public function getFendvalue()
    {
        return $this->fendvalue;
    }

    /**
     * Set ffee
     *
     * @param float $ffee
     *
     * @return Tpaymethodfee
     */
    public function setFfee($ffee)
    {
        $this->ffee = $ffee;

        return $this;
    }

    /**
     * Get ffee
     *
     * @return float
     */
    public function getFfee()
    {
        return $this->ffee;
    }

    /**
     * Set ffixedaddcharge
     *
     * @param float $ffixedaddcharge
     *
     * @return Tpaymethodfee
     */
    public function setFfixedaddcharge($ffixedaddcharge)
    {
        $this->ffixedaddcharge = $ffixedaddcharge;

        return $this;
    }

    /**
     * Get ffixedaddcharge
     *
     * @return float
     */
    public function getFfixedaddcharge()
    {
        return $this->ffixedaddcharge;
    }

    /**
     * Set ffee2
     *
     * @param float $ffee2
     *
     * @return Tpaymethodfee
     */
    public function setFfee2($ffee2)
    {
        $this->ffee2 = $ffee2;

        return $this;
    }

    /**
     * Get ffee2
     *
     * @return float
     */
    public function getFfee2()
    {
        return $this->ffee2;
    }

    /**
     * Set ffixedaddcharge2
     *
     * @param float $ffixedaddcharge2
     *
     * @return Tpaymethodfee
     */
    public function setFfixedaddcharge2($ffixedaddcharge2)
    {
        $this->ffixedaddcharge2 = $ffixedaddcharge2;

        return $this;
    }

    /**
     * Get ffixedaddcharge2
     *
     * @return float
     */
    public function getFfixedaddcharge2()
    {
        return $this->ffixedaddcharge2;
    }

    /**
     * Set ffee3
     *
     * @param float $ffee3
     *
     * @return Tpaymethodfee
     */
    public function setFfee3($ffee3)
    {
        $this->ffee3 = $ffee3;

        return $this;
    }

    /**
     * Get ffee3
     *
     * @return float
     */
    public function getFfee3()
    {
        return $this->ffee3;
    }

    /**
     * Set ffixedaddcharge3
     *
     * @param float $ffixedaddcharge3
     *
     * @return Tpaymethodfee
     */
    public function setFfixedaddcharge3($ffixedaddcharge3)
    {
        $this->ffixedaddcharge3 = $ffixedaddcharge3;

        return $this;
    }

    /**
     * Get ffixedaddcharge3
     *
     * @return float
     */
    public function getFfixedaddcharge3()
    {
        return $this->ffixedaddcharge3;
    }

    /**
     * Set fgroupid
     *
     * @param integer $fgroupid
     *
     * @return Tpaymethodfee
     */
    public function setFgroupid($fgroupid)
    {
        $this->fgroupid = $fgroupid;

        return $this;
    }

    /**
     * Get fgroupid
     *
     * @return integer
     */
    public function getFgroupid()
    {
        return $this->fgroupid;
    }

    /**
     * Set fagencyid
     *
     * @param integer $fagencyid
     *
     * @return Tpaymethodfee
     */
    public function setFagencyid($fagencyid)
    {
        $this->fagencyid = $fagencyid;

        return $this;
    }

    /**
     * Get fagencyid
     *
     * @return integer
     */
    public function getFagencyid()
    {
        return $this->fagencyid;
    }

    /**
     * Get fpaymfeeid
     *
     * @return integer
     */
    public function getFpaymfeeid()
    {
        return $this->fpaymfeeid;
    }
}
