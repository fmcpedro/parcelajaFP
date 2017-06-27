<?php

namespace AppBundle\Entity;

/**
 * Tsubgroup
 */
class Tsubgroup
{
    /**
     * @var integer
     */
    private $fgroupid;

    /**
     * @var string
     */
    private $fsubgroupname;

    /**
     * @var boolean
     */
    private $fstate;

    /**
     * @var integer
     */
    private $fsubgroupid;


    /**
     * Set fgroupid
     *
     * @param integer $fgroupid
     *
     * @return Tsubgroup
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
     * Set fsubgroupname
     *
     * @param string $fsubgroupname
     *
     * @return Tsubgroup
     */
    public function setFsubgroupname($fsubgroupname)
    {
        $this->fsubgroupname = $fsubgroupname;

        return $this;
    }

    /**
     * Get fsubgroupname
     *
     * @return string
     */
    public function getFsubgroupname()
    {
        return $this->fsubgroupname;
    }

    /**
     * Set fstate
     *
     * @param boolean $fstate
     *
     * @return Tsubgroup
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
     * Get fsubgroupid
     *
     * @return integer
     */
    public function getFsubgroupid()
    {
        return $this->fsubgroupid;
    }
}
