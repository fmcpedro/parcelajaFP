<?php

namespace AppBundle\Entity;

/**
 * Tpayments
 */
class Tpayments
{
    /**
     * @var integer
     */
    private $fpurchaseid;

    /**
     * @var string
     */
    private $frefcontractnum;

    /**
     * @var integer
     */
    private $finstallment;

    /**
     * @var float
     */
    private $famount;

    /**
     * @var \DateTime
     */
    private $fdate;

    /**
     * @var string
     */
    private $fclientevo;

    /**
     * @var string
     */
    private $fpaymethodevo;

    /**
     * @var string
     */
    private $ftypeevo;

    /**
     * @var \DateTime
     */
    private $fbookingdateevo;

    /**
     * @var \DateTime
     */
    private $fpaydateevo;

    /**
     * @var string
     */
    private $fcustomerevo;

    /**
     * @var string
     */
    private $fproccustomeridevo;

    /**
     * @var string
     */
    private $fclientcustomernumevo;

    /**
     * @var string
     */
    private $fcreditcardnumevo;

    /**
     * @var float
     */
    private $fdepositsevo;

    /**
     * @var float
     */
    private $frefundsevo;

    /**
     * @var float
     */
    private $fcftcreditsevo;

    /**
     * @var float
     */
    private $fchargebacksevo;

    /**
     * @var string
     */
    private $fcurrencyevo;

    /**
     * @var string
     */
    private $fpayid;


