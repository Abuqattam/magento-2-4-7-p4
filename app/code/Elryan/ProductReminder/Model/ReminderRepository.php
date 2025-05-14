<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Elryan\ProductReminder\Api\ReminderRepositoryInterface;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Elryan\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class ReminderRepository implements ReminderRepositoryInterface
{
    /**
     * @param ReminderResource $reminderResource
     * @param ReminderFactory $reminderFactory
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */

    public function __construct(
        protected ReminderResource $reminderResource,
        protected ReminderFactory $reminderFactory,
        protected CollectionFactory $collectionFactory,
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @param ReminderInterface $reminder
     * @return ReminderInterface
     * @throws CouldNotSaveException
     */

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

    /**
     * @param int $id
     * @return ReminderInterface
     * @throws NoSuchEntityException
     */

    public function getById(int $id): ReminderInterface
    {
        $reminder = $this->reminderFactory->create();
        $this->reminderResource->load($reminder, $id);

        if (!$reminder->getId()) {
            throw new NoSuchEntityException(__('Reminder with ID %1 not found', $id));
        }

        return $reminder;
    }

    /**
     * @param ReminderInterface $reminder
     * @return bool
     * @throws CouldNotDeleteException
     */

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

    /**
     * @param array $criteria
     * @return array
     */

    public function getList(array $criteria): array
    {
        $collection = $this->collectionFactory->create();

        foreach ($criteria as $field => $value) {
            $collection->addFieldToFilter($field, $value);
        }

        return $collection->getItems();
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */

    public function deleteById(int $id): bool
    {
        $reminder = $this->getById($id);
        return $this->delete($reminder);
    }

    /**
     * @param int $customerId
     * @return array
     * @throws NoSuchEntityException
     */

    public function getByCustomerId(int $customerId): array
    {
        $collection = $this->getList(['customer_id' => $customerId]);
        return $collection;
    }
}
