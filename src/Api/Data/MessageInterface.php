<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Api\Data;

use Augustash\CheckoutMessage\Api\Data\MessageExtensionInterface;
use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Service interface for message.
 * @api
 */
interface MessageInterface extends ExtensibleDataInterface
{
    /**
     * Constants defined for data array keys.
     */
    const CONTENT = 'content';
    const DATE_FROM = 'from_date';
    const DATE_TO = 'to_date';
    const IS_ACTIVE = 'is_active';
    const MESSAGE_ID = 'message_id';

    /**
     * Returns the message content.
     *
     * @return string
     */
    public function getContent(): ?string;

    /**
     * Sets the message content.
     *
     * @param string $content
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setContent(string $content): MessageInterface;

    /**
     * Returns the message from date.
     *
     * @return string|null
     */
    public function getFromDate(): ?string;

    /**
     * Sets the message from date.
     *
     * @param string $date
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setFromDate(string $date): MessageInterface;


    /**
     * Returns the message ID.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Sets the message ID.
     *
     * @param int $id
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setId($id);

    /**
     * Returns the message status.
     *
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * Sets the message status.
     *
     * @param bool $status
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setIsActive(bool $status): MessageInterface;

    /**
     * Returns the message to date.
     *
     * @return string|null
     */
    public function getToDate(): ?string;

    /**
     * Sets the message to date.
     *
     * @param string $date
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setToDate(string $date): MessageInterface;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Augustash\CheckoutMessage\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes(): ?MessageExtensionInterface;

    /**
     * Set an extension attributes object.
     *
     * @param \Augustash\CheckoutMessage\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return \Augustash\CheckoutMessage\Api\Data\MessageInterface
     */
    public function setExtensionAttributes(MessageExtensionInterface $extensionAttributes): MessageInterface;
}
