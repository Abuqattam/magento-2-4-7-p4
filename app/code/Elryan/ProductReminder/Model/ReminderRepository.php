<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\ReminderRepositoryInterface;
use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Elryan\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Psr\Log\LoggerInterface;

class ReminderRepository implements ReminderRepositoryInterface
{
    public function __construct(
        protected ReminderResource $reminderResource,
        protected ReminderFactory $reminderFactory,
        protected CollectionFactory $collectionFactory,
        protected LoggerInterface $logger
    ) {
    }

    public function save(ReminderInterface $reminder): ReminderInterface
    {
        try {
            $this->reminderResource->save($reminder);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save reminder'));
        }

        return $reminder;
    }

    public function getById(int $id): ReminderInterface
    {
        $reminder = $this->reminderFactory->create();
        $this->reminderResource->load($reminder, $id);

        if (!$reminder->getId()) {
            throw new NoSuchEntityException(__('Reminder with ID %1 not found', $id));
        }

        return $reminder;
    }

    public function getByCustomerId(int $customerId): array
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);

        return $collection->getItems();
    }

    public function delete(ReminderInterface $reminder): bool
    {
        try {
            $this->reminderResource->delete($reminder);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('Could not delete reminder'));
        }

        return true;
    }

    public function deleteById(int $id): bool
    {
        $reminder = $this->getById($id);
        return $this->delete($reminder);
    }
}
