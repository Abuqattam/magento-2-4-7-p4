<?php

namespace Elryan\ProductReminder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reminder extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('product_reminder', 'id');
    }
}
