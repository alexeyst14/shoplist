<?php

namespace Avkdev\ShopListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 */
class Item
{
    const STATUS_NORMAL  = 0;
    const STATUS_REMOVED = 1;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $changedAt;
    /**
     * @var integer
     */
    private $status;

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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get changedAt
     *
     * @return \DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }

    /**
     * Set changedAt
     *
     * @param \DateTime $changedAt
     * @return Item
     */
    public function setChangedAt($changedAt)
    {
        $this->changedAt = $changedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setChangeAtValue()
    {
        $this->setChangedAt(new \DateTime());
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setStatusValue()
    {
        $this->setStatus(self::STATUS_NORMAL);
        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Item
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
