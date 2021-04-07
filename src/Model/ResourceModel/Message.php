<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Checkout message resource model.
 */
class Message extends AbstractDb
{
    /**
     * Resource initialization.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('checkout_message', 'message_id');
    }
}
