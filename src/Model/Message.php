<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model;

use Augustash\CheckoutMessage\Api\Data\MessageExtensionInterface;
use Augustash\CheckoutMessage\Api\Data\MessageInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Checkout message model.
 *
 * @api
 */
class Message extends AbstractExtensibleModel implements MessageInterface
{
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'checkout_message';

    /**
     * Parameter name in event.
     *
     * @var string
     */
    protected $_eventObject = 'message';

    /**
     * Model initialization.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Augustash\CheckoutMessage\Model\ResourceModel\Message::class);
    }

    /**
     * @inheritdoc
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent(string $content): MessageInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritdoc
     */
    public function getFromDate(): ?string
    {
        return $this->getData(self::DATE_FROM);
    }

    /**
     * @inheritdoc
     */
    public function setFromDate($date): MessageInterface
    {
        return $this->setData(self::DATE_FROM, $date);
    }

    /**
     * @inheritdoc
     */
    public function getId(): ?int
    {
        return $this->getData(self::MESSAGE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::MESSAGE_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getIsActive(): bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public function setIsActive(bool $status): MessageInterface
    {
        return $this->setData(self::IS_ACTIVE, $status);
    }

    /**
     * @inheritdoc
     */
    public function getToDate(): ?string
    {
        return $this->getData(self::DATE_TO);
    }

    /**
     * @inheritdoc
     */
    public function setToDate(string $date): MessageInterface
    {
        return $this->setData(self::DATE_TO, $date);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes(): ?MessageExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(MessageExtensionInterface $extensionAttributes): MessageInterface
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
