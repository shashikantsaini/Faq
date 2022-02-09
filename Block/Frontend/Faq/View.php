<?php

namespace Bluethink\Faq\Block\Frontend\Faq;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\LayoutInterface;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollection;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollection;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var FaqCollection
     */
    protected $faqCollection;

    /**
     * @var FaqGroupCollection
     */
    protected $faqGroupCollection;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FaqCollection $faqCollection
     * @param FaqGroupCollection $faqGroupCollection
     * @param StoreManagerInterface $storeManager
     * @param LayoutInterface $layout
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FaqCollection $faqCollection,
        FaqGroupCollection $faqGroupCollection,
        StoreManagerInterface $storeManager,
        LayoutInterface $layout,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->storeManager = $storeManager;
        $this->faqCollection = $faqCollection;
        $this->faqGroupCollection = $faqGroupCollection;
        $this->layout = $layout;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getFaqGroupCollection()
    {
        return $this->faqGroupCollection->create();
    }

    /**
     * @param $groupId
     * @return mixed
     */
    public function getFaqCollectionByGroupId($groupId)
    {
        return $this->getFaqCollection()->addFieldToFilter('group', ['eq' => $groupId]);
    }

    /**
     * @return mixed
     */
    public function getFaqCollection()
    {
        return $this->faqCollection->create();
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'faq/tmp/icon/';
    }

    /**
     * @return mixed
     */
    public function getUserFaqBlock()
    {
        return $this->layout
            ->createBlock(UserFaq::class)
            ->setTemplate('Bluethink_Faq::faq_add_new.phtml');
    }
}
