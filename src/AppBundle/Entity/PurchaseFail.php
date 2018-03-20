<?php

namespace AppBundle\Entity;

/**
 * PurchaseFail
 */
class PurchaseFail
{
    /**
     * @var integer
     */
    private $purchaseId;

    /**
     * @var integer
     */
    private $installmentId;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set purchaseId
     *
     * @param integer $purchaseId
     *
     * @return PurchaseFail
     */
    public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;

        return $this;
    }

    /**
     * Get purchaseId
     *
     * @return integer
     */
    public function getPurchaseId()
    {
        return $this->purchaseId;
    }

    /**
     * Set installmentId
     *
     * @param integer $installmentId
     *
     * @return PurchaseFail
     */
    public function setInstallmentId($installmentId)
    {
        $this->installmentId = $installmentId;

        return $this;
    }

    /**
     * Get installmentId
     *
     * @return integer
     */
    public function getInstallmentId()
    {
        return $this->installmentId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PurchaseFail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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

