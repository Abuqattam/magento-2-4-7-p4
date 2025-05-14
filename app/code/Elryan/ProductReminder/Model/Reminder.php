<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Magento\Framework\Model\AbstractModel;

class Reminder extends AbstractModel implements ReminderInterface
{
    protected function _construct(): void
    {
        $this->_init(ReminderResource::class);
    }

    public function getId(): ?int
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    public function getProductId(): int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    public function setProductId($productId)
    {
        $this->setData(self::PRODUCT_ID, $productId);
        return $this;
    }

    public function getReminderDate(): string
    {
        return $this->getData(self::REMINDER_DATE);
    }

    public function setReminderDate($reminderDate)
    {
        $this->setData(self::REMINDER_DATE, $reminderDate);
        return $this;
    }

    // Getter for Status
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    // Setter for Status
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }
}
