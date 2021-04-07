<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Api;

use Augustash\CheckoutMessage\Api\Data\MessageInterface;
use Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Service interface for checkout message CRUD.
 *
 * @api
 */
interface MessageRepositoryInterface
{
    /**
     * Save checkout message.
     *
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterface $message
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InvalidTransitionException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(MessageInterface $message): MessageInterface;

    /**
     * Get checkout message by ID.
     *
     * @param int $id
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $id): MessageInterface;

    /**
     * Retrieve checkout message.
     *
     * This call returns an array of objects, but detailed information about each object’s attributes might not be
     * included. See https://devdocs.magento.com/codelinks/attributes.html#GroupRepositoryInterface to determine
     * which call to use to get detailed information about all attributes for an object.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): MessageSearchResultsInterface;

    /**
     * Delete checkout message.
     *
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterface $message
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(MessageInterface $message): bool;

    /**
     * Delete checkout message by ID.
     *
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id): bool;
}
