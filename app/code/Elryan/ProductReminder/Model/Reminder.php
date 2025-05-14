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


    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param $id
     * @return $this|Reminder
     */

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    /**
     * @return int
     */

    public function getCustomerId(): int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @param $customerId
     * @return $this|Reminder
     */

    public function setCustomerId($customerId)
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * @return int
     */

    public function getProductId(): int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * @param $productId
     * @return $this|Reminder
     */

    public function setProductId($productId)
    {
        $this->setData(self::PRODUCT_ID, $productId);
        return $this;
    }

    /**
     * @return string
     */

    public function getReminderDate(): string
    {
        return $this->getData(self::REMINDER_DATE);
    }

    /**
     * @param $reminderDate
     * @return $this|Reminder
     */

    public function setReminderDate($reminderDate)
    {
        $this->setData(self::REMINDER_DATE, $reminderDate);
        return $this;
    }

    /**
     * @return string
     */

    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param $status
     * @return $this|Reminder
     */

    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }
}