    /**
     * Set fpurchaseid
     *
     * @param integer $fpurchaseid
     *
     * @return Tpayments
     */
    public function setFpurchaseid($fpurchaseid)
    {
        $this->fpurchaseid = $fpurchaseid;

        return $this;
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

    /**
     * Set frefcontractnum
     *
     * @param string $frefcontractnum
     *
     * @return Tpayments
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
     * Set finstallment
     *
     * @param integer $finstallment
     *
     * @return Tpayments
     */
    public function setFinstallment($finstallment)
    {
        $this->finstallment = $finstallment;

        return $this;
    }

    /**
     * Get finstallment
     *
     * @return integer
     */
    public function getFinstallment()
    {
        return $this->finstallment;
    }

    /**
     * Set famount
     *
     * @param float $famount
     *
     * @return Tpayments
     */
    public function setFamount($famount)
    {
        $this->famount = $famount;

        return $this;
    }

    /**
     * Get famount
     *
     * @return float
     */
    public function getFamount()
    {
        return $this->famount;
    }

    /**
     * Set fdate
     *
     * @param \DateTime $fdate
     *
     * @return Tpayments
     */
    public function setFdate($fdate)
    {
        $this->fdate = $fdate;

        return $this;
    }

    /**
     * Get fdate
     *
     * @return \DateTime
     */
    public function getFdate()
    {
        return $this->fdate;
    }

    /**
     * Set fclientevo
     *
     * @param string $fclientevo
     *
     * @return Tpayments
     */
    public function setFclientevo($fclientevo)
    {
        $this->fclientevo = $fclientevo;

        return $this;
    }

    /**
     * Get fclientevo
     *
     * @return string
     */
    public function getFclientevo()
    {
        return $this->fclientevo;
    }

    /**
     * Set fpaymethodevo
     *
     * @param string $fpaymethodevo
     *
     * @return Tpayments
     */
    public function setFpaymethodevo($fpaymethodevo)
    {
        $this->fpaymethodevo = $fpaymethodevo;

        return $this;
    }

    /**
     * Get fpaymethodevo
     *
     * @return string
     */
    public function getFpaymethodevo()
    {
        return $this->fpaymethodevo;
    }

    /**
     * Set ftypeevo
     *
     * @param string $ftypeevo
     *
     * @return Tpayments
     */
    public function setFtypeevo($ftypeevo)
    {
        $this->ftypeevo = $ftypeevo;

        return $this;
    }

    /**
     * Get ftypeevo
     *
     * @return string
     */
    public function getFtypeevo()
    {
        return $this->ftypeevo;
    }

    /**
     * Set fbookingdateevo
     *
     * @param \DateTime $fbookingdateevo
     *
     * @return Tpayments
     */
    public function setFbookingdateevo($fbookingdateevo)
    {
        $this->fbookingdateevo = $fbookingdateevo;

        return $this;
    }

    /**
     * Get fbookingdateevo
     *
     * @return \DateTime
     */
    public function getFbookingdateevo()
    {
        return $this->fbookingdateevo;
    }

    /**
     * Set fpaydateevo
     *
     * @param \DateTime $fpaydateevo
     *
     * @return Tpayments
     */
    public function setFpaydateevo($fpaydateevo)
    {
        $this->fpaydateevo = $fpaydateevo;

        return $this;
    }

    /**
     * Get fpaydateevo
     *
     * @return \DateTime
     */
    public function getFpaydateevo()
    {
        return $this->fpaydateevo;
    }

    /**
     * Set fcustomerevo
     *
     * @param string $fcustomerevo
     *
     * @return Tpayments
     */
    public function setFcustomerevo($fcustomerevo)
    {
        $this->fcustomerevo = $fcustomerevo;

        return $this;
    }

    /**
     * Get fcustomerevo
     *
     * @return string
     */
    public function getFcustomerevo()
    {
        return $this->fcustomerevo;
    }

    /**
     * Set fproccustomeridevo
     *
     * @param string $fproccustomeridevo
     *
     * @return Tpayments
     */
    public function setFproccustomeridevo($fproccustomeridevo)
    {
        $this->fproccustomeridevo = $fproccustomeridevo;

        return $this;
    }

    /**
     * Get fproccustomeridevo
     *
     * @return string
     */
    public function getFproccustomeridevo()
    {
        return $this->fproccustomeridevo;
    }

    /**
     * Set fclientcustomernumevo
     *
     * @param string $fclientcustomernumevo
     *
     * @return Tpayments
     */
    public function setFclientcustomernumevo($fclientcustomernumevo)
    {
        $this->fclientcustomernumevo = $fclientcustomernumevo;

        return $this;
    }

    /**
     * Get fclientcustomernumevo
     *
     * @return string
     */
    public function getFclientcustomernumevo()
    {
        return $this->fclientcustomernumevo;
    }

    /**
     * Set fcreditcardnumevo
     *
     * @param string $fcreditcardnumevo
     *
     * @return Tpayments
     */
    public function setFcreditcardnumevo($fcreditcardnumevo)
    {
        $this->fcreditcardnumevo = $fcreditcardnumevo;

        return $this;
    }

    /**
     * Get fcreditcardnumevo
     *
     * @return string
     */
    public function getFcreditcardnumevo()
    {
        return $this->fcreditcardnumevo;
    }

    /**
     * Set fdepositsevo
     *
     * @param float $fdepositsevo
     *
     * @return Tpayments
     */
    public function setFdepositsevo($fdepositsevo)
    {
        $this->fdepositsevo = $fdepositsevo;

        return $this;
    }

    /**
     * Get fdepositsevo
     *
     * @return float
     */
    public function getFdepositsevo()
    {
        return $this->fdepositsevo;
    }

    /**
     * Set frefundsevo
     *
     * @param float $frefundsevo
     *
     * @return Tpayments
     */
    public function setFrefundsevo($frefundsevo)
    {
        $this->frefundsevo = $frefundsevo;

        return $this;
    }

    /**
     * Get frefundsevo
     *
     * @return float
     */
    public function getFrefundsevo()
    {
        return $this->frefundsevo;
    }

    /**
     * Set fcftcreditsevo
     *
     * @param float $fcftcreditsevo
     *
     * @return Tpayments
     */
    public function setFcftcreditsevo($fcftcreditsevo)
    {
        $this->fcftcreditsevo = $fcftcreditsevo;

        return $this;
    }

    /**
     * Get fcftcreditsevo
     *
     * @return float
     */
    public function getFcftcreditsevo()
    {
        return $this->fcftcreditsevo;
    }

    /**
     * Set fchargebacksevo
     *
     * @param float $fchargebacksevo
     *
     * @return Tpayments
     */
    public function setFchargebacksevo($fchargebacksevo)
    {
        $this->fchargebacksevo = $fchargebacksevo;

        return $this;
    }

    /**
     * Get fchargebacksevo
     *
     * @return float
     */
    public function getFchargebacksevo()
    {
        return $this->fchargebacksevo;
    }

    /**
     * Set fcurrencyevo
     *
     * @param string $fcurrencyevo
     *
     * @return Tpayments
     */
    public function setFcurrencyevo($fcurrencyevo)
    {
        $this->fcurrencyevo = $fcurrencyevo;

        return $this;
    }

    /**
     * Get fcurrencyevo
     *
     * @return string
     */
    public function getFcurrencyevo()
    {
        return $this->fcurrencyevo;
    }

    /**
     * Get fpayid
     *
     * @return string
     */
    public function getFpayid()
    {
        return $this->fpayid;
    }
}

