<?php

namespace AppBundle\Entity;

/**
 * Broker
 */
class Broker
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $taxName;

    /**
     * @var string
     */
    private $nif;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $bank;

    /**
     * @var string
     */
    private $iban;

    /**
     * @var integer
     */
    private $commission;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $agencyList;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agencyList = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Broker
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set taxName
     *
     * @param string $taxName
     *
     * @return Broker
     */
    public function setTaxName($taxName)
    {
        $this->taxName = $taxName;

        return $this;
    }

    /**
     * Get taxName
     *
     * @return string
     */
    public function getTaxName()
    {
        return $this->taxName;
    }

    /**
     * Set nif
     *
     * @param string $nif
     *
     * @return Broker
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Broker
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Broker
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Broker
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set bank
     *
     * @param string $bank
     *
     * @return Broker
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
     * Set iban
     *
     * @param string $iban
     *
     * @return Broker
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set commission
     *
     * @param integer $commission
     *
     * @return Broker
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return integer
     */
    public function getCommission()
    {
        return $this->commission;
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

    /**
     * Add agencyList
     *
     * @param \AppBundle\Entity\Tagency $agencyList
     *
     * @return Broker
     */
    public function addAgencyList(\AppBundle\Entity\Tagency $agencyList)
    {
        
//        $agencyList->setBroker($this);
//        $this->agencyList[] = $agencyList;
//
//        return $this;
    
        
        $agencyList->addBroker($this);

    $this->agencyList->add($agencyList);
        
        
    }

    /**
     * Remove agencyList
     *
     * @param \AppBundle\Entity\Tagency $agencyList
     */
    public function removeAgencyList(\AppBundle\Entity\Tagency $agencyList)
    {
        $this->agencyList->removeElement($agencyList);
    }

    /**
     * Get agencyList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAgencyList()
    {
        return $this->agencyList;
    }
    
    
       public function __toString()
{
    return $this->getId()." - ".$this->getName();
}
    
    
}

