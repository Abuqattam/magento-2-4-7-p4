<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\ReminderManagementInterface;
use Elryan\ProductReminder\Api\ReminderRepositoryInterface;
use Elryan\ProductReminder\Api\Data\ReminderInterfaceFactory;
use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Psr\Log\LoggerInterface;

class ReminderManagement implements ReminderManagementInterface
{
    public function __construct(
        protected ReminderRepositoryInterface $reminderRepository,
        protected ReminderInterfaceFactory $reminderFactory,
        protected LoggerInterface $logger
    ) {
    }

    public function getRemindersByCustomerId(int $customerId): array
    {
        return $this->reminderRepository->getByCustomerId($customerId);
    }

    public function deleteReminder(int $id): bool
    {
        return $this->reminderRepository->deleteById($id);
    }

    public function setReminder(int $customerId, int $productId, string $reminderDate): ReminderInterface
    {
        $reminder = $this->reminderFactory->create();
        $reminder->setCustomerId($customerId)
            ->setProductId($productId)
            ->setReminderDate($reminderDate)
            ->setStatus('Pending');

        return $this->reminderRepository->save($reminder);
    }
}
