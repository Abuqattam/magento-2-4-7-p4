<?php

namespace Elryan\ProductReminder\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class ProductReminderHandler extends Base
{
    protected $fileName = '/var/log/product_reminder.log';
    protected $loggerType = Logger::DEBUG;
}
