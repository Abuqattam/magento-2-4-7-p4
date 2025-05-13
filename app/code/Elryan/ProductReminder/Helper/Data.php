<?php

namespace Elryan\ProductReminder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_REMINDER_ENABLED = 'product_reminder/general/enable';
    const XML_PATH_EMAIL_SENDER = 'product_reminder/general/email_sender';
    const XML_PATH_DEFAULT_MESSAGE = 'product_reminder/general/default_message';

    /**
     * @return bool
     */

    public function isModuleEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REMINDER_ENABLED);
    }


    /**
     * @return string
     */

    public function getEmailSender(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER);
    }

    /**
     * @return string
     */

    public function getDefaultMessage(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_DEFAULT_MESSAGE);
    }
}
