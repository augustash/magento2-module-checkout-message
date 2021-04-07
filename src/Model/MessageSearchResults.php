<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model;

use Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service data object with checkout message search results.
 */
class MessageSearchResults extends SearchResults implements MessageSearchResultsInterface
{
}
