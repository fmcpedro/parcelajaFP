<?php

namespace AppBundle\Entity;

/**
 * BinBank
 */
class BinBank
{
    /**
     * @var string
     */
    private $countryName;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set countryName
     *
     * @param string $countryName
     *
     * @return BinBank
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return BinBank
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return BinBank
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set bank
     *
     * @param string $bank
     *
     * @return BinBank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
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

