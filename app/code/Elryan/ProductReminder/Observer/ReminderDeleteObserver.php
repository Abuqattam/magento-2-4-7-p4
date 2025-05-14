<?php

namespace Elryan\ProductReminder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Elryan\ProductReminder\Api\ReminderRepositoryInterface;
use Elryan\ProductReminder\Logger\ProductReminderLogger;

class ReminderDeleteObserver implements ObserverInterface
{
    public function __construct(
        protected ReminderRepositoryInterface $reminderRepository,
        protected ProductReminderLogger $logger
    ) {

    }

    public function execute(Observer $observer)
    {
        try {
            $product = $observer->getEvent()->getProduct();
            $productId = $product->getId();

            // Fetch all reminders for the deleted product
            $reminders = $this->reminderRepository->getList(['product_id' => $productId]);

            foreach ($reminders as $reminder) {
                $this->reminderRepository->delete($reminder);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error deleting reminders for product ID ' . $productId . ': ' . $e->getMessage());
        }
    }
}
