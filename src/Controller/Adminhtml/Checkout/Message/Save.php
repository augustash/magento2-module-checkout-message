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
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Checkout message save class.
 */
class Save extends AbstractMessage implements HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory $messageFactory
     * @param \Augustash\CheckoutMessage\Api\MessageRepositoryInterface $messageRepository
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository,
        Date $dateFilter,
        TimezoneInterface $timezone
    ) {
        $this->dateFilter = $dateFilter;
        $this->timezone = $timezone;
        parent::__construct($context, $dataPersistor, $messageFactory, $messageRepository);
    }

    /**
     * Save global checkout message.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->normalizeData($data);

            /** @var \Augustash\CheckoutMessage\Model\Message $model */
            $model = $this->messageFactory->create();

            $id = $this->getRequest()->getParam('message_id') ?: null;
            if ($id) {
                try {
                    $model = $this->messageRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This checkout message no longer exists.'));
                    return $resultRedirect->setPath('admin/dashboard');
                }
            }

            /** @var \Augustash\CheckoutMessage\Model\Message $model */
            $model->setData($data);

            try {
                $this->messageRepository->save($model);
                $this->messageManager->addSuccessMessage(__('The checkout message was saved.'));
                $this->dataPersistor->clear('checkout_message');

                $redirect = $data['back'] ?? 'close';
                if ($redirect === 'close') {
                    return $resultRedirect->setPath('adminhtml/dashboard/');
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the message.'));
            }

            $this->dataPersistor->set('checkout_message', $data);
            return $resultRedirect->setPath('*/*/edit');
        }

        return $resultRedirect->setPath('adminhtml/dashboard/');
    }

    /**
     * Filter input data and normalize date fields.
     *
     * @param array $data
     * @return array
     */
    protected function normalizeData(array $data): array
    {
        if (!$this->getRequest()->getParam('message_id')) {
            $data['message_id'] = null;
        }

        if (!$this->getRequest()->getParam('from_date')) {
            $data['from_date'] = $this->timezone->formatDate();
        }

        $filterValues = [
            'from_date' => $this->dateFilter
        ];

        if ($this->getRequest()->getParam('to_date')) {
            $filterValues['to_date'] = $this->dateFilter;
        } else {
            $data['to_date'] = null;
        }

        $inputFilter = new \Zend_Filter_Input(
            $filterValues,
            [],
            $data
        );

        return $inputFilter->getUnescaped();
    }
}
