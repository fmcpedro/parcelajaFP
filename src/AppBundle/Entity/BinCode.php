<?php

namespace AppBundle\Entity;

/**
 * BinCode
 */
class BinCode
{
    /**
     * @var integer
     */
    private $bin;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var string
     */
    private $card;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $level;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $countrycode;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var boolean
     */
    private $state;



    /**
     * Set bin
     *
     * @param integer $bin
     *
     * @return BinCode
     */
    public function setBin($bin)
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * Get bin
     *
     * @return integer
     */
    public function getBin()
    {
        return $this->bin;
    }

    /**
     * Set bank
     *
     * @param string $bank
     *
     * @return BinCode
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
     * Set card
     *
     * @param string $card
     *
     * @return BinCode
     */
    public function setCard($card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return BinCode
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return BinCode
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return BinCode
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set countrycode
     *
     * @param string $countrycode
     *
     * @return BinCode
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * Get countrycode
     *
     * @return string
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return BinCode
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return BinCode
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set state
     *
     * @param boolean $state
     *
     * @return BinCode
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }

 
}

