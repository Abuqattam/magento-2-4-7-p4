<?php

namespace Elryan\ProductReminder\Api\Data;

interface ReminderInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const PRODUCT_ID = 'product_id';
    const REMINDER_DATE = 'reminder_date';
    const STATUS = 'status';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Customer ID
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set Customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get Product ID
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set Product ID
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

    /**
     * Get Reminder Date
     *
     * @return string
     */
    public function getReminderDate();

    /**
     * Set Reminder Date
     *
     * @param string $reminderDate
     * @return $this
     */
    public function setReminderDate($reminderDate);

    /**
     * Get Status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);
}
