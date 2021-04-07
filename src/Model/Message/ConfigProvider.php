<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model\Message;

use Augustash\CheckoutMessage\Api\Data\MessageInterface;
use Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory;
use Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Configuration provider for message rendering.
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Augustash\CheckoutMessage\Model\Message
     */
    protected $message = null;

    /**
     * @var \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory
     */
    protected $messageFactory;

    /**
     * @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory $messageFactory
     * @param \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        MessageInterfaceFactory $messageFactory,
        MessageCollectionFactory $messageCollectionFactory
    ) {
        $this->messageFactory = $messageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];
        $config['globalMessage'] = [
            'content' => $this->getContent(),
            'isActive' => $this->isActive(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
        ];
        return $config;
    }

    /**
     * Get the global checkout message object. Currently hardcoded as a single record.
     *
     * @param int|null $messageId
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function getCheckoutMessage(?int $messageId = null): MessageInterface
    {
        if ($this->message === null) {
            try {
                /** @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\Collection $collection */
                $collection = $this->messageCollectionFactory->create();
                if ($messageId !== null) {
                    $collection->addFieldToFilter('message_id', $messageId);
                }

                $this->message = $collection->getFirstItem();
            } catch (NoSuchEntityException $e) {
                $this->message = $this->messageFactory->create(['is_active' => false]);
            }
        }

        return $this->message;
    }

    /**
     * Returns whether the message is active.
     *
     * @param int|null $messageId
     * @return bool
     */
    protected function isActive(?int $messageId = null): bool
    {
        return $this->getCheckoutMessage($messageId)->getIsActive();
    }

    /**
     * Returns the date the message should begin display.
     *
     * @param int|null $messageId
     * @return string|null
     */
    protected function getStartDate(?int $messageId = null): ?string
    {
        return $this->getCheckoutMessage($messageId)->getFromDate();
    }

    /**
     * Returns the date the message should end display.
     *
     * @param int|null $messageId
     * @return string|null
     */
    protected function getEndDate(?int $messageId = null): ?string
    {
        return $this->getCheckoutMessage($messageId)->getToDate();
    }

    /**
     * Returns the message content.
     *
     * @param int|null $messageId
     * @return string|null
     */
    protected function getContent(?int $messageId = null): ?string
    {
        return $this->getCheckoutMessage($messageId)->getContent();
    }
}
