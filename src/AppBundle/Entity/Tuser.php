<?php

namespace AppBundle\Entity;

/**
 * Tuser
 */
class Tuser
{
    /**
     * @var string
     */
    private $fname;

    /**
     * @var string
     */
    private $flogin;

    /**
     * @var string
     */
    private $fpwd;

    /**
     * @var boolean
     */
    private $ftype;

    /**
     * @var integer
     */
    private $fagencyid;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var string
     */
    private $fsession;

    /**
     * @var float
     */
    private $ftimestamp;

    /**
     * @var string
     */
    private $ftmpdata;

    /**
     * @var integer
     */
    private $fuserid;


    /**
     * Set fname
     *
     * @param string $fname
     *
     * @return Tuser
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set flogin
     *
     * @param string $flogin
     *
     * @return Tuser
     */
    public function setFlogin($flogin)
    {
        $this->flogin = $flogin;

        return $this;
    }

    /**
     * Get flogin
     *
     * @return string
     */
    public function getFlogin()
    {
        return $this->flogin;
    }

    /**
     * Set fpwd
     *
     * @param string $fpwd
     *
     * @return Tuser
     */
    public function setFpwd($fpwd)
    {
        $this->fpwd = $fpwd;

        return $this;
    }

    /**
     * Get fpwd
     *
     * @return string
     */
    public function getFpwd()
    {
        return $this->fpwd;
    }

    /**
     * Set ftype
     *
     * @param boolean $ftype
     *
     * @return Tuser
     */
    public function setFtype($ftype)
    {
        $this->ftype = $ftype;

        return $this;
    }

    /**
     * Get ftype
     *
     * @return boolean
     */
    public function getFtype()
    {
        return $this->ftype;
    }

    /**
     * Set fagencyid
     *
     * @param integer $fagencyid
     *
     * @return Tuser
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
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tuser
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
     * Set fsession
     *
     * @param string $fsession
     *
     * @return Tuser
     */
    public function setFsession($fsession)
    {
        $this->fsession = $fsession;

        return $this;
    }

    /**
     * Get fsession
     *
     * @return string
     */
    public function getFsession()
    {
        return $this->fsession;
    }

    /**
     * Set ftimestamp
     *
     * @param float $ftimestamp
     *
     * @return Tuser
     */
    public function setFtimestamp($ftimestamp)
    {
        $this->ftimestamp = $ftimestamp;

        return $this;
    }

    /**
     * Get ftimestamp
     *
     * @return float
     */
    public function getFtimestamp()
    {
        return $this->ftimestamp;
    }

    /**
     * Set ftmpdata
     *
     * @param string $ftmpdata
     *
     * @return Tuser
     */
    public function setFtmpdata($ftmpdata)
    {
        $this->ftmpdata = $ftmpdata;

        return $this;
    }

    /**
     * Get ftmpdata
     *
     * @return string
     */
    public function getFtmpdata()
    {
        return $this->ftmpdata;
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
}
