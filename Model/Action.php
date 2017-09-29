<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:53 AM
 */

/**
 * Class OpsWay_Actions_Model_Action
 *
 * @method OpsWay_Actions_Model_Action setName(string $value)
 * @method string getName()
 * @method OpsWay_Actions_Model_Action setType(int $value)
 * @method int getType()
 * @method OpsWay_Actions_Model_Action setShortDescription(string $value)
 * @method string getShortDescription()
 * @method OpsWay_Actions_Model_Action setFullDescription(string $value)
 * @method string getFullDescription()
 * @method OpsWay_Actions_Model_Action setIsTopBanner(int $value)
 * @method int getIsTopBanner()
 * @method OpsWay_Actions_Model_Action setLabelId(int $value)
 * @method int getLabelId()
 * @method OpsWay_Actions_Model_Action setProductId(int $value)
 * @method int getProductId()
 * @method OpsWay_Actions_Model_Action setTieType(int $value)
 * @method int getTieType()
 * @method OpsWay_Actions_Model_Action setBundleOptionId(int $value)
 * @method int getBundleOptionId()
 * @method OpsWay_Actions_Model_Action setDateFrom(string $value)
 * @method string getDateFrom()
 * @method OpsWay_Actions_Model_Action setDateTo(string $value)
 * @method string getDateTo()
 * @method OpsWay_Actions_Model_Action setIsActive(int $value)
 * @method int getIsActive()
 * @method OpsWay_Actions_Model_Action setAgeFrom(int $value)
 * @method int getAgeFrom()
 * @method OpsWay_Actions_Model_Action setAgeTo(int $value)
 * @method int getAgeTo()
 * @method OpsWay_Actions_Model_Action setOrder(int $value)
 * @method int getOrder()
 * @method OpsWay_Actions_Model_Action setFullImagePath(string $value)
 * @method string getFullImagePath()
 * @method OpsWay_Actions_Model_Action setSmallImagePath(string $value)
 * @method string getSmallImagePath()
 * @method OpsWay_Actions_Model_Action setTopBannerImagePath(string $value)
 * @method string getTopBannerImagePath()
 * @method OpsWay_Actions_Model_Action setCategoryIds(array $value)
 * @method array getCategoryIds()
 * @method OpsWay_Actions_Model_Action setIsAutoCreated(bool $value)
 * @method bool getIsAutoCreated()
 */
class OpsWay_Actions_Model_Action extends Mage_Core_Model_Abstract
{
    const ONLINE_TYPE = 1;
    const OFFLINE_TYPE = 2;

    const IS_ACTIVE = 1;

    const TIE_TYPE_PRODUCT = 1;
    const TIE_TYPE_SET = 2;

    const MEDIA_DIR = 'opsway/actions';

            /** @var  OpsWay_Actions_Model_Label */
            /** @var Mage_Catalog_Model_Product */
    private $label,
            $product;

    protected function _construct()
    {
        $this->_init('opsway_actions/action');
    }

