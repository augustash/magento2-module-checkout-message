<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Service interface for checkout message search results.
 * @api
 */
interface MessageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get checkout message list.
     *
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set checkout message list.
     *
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
