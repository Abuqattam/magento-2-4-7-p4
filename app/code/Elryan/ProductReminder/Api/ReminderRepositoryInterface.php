<?php

namespace Elryan\ProductReminder\Api;

use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

interface ReminderRepositoryInterface
{
    /**
     * Save a reminder.
     *
     * @param ReminderInterface $reminder
     * @return ReminderInterface
     * @throws CouldNotSaveException
     */
    public function save(ReminderInterface $reminder): ReminderInterface;

    /**
     * Get a reminder by ID.
     *
     * @param int $id
     * @return ReminderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ReminderInterface;

    /**
     * Get all reminders for a customer.
     *
     * @param int $customerId
     * @return ReminderInterface[]
     */
    public function getByCustomerId(int $customerId): array;

    /**
     * Delete a reminder.
     *
     * @param ReminderInterface $reminder
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ReminderInterface $reminder): bool;

    /**
     * Delete a reminder by ID.
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}
