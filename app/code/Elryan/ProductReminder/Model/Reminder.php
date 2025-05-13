<?php

namespace Elryan\ProductReminder\Model;

use Magento\Framework\Model\AbstractModel;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Elryan\ProductReminder\Api\Data\ReminderInterface;

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

    public function setId($id): static
    {
        return $this->setData(self::ID, $id);
    }


    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }


    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }


    public function getProductId(): int
    {
        return $this->getData(self::PRODUCT_ID);
    }


    public function setProductId($productId): static
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }


    public function getReminderDate(): string
    {
        return $this->getData(self::REMINDER_DATE);
    }


    public function setReminderDate($reminderDate)
    {
        return $this->setData(self::REMINDER_DATE, $reminderDate);
    }

    // Getter for Status
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    // Setter for Status
    public function setStatus($status): static
    {
        return $this->setData(self::STATUS, $status);
    }
}
