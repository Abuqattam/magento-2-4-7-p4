<?php

namespace Elryan\ProductReminder\Logger;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

class ProductReminderHandler extends Base
{
    protected $fileName = '/var/log/product_reminder.log';
    protected $loggerType = Logger::DEBUG;
}
