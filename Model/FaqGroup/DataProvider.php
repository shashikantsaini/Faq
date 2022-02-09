<?php

namespace Bluethink\Faq\Model\FaqGroup;

use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    public $collection;
    /**
     * @var
     */
    protected $_loadedData;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * DataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $itemData) {
            $data = $itemData->getData();
            $this->_loadedData[$itemData->getFaqgroupId()] = $data;
            if ($itemData->getIcon()) {
                $img['icon'][0]['name'] = $itemData->getIcon();
                $img['icon'][0]['url'] = $this->getMediaUrl() . $itemData->getIcon();
                $img['icon'][0]['type'] = 'image';
                $fullData = $this->_loadedData;
                $this->_loadedData[$itemData->getFaqgroupId()] = array_merge(
                    $fullData[$itemData->getFaqgroupId()],
                    $img
                );
            }
        }
        echo "<pre>";
        print_r($this->_loadedData);die;
        return $this->_loadedData;
    }

    /**
     * Get media url
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'faq/tmp/icon/';
    }
}
