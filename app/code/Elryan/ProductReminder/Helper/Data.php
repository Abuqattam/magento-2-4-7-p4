<?php

namespace Elryan\ProductReminder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const XML_PATH_REMINDER_ENABLED = 'product_reminder/general/enable';
    const XML_PATH_EMAIL_SENDER = 'product_reminder/general/email_sender';
    const XML_PATH_REMINDER_EMAIL_TEMPLATE_ID = 'product_reminder/general/reminder_email_template_id';

    /**
     * @return bool
     */

    public function isModuleEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REMINDER_ENABLED);
    }

    /**
     * @return mixed
     */

    public function getReminderEmailTemplateId()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_REMINDER_EMAIL_TEMPLATE_ID);
    }

}
