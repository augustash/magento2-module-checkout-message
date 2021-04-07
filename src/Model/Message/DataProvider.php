<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model\Message;

use Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Global message data provider.
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData = [];

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        MessageCollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get message data.
     *
     * @return array
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $message = $this->collection->getFirstItem();
        if ($message->getId()) {
            $this->loadedData[$message->getId()] = $message->getData();
        }

        $data = $this->dataPersistor->get('checkout_message');
        if (!empty($data)) {
            $message = $this->collection->getNewEmptyItem();
            $message->setData($data);
            $this->loadedData[$message->getId()] = $message->getData();
            $this->dataPersistor->clear('checkout_message');
        }

        return $this->loadedData;
    }
}
