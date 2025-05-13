<?php

namespace Elryan\ProductReminder\Model\ResourceModel\Reminder;

use Elryan\ProductReminder\Model\Reminder;
use Elryan\ProductReminder\Model\ResourceModel\Reminder as ReminderResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Reminder::class, ReminderResource::class);
    }
}
