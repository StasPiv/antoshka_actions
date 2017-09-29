<?php
/**
 * OpsWay extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the OpsWay Actions module to newer versions in the future.
 * If you wish to customize the OpsWay Actions module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   OpsWay
 * @package    OpsWay_Actions
 * @copyright  Copyright (C) 2015 OpsWay (http://opsway.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Best offers
 *
 * @category   OpsWay
 * @package    OpsWay_Actions
 * @subpackage Block
 * @author     Dmitry Buryak <dmbur@opsway.com>
 */
class OpsWay_Actions_Block_BestOffers extends Mage_Catalog_Block_Product_Abstract
{
    const ITEMS_COUNT = 4;

    /**
     * @var Varien_Data_Collection
     */
    private $bestOffers;

    /**
     * @var array
     */
    private $attributeOptions = array();

    /**
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        return $this->getLayout()->getBlock('catalog.leftnav')->getLayer();
    }

    /**
     * @return Varien_Data_Collection|Mage_Catalog_Model_Product[]
     */
    public function getBestOffers()
    {
        if (!$this->bestOffers) {
            $this->_initBestOffers('label');
        }
        return $this->bestOffers;
    }

    /**
     * @param string $attribute
     * @return void
     * @throws Exception
     */
    private function _initBestOffers($attribute)
    {
        $this->_initAttributeOptions($attribute);

        $collection = $this->bestOffers = $this->_cloneProductCollection();

        $collection->addAttributeToFilter($attribute, array('in' => $this->attributeOptions[$attribute]), 'left');
        $collection->getSelect()->order(new Zend_Db_Expr('RAND()'));

        $subSelect = new Varien_Db_Select($collection->getResource()->getReadConnection());
        $subSelect->from($collection->getSelect());
        $subSelect->group('label');
        $subSelect->limit(self::ITEMS_COUNT);

        $this->_replaceSelect($collection, $subSelect);

        $count = $collection->count();

        if ($count < self::ITEMS_COUNT) {
            $ids = array();
            foreach ($collection as $item) {
                $ids[] = $item->getId();
            }

            $collection = $this->_cloneProductCollection();
            $collection->addAttributeToFilter('entity_id', array('nin' => $ids));
            $collection->getSelect()
                ->order('price desc')
                ->order(new Zend_Db_Expr('RAND()'))
                ->group('entity_id')
                ->limit(self::ITEMS_COUNT - $count);

            foreach ($collection as $item) {
                $this->bestOffers->addItem($item);
            }
        }
    }

    /**
     * @param string $attribute
     * @return void
     * @throws Mage_Core_Exception
     */
    private function _initAttributeOptions($attribute)
    {
        $this->attributeOptions[$attribute] = array();
        if ($attributeInstance = Mage::getResourceModel('catalog/product')->getAttribute($attribute)) {
            $values = array_map(function($item) {
                return $item['value'];
            }, $attributeInstance->getSource()->getAllOptions());
            $this->attributeOptions[$attribute] = array_filter($values, function($value){
                return (bool) $value;
            });
        }
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    private function _cloneProductCollection()
    {
        $collection = clone $this->getLayer()->getProductCollection();
        $collection->clear(); // probably produces bug with stock items

        $this->_replaceSelect($collection);

        Mage::getResourceSingleton('antoshka_extended/product_collection')->addQtyFilter($collection);

        return $collection;
    }

    /**
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @param Zend_Db_Select                                            $select
     * @return void
     */
    private function _replaceSelect($collection, Zend_Db_Select $select = null)
    {
        if (!$select) {
            $select = clone $collection->getSelect()
                ->reset(Zend_Db_Select::ORDER)
                ->reset(Zend_Db_Select::LIMIT_COUNT)
                ->reset(Zend_Db_Select::LIMIT_OFFSET);
        }

        $reflectionClass = new ReflectionClass(get_class($collection));
        $property = $reflectionClass->getProperty('_select');
        $property->setAccessible(true);
        $property->setValue($collection, $select);
    }
}
