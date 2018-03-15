<?php

namespace AppBundle\Entity;

/**
 * PurchaseReturn
 */
class PurchaseReturn
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

    
     public function __construct() {
        $this->createdAt = new \DateTime();
    
    }
    

    /**
     * Set purchaseId
     *
     * @param integer $purchaseId
     *
     * @return PurchaseReturn
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

    
    function getInstallmentId() {
        return $this->installmentId;
    }

    function setInstallmentId($installmentId) {
        $this->installmentId = $installmentId;
    }

        
    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PurchaseReturn
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

