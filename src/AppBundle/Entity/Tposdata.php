<?php

namespace AppBundle\Entity;

/**
 * Tposdata
 */
class Tposdata
{
    /**
     * @var integer
     */
    private $fposid;

    /**
     * @var integer
     */
    private $fsupplierid;

    /**
     * @var integer
     */
    private $fuserid;

    /**
     * @var string
     */
    private $fcontractnumber;

    /**
     * @var string
     */
    private $fproddescript;

    /**
     * @var float
     */
    private $fcalcamount;

    /**
     * @var float
     */
    private $ffee;

    /**
     * @var float
     */
    private $fextracharge;

    /**
     * @var float
     */
    private $ftotalamount;

    /**
     * @var float
     */
    private $fmonthamount;

    /**
     * @var string
     */
    private $fmonthdata;

    /**
     * @var \DateTime
     */
    private $fpurchasedate;

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
    private $fhascitizenid;

    /**
     * @var string
     */
    private $fclientdata;

    /**
     * @var string
     */
    private $fsignatureimage;

    /**
     * @var boolean
     */
    private $fstatus;

    /**
     * @var integer
     */
    private $fncerror = '0';

    /**
     * @var string
     */
    private $fncerrorplus;

    /**
     * @var integer
     */
    private $fposdataid;


    /**
     * Set fposid
     *
     * @param integer $fposid
     *
     * @return Tposdata
     */
    public function setFposid($fposid)
    {
        $this->fposid = $fposid;

        return $this;
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
     * Set fsupplierid
     *
     * @param integer $fsupplierid
     *
     * @return Tposdata
     */
    public function setFsupplierid($fsupplierid)
    {
        $this->fsupplierid = $fsupplierid;

        return $this;
    }

    /**
     * Get fsupplierid
     *
     * @return integer
     */
    public function getFsupplierid()
    {
        return $this->fsupplierid;
    }

    /**
     * Set fuserid
     *
     * @param integer $fuserid
     *
     * @return Tposdata
     */
    public function setFuserid($fuserid)
    {
        $this->fuserid = $fuserid;

        return $this;
    }

    /**
     * Get fuserid
     *
     * @return integer
     */
    public function getFuserid()
    {
        return $this->fuserid;
    }

    /**
     * Set fcontractnumber
     *
     * @param string $fcontractnumber
     *
     * @return Tposdata
     */
    public function setFcontractnumber($fcontractnumber)
    {
        $this->fcontractnumber = $fcontractnumber;

        return $this;
    }

    /**
     * Get fcontractnumber
     *
     * @return string
     */
    public function getFcontractnumber()
    {
        return $this->fcontractnumber;
    }

    /**
     * Set fproddescript
     *
     * @param string $fproddescript
     *
     * @return Tposdata
     */
    public function setFproddescript($fproddescript)
    {
        $this->fproddescript = $fproddescript;

        return $this;
    }

    /**
     * Get fproddescript
     *
     * @return string
     */
    public function getFproddescript()
    {
        return $this->fproddescript;
    }

    /**
     * Set fcalcamount
     *
     * @param float $fcalcamount
     *
     * @return Tposdata
     */
    public function setFcalcamount($fcalcamount)
    {
        $this->fcalcamount = $fcalcamount;

        return $this;
    }

    /**
     * Get fcalcamount
     *
     * @return float
     */
    public function getFcalcamount()
    {
        return $this->fcalcamount;
    }

    /**
     * Set ffee
     *
     * @param float $ffee
     *
     * @return Tposdata
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
     * Set fextracharge
     *
     * @param float $fextracharge
     *
     * @return Tposdata
     */
    public function setFextracharge($fextracharge)
    {
        $this->fextracharge = $fextracharge;

        return $this;
    }

    /**
     * Get fextracharge
     *
     * @return float
     */
    public function getFextracharge()
    {
        return $this->fextracharge;
    }

    /**
     * Set ftotalamount
     *
     * @param float $ftotalamount
     *
     * @return Tposdata
     */
    public function setFtotalamount($ftotalamount)
    {
        $this->ftotalamount = $ftotalamount;

        return $this;
    }

    /**
     * Get ftotalamount
     *
     * @return float
     */
    public function getFtotalamount()
    {
        return $this->ftotalamount;
    }

    /**
     * Set fmonthamount
     *
     * @param float $fmonthamount
     *
     * @return Tposdata
     */
    public function setFmonthamount($fmonthamount)
    {
        $this->fmonthamount = $fmonthamount;

        return $this;
    }

    /**
     * Get fmonthamount
     *
     * @return float
     */
    public function getFmonthamount()
    {
        return $this->fmonthamount;
    }

    /**
     * Set fmonthdata
     *
     * @param string $fmonthdata
     *
     * @return Tposdata
     */
    public function setFmonthdata($fmonthdata)
    {
        $this->fmonthdata = $fmonthdata;

        return $this;
    }

    /**
     * Get fmonthdata
     *
     * @return string
     */
    public function getFmonthdata()
    {
        return $this->fmonthdata;
    }

    /**
     * Set fpurchasedate
     *
     * @param \DateTime $fpurchasedate
     *
     * @return Tposdata
     */
    public function setFpurchasedate($fpurchasedate)
    {
        $this->fpurchasedate = $fpurchasedate;

        return $this;
    }

    /**
     * Get fpurchasedate
     *
     * @return \DateTime
     */
    public function getFpurchasedate()
    {
        return $this->fpurchasedate;
    }

    /**
     * Set fcpc
     *
     * @param string $fcpc
     *
     * @return Tposdata
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
     * @return Tposdata
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
     * @return Tposdata
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
     * Set fhascitizenid
     *
     * @param boolean $fhascitizenid
     *
     * @return Tposdata
     */
    public function setFhascitizenid($fhascitizenid)
    {
        $this->fhascitizenid = $fhascitizenid;

        return $this;
    }

    /**
     * Get fhascitizenid
     *
     * @return boolean
     */
    public function getFhascitizenid()
    {
        return $this->fhascitizenid;
    }

    /**
     * Set fclientdata
     *
     * @param string $fclientdata
     *
     * @return Tposdata
     */
    public function setFclientdata($fclientdata)
    {
        $this->fclientdata = $fclientdata;

        return $this;
    }

    /**
     * Get fclientdata
     *
     * @return string
     */
    public function getFclientdata()
    {
        return $this->fclientdata;
    }

    /**
     * Set fsignatureimage
     *
     * @param string $fsignatureimage
     *
     * @return Tposdata
     */
    public function setFsignatureimage($fsignatureimage)
    {
        $this->fsignatureimage = $fsignatureimage;

        return $this;
    }

    /**
     * Get fsignatureimage
     *
     * @return string
     */
    public function getFsignatureimage()
    {
        return $this->fsignatureimage;
    }

    /**
     * Set fstatus
     *
     * @param boolean $fstatus
     *
     * @return Tposdata
     */
    public function setFstatus($fstatus)
    {
        $this->fstatus = $fstatus;

        return $this;
    }

    /**
     * Get fstatus
     *
     * @return boolean
     */
    public function getFstatus()
    {
        return $this->fstatus;
    }

    /**
     * Set fncerror
     *
     * @param integer $fncerror
     *
     * @return Tposdata
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
     * @return Tposdata
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
     * Get fposdataid
     *
     * @return integer
     */
    public function getFposdataid()
    {
        return $this->fposdataid;
    }
}
