<?php

namespace Elryan\ProductReminder\Cron;

use Elryan\ProductReminder\Helper\Data as ReminderHelper;
use Elryan\ProductReminder\Logger\ProductReminderLogger;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;

class SendReminders
{
    public function __construct(
        protected ResourceConnection $resource,
        protected ReminderHelper $reminderHelper,
        protected TransportBuilder $transportBuilder,
        protected StoreManagerInterface $storeManager,
        protected DateTime $dateTime,
        protected CustomerRepositoryInterface $customerRepository,
        protected ProductRepositoryInterface $productRepository,
        protected ProductReminderLogger $logger
    ) {

    }

    /**
     * @return void
     */

    public function execute()
    {
        // Check if the module is enabled
        if (!$this->reminderHelper->isModuleEnabled()) {
            $this->logger->info("Product Reminder module is disabled. Skipping cron job.");
            return;
        }

        $connection = $this->resource->getConnection();
        $reminderTable = $connection->getTableName('product_reminder');
        $currentDate = $this->dateTime->gmtDate('Y-m-d');

        try {
            // Start the transaction
            $connection->beginTransaction();

            // Select reminders for today
            $select = $connection->select()
                ->from($reminderTable)
                ->where('reminder_date <= ?', $currentDate)
                ->where('status = ?', 'Pending');

            $reminders = $connection->fetchAll($select);

            foreach ($reminders as $reminder) {
                $customerId = $reminder['customer_id'];
                $productId = $reminder['product_id'];
                $reminderId = $reminder['id'];

                try {
                    // Fetch customer email
                    $customer = $this->customerRepository->getById($customerId);
                    $customerEmail = $customer->getEmail();

                    // Send the reminder email
                    $this->sendEmail($customerEmail, $productId);

                    // Mark the reminder as sent
                    $connection->update(
                        $reminderTable,
                        ['status' => 'Sent'],
                        ['id = ?' => $reminderId]
                    );

                } catch (\Exception $e) {
                    $this->logger->error("Error sending email for Reminder ID {$reminderId}: " . $e->getMessage());
                }
            }

            // Commit the transaction
            $connection->commit();

            $this->logger->info("Reminder cron job completed successfully.");

        } catch (\Exception $e) {
            $connection->rollBack();
            $this->logger->error("Error executing reminder cron job: " . $e->getMessage());
        }
    }

    /**
     * @param string $customerEmail
     * @param int $productId
     * @return void
     */

    protected function sendEmail(string $customerEmail, int $productId)
    {
        try {

            $product      = $this->productRepository->getById($productId);
            $productName  = $product->getName();
            $reminderEmailTemplateId = $this->reminderHelper->getReminderEmailTemplateId();

            $emailVars = [
                'customer_email' => $customerEmail,
                'product_name'   => $productName,
            ];

            /* 4. Compose and send */
            $storeId   = $this->storeManager->getStore()->getId();
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($reminderEmailTemplateId)
                ->setTemplateOptions([
                    'area'  => Area::AREA_FRONTEND,
                    'store' => $storeId
                ])
                ->setTemplateVars($emailVars)
                ->setFromByScope('general', $storeId)
                ->addTo($customerEmail)
                ->getTransport();

            $transport->sendMessage();

            $this->logger->info("Reminder email sent to {$customerEmail} for Product ID {$productId}");

        } catch (\Exception $e) {
            // Always log mail failures so they don't fail silently
            $this->logger->error(__('Reminder e‑mail failed: %1', $e->getMessage()));
        }
    }
}
