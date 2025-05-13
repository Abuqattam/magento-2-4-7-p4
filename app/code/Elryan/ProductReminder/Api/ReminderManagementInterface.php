<?php

namespace Elryan\ProductReminder\Api;

use Elryan\ProductReminder\Api\Data\ReminderInterface;

interface ReminderManagementInterface
{
    /**
     * Set a new product reminder.
     *
     * @param int $customerId
     * @param int $productId
     * @param string $reminderDate (YYYY-MM-DD)
     * @return ReminderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setReminder(int $customerId, int $productId, string $reminderDate): ReminderInterface;

    /**
     * Get all reminders for a specific customer.
     *
     * @param int $customerId
     * @return ReminderInterface[]
     */
    public function getRemindersByCustomerId(int $customerId): array;

    /**
     * Delete a reminder by ID.
     *
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteReminder(int $id): bool;
}
