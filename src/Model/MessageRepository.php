<?php

/**
 * Checkout Message Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright Copyright (c) 2021 August Ash (https://www.augustash.com)
 */

namespace Augustash\CheckoutMessage\Model;

use Augustash\CheckoutMessage\Api\Data\MessageInterface;
use Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory;
use Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterface;
use Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterfaceFactory;
use Augustash\CheckoutMessage\Api\MessageRepositoryInterface;
use Augustash\CheckoutMessage\Model\ResourceModel\Message as MessageResource;
use Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;

/**
 * Checkout message CRUD class.
 *
 * @api
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * @var \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory
     */
    protected $messageFactory;

    /**
     * @var \Augustash\CheckoutMessage\Model\ResourceModel\Message
     */
    protected $messageResourceModel;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Augustash\CheckoutMessage\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Augustash\CheckoutMessage\Api\Data\MessageInterfaceFactory $messageFactory
     * @param \Augustash\CheckoutMessage\Model\ResourceModel\Message $messageResourceModel
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Augustash\CheckoutMessage\Api\Data\MessageSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        MessageCollectionFactory $messageCollectionFactory,
        MessageInterfaceFactory $messageFactory,
        MessageResource $messageResourceModel,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        MessageSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->messageFactory = $messageFactory;
        $this->messageResourceModel = $messageResourceModel;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(MessageInterface $message): MessageInterface
    {
        $messageModel = null;
        if ($message->getId()) {
            /** @var \Augustash\CheckoutMessage\Model\Message $messageModel */
            $messageModel = $this->getById($message->getId());
        }

        if ($messageModel === null || !$messageModel->getId()) {
            /** @var \Augustash\CheckoutMessage\Model\Message $messageModel */
            $messageModel = $this->messageFactory->create();
            $messageModel->setData($message->getData());
        } else {
            $messageModel->setData($message->getData());
        }

        try {
            $this->messageResourceModel->save($messageModel);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(new Phrase(
                'The "%1" message couldn\'t be saved.',
                [$message->getId()]
            ));
        }

        return $this->getById($messageModel->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id): MessageInterface
    {
        /** @var \Augustash\CheckoutMessage\Model\Message $messageModel */
        $messageModel = $this->messageFactory->create();
        $this->messageResourceModel->load($messageModel, $id);
        if (!$messageModel->getId()) {
            throw new NoSuchEntityException(new Phrase(
                'A checkout message with the "%1" specified ID was not found.',
                [$id]
            ));
        }

        return $messageModel;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): MessageSearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Augustash\CheckoutMessage\Model\ResourceModel\Message\Collection $collection */
        $collection = $this->messageCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection, MessageInterface::class);
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults->setTotalCount($collection->getSize());

        /** @var \Augustash\CheckoutMessage\Api\Data\MessageInterface[] $messages */
        $messages = [];
        /** @var \Augustash\CheckoutMessage\Model\Message $messageModel */
        foreach ($collection as $messageModel) {
            $messages[] = $messageModel;
        }
        $searchResults->setItems($messages);

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MessageInterface $message): bool
    {
        return $this->deleteById($message->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id): bool
    {
        $messageModel = $this->messageFactory->create()->load($id);
        $messageModel->delete();
        return true;
    }
}
