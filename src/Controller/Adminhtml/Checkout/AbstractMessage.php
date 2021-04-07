<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Controller\Adminhtml\Checkout;

use Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory;
use Augustash\CheckoutMessage\Api\MessageRepositoryInterface;
use Magento\Backend\App\Action as ParentAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Abstract checkout message controller class.
 */
abstract class AbstractMessage extends ParentAction
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Augustash_CheckoutMessage::global_message';

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory
     */
    protected $messageFactory;

    /**
     * @var \Augustash\CheckoutMessage\Api\MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory $messageFactory
     * @param \Augustash\CheckoutMessage\Api\MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->messageFactory = $messageFactory;
        $this->messageRepository = $messageRepository;
        parent::__construct($context);
    }
}
