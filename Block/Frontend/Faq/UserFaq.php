<?php

namespace Bluethink\Faq\Block\Frontend\Faq;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollection;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollection;

class UserFaq extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

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

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FaqCollection $faqCollection,
        FaqGroupCollection $faqGroupCollection,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->storeManager = $storeManager;
        $this->faqCollection = $faqCollection;
        $this->faqGroupCollection = $faqGroupCollection;
        parent::__construct($context, $data);
    }

    public function getFaqCollection()
    {
        $collection = $this->faqCollection->create();
        return $collection;
    }

    /**
     * @return mixed
     */
    public function getFaqGroupCollection()
    {
        $collection = $this->faqGroupCollection->create();
        return $collection;
    }
}
