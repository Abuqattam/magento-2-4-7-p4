<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\ReminderManagementInterface;
use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Elryan\ProductReminder\Model\ReminderFactory;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Elryan\ProductReminder\Model\ResourceModel\Reminder\CollectionFactory as ReminderCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\ResourceConnection;

class ReminderManagement implements ReminderManagementInterface
{
    public function __construct(
        protected ReminderFactory $reminderFactory,
        protected ReminderResource $reminderResource,
        protected ReminderCollectionFactory $reminderCollectionFactory,
        protected DateTime $dateTime,
        protected ResourceConnection $resourceConnection
    ) {
    }

    public function setReminder(int $customerId, int $productId, string $reminderDate): ReminderInterface
    {
        // Validate the reminder date
        $currentDate = $this->dateTime->gmtDate('Y-m-d');
        if ($reminderDate <= $currentDate) {
            throw new LocalizedException(__('The reminder date must be in the future.'));
        }

        /** @var ReminderInterface $reminder */
        $reminder = $this->reminderFactory->create();
        $reminder->setCustomerId($customerId)
            ->setProductId($productId)
            ->setReminderDate($reminderDate)
            ->setStatus('Pending');

        $this->reminderResource->save($reminder);

        return $reminder;
    }

    public function getRemindersByCustomerId(int $customerId): array
    {
        $collection = $this->reminderCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);

        return $collection->getItems();
    }

    public function deleteReminder(int $id): bool
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('product_reminder');
        $deletedRows = $connection->delete($tableName, ['id = ?' => $id]);

        return $deletedRows > 0;
    }
}
