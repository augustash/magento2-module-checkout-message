<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model\ResourceModel\Message;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Checkout message collection.
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'message_id';

    /**
     * Resource collection initialization.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Augustash\CheckoutMessage\Model\Message::class,
            \Augustash\CheckoutMessage\Model\ResourceModel\Message::class
        );
    }
}