    public function getBundleSelections()
    {
        $bundleCollection = Mage::getModel('bundle/selection')->getCollection();

        $bundleCollection->addAttributeToFilter(
            array(
                array('attribute' => 'sku', 'eq' => $this->getProductId()),
                array('attribute' => 'entity_id', 'eq' => $this->getProductId())
            )
        );

        $bundleCollection->getSelect()
            ->join(
                array('bo' => 'catalog_product_bundle_option_value'),
                'selection.option_id = bo.option_id',
                array('title')
            );


        $hashMap = array();

        foreach ($bundleCollection as $bundle) {
            $hashMap[$bundle['option_id']] = $bundle['title'];
        }

        return $hashMap;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @param array $defaultData
     * @return bool
     * @throws Exception
     */
    public function updateOrCreateFromProduct(Mage_Catalog_Model_Product $product, $defaultData = array())
    {
        if ($product->getData('is_special_price_date_to') == '' && $product->getData('special_to_date') == '') {
            $this->log('Action with product_id ' . $product->getId() . ' is not special. Skip it', Zend_log::ERR);
            return;
        }

        /** @var OpsWay_Actions_Model_Action $action */
        $action = Mage::getModel('opsway_actions/action')->load($product->getId(), 'product_id');

        if ($action->getId() && strtotime($action->getDateTo()) < time()) {
            $this->log('Action with product_id ' . $product->getId() . ' already exists. Delete it', Zend_log::ERR);
            $action->delete();
            return;
        }

        if (isset($defaultData['label_id'])) {
            $action->setLabelId($defaultData['label_id']);
        }

        $action->setName($product->getName())
            ->setProductId($product->getId())
            ->setDateFrom(
                $product->getData('special_from_date') ?
                $product->getData('special_from_date') :
                Mage::getSingleton('core/date')->date()
            )
            ->setDateTo(
                $product->getData('is_special_price') ?
                $product->getData('is_special_price_date_to') :
                $product->getData('special_to_date')
            )
            ->setIsActive(
                $product->getResource()->getAttributeRawValue(
                    $product->getId(),
                    'status',
                    Mage::app()->getStore()->getId()
                ) == Mage_Catalog_Model_Product_Status::STATUS_ENABLED ? OpsWay_Actions_Model_Action::IS_ACTIVE : false
            )
            ->setAgeFrom(Mage::helper('opsway_actions')->getAgeInMonths($product->getAttributeText('age_from')))
            ->setAgeTo(Mage::helper('opsway_actions')->getAgeInMonths($product->getAttributeText('age_to')))
            ->setFullDescription($product->getDescription())
            ->setShortDescription($product->getShortDescription())
            ->setTieType(OpsWay_Actions_Model_Action::TIE_TYPE_PRODUCT)
            ->setIsAutoCreated(true);

        if ($action->save()) {
            $this->log('Action with product_id ' . $product->getId() . ' has been saved');
        }
    }

    /**
     * @param mixed $message
     * @param $level
     */
    private function log($message, $level = Zend_Log::INFO)
    {
        Mage::log($message, $level, 'opsway_actions.log');
    }

    /**
     * @param Mage_Catalog_Model_Resource_Product_Collection $productCollection
     * @param null $labelId
     */
    public function updateOrCreateFromProductCollection(
        Mage_Catalog_Model_Resource_Product_Collection $productCollection,
        $labelId = null
    )
    {
        try {
            $productCollection->addAttributeToSelect(
                array(
                    'name',
                    'is_special_price',
                    'is_special_price_date_to',
                    'special_from_date',
                    'special_to_date',
                    'status',
                    'age_from',
                    'age_to',
                    'description',
                    'short_description'
                )
            );
            $this->log('Found ' . $productCollection->count() . ' product(s). Try to save them');
            foreach ($productCollection as $product) {
                $this->updateOrCreateFromProduct($product, array('label_id' => $labelId));
            }
        } catch(Exception $e) {
            $this->log('Error with creating actions from action products', Zend_Log::ERR);
        }

    }

    /**
     * @param array $productIds
     */
    public function deactivateActionsIfProductIsNotFound($productIds = array())
    {
        $collection = $this->getCollection()
                           ->addFieldToFilter('product_id', array('nin' => $productIds))
                           ->addFieldToFilter('type', self::ONLINE_TYPE)
                           ->addFieldToFilter('is_auto_created', true);

        foreach ($collection as $action) {
            /** @var OpsWay_Actions_Model_Action $action */
            $this->log('Deactivate action with product_id ' . $action->getProductId());
            $action->setIsActive(false)
                   ->save();
        }
    }

    protected function _beforeSave()
    {
        if (Mage::getModel('smile_adminhtml/offlineManager')->isCurrentRole()) {
            $this->setType(self::OFFLINE_TYPE);
        }

        $this->saveImages();
        return parent::_beforeSave();
    }

    protected function _afterSave()
    {
        $this->saveCategoryIds();
        return parent::_afterSave();
    }

    private function saveImages()
    {
        Mage::getModel('opsway_actions/action_image')->uploadImages($this);
    }

    /**
     * @return bool
     */
    private function saveCategoryIds()
    {
        if (!is_array($this->getCategoryIds())) {
            return false;
        }

        Mage::getModel('opsway_actions/actInCat')->clearTableByAction($this);

        foreach ($this->getCategoryIds() as $categoryId) {
            if (!is_numeric($categoryId)) {
                continue;
            }

            Mage::getModel('opsway_actions/actInCat')->setCategoryId($categoryId)
                                                     ->setActionId($this->getId())
                                                     ->save();
        }

        return true;
    }

    protected function _afterLoad()
    {
        $this->setCategoryIds(
            array_map(
                function(OpsWay_Actions_Model_ActInCat $actInCat)
                {
                    return $actInCat->getCategoryId();
                },
                Mage::getModel('opsway_actions/actInCat')->loadCategoriesByAction($this)->getItems()
            )
        );

        return parent::_afterLoad();
    }

    /**
     * @return OpsWay_Actions_Model_Label
     */
    public function getLabel()
    {
        if (isset($this->label)) {
            return $this->label;
        }

        return $this->label = Mage::getModel('opsway_actions/label')->load($this->getLabelId(),'label_id');
    }

    public function getSmallImage()
    {
        return '/media' . DS . self::MEDIA_DIR . DS . $this->getSmallImagePath();
    }

    public function getFullImage()
    {
        return '/media' . DS . self::MEDIA_DIR . DS . $this->getFullImagePath();
    }


    /**
     * @param Mage_Catalog_Model_Product $product
     */
    public function setProduct(Mage_Catalog_Model_Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        if (!isset($this->product)) {
            $this->product = Mage::getModel('catalog/product')->load($this->getProductId());
            if (!$this->product->getId()) {
                Mage::throwException('There is no product for action ' . $this->getId());
            }
        }

        return $this->product;
    }
}