<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Controller\Adminhtml\Checkout\Message;

use Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory;
use Augustash\CheckoutMessage\Api\MessageRepositoryInterface;
use Augustash\CheckoutMessage\Controller\Adminhtml\Checkout\AbstractMessage;
use Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Checkout message edit class.
 */
class Edit extends AbstractMessage implements HttpGetActionInterface
{
    /**
     * @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory $messageFactory
     * @param \Augustash\CheckoutMessage\Api\MessageRepositoryInterface $messageRepository
     * @param \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository,
        MessageCollectionFactory $messageCollectionFactory
    ) {
        $this->messageCollectionFactory = $messageCollectionFactory;
        parent::__construct($context, $dataPersistor, $messageFactory, $messageRepository);
    }

    /**
     * Edit global checkout message.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('id', null);

        if ($id === null) {
            /** @var \Augustash\CheckoutMessage\Model\Message $latestMessage */
            $latestMessage = $this->messageCollectionFactory->create()->getFirstItem();
            if ($latestMessage->getId()) {
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                return $resultRedirect->setPath('*/*/edit', ['id' => $latestMessage->getId()]);
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage
            ->setActiveMenu('Augustash_CheckoutMessage::global_message')
            ->addBreadcrumb(__('Communications'), __('Communications'))
            ->addBreadcrumb(__('Edit Checkout Message'), __('Edit Checkout Message'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Edit Checkout Message'));
        return $resultPage;
    }
}
