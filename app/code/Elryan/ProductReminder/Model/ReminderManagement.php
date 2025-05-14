<?php

namespace Elryan\ProductReminder\Model;

use Elryan\ProductReminder\Api\Data\ReminderInterface;
use Elryan\ProductReminder\Api\Data\ReminderInterfaceFactory;
use Elryan\ProductReminder\Api\ReminderManagementInterface;
use Elryan\ProductReminder\Api\ReminderRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

class ReminderManagement implements ReminderManagementInterface
{

    /**
     * @param ReminderRepositoryInterface $reminderRepository
     * @param ReminderInterfaceFactory $reminderFactory
     * @param DateTime $dateTime
     */

    public function __construct(
        protected ReminderRepositoryInterface $reminderRepository,
        protected ReminderInterfaceFactory $reminderFactory,
        protected DateTime $dateTime
    ) {
    }

    /**
     * @param int $customerId
     * @return array|ReminderInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */

    public function getRemindersByCustomerId(int $customerId): array
    {
        return $this->reminderRepository->getByCustomerId($customerId);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */

    public function deleteReminder(int $id): bool
    {
        return $this->reminderRepository->deleteById($id);
    }

    /**
     * @param int $customerId
     * @param int $productId
     * @param string $reminderDate
     * @return ReminderInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */

    public function setReminder(int $customerId, int $productId, string $reminderDate): ReminderInterface
    {
        $currentDate = $this->dateTime->gmtDate('Y-m-d');
        if ($reminderDate <= $currentDate) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('The reminder date must be in the future.'));
        }

        $reminder = $this->reminderFactory->create();
        $reminder->setCustomerId($customerId)
            ->setProductId($productId)
            ->setReminderDate($reminderDate)
            ->setStatus('Pending');

        return $this->reminderRepository->save($reminder);
    }
}
