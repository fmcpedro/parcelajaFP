<?php

namespace AppBundle\Entity;

/**
 * Tpos
 */
class Tpos
{
    /**
     * @var integer
     */
    private $fagencyid;

    /**
     * @var string
     */
    private $fserial;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var integer
     */
    private $fposid;

    /**
     * @var string
     */
    private $fsoftversion;

    
    
    /**
     * Set fagencyid
     *
     * @param integer $fagencyid
     *
     * @return Tpos
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
     * Get fserial
     *
     * @return string
     */
    public function getFsoftversion()
    {
        return $this->fsoftversion;
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
     * Get fposid
     *
     * @return integer
     */
    public function getFposid()
    {
        return $this->fposid;
    }
}
