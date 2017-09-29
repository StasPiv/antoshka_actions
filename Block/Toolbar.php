<?php

/**
 * Class OpsWay_Actions_Block_List_Toolbar
 *
 * @method OpsWay_Actions_Model_Mysql4_Action_Collection getCollection()
 */
abstract class OpsWay_Actions_Block_Toolbar extends Antoshka_Extended_Block_Catalog_Product_List_Toolbar
{
    public function getAvailableOrders()
    {
        $this->_availableOrder = array(
            'name' => Mage::helper('catalog')->__('Name'),
        );
        return $this->_availableOrder;
    }

    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return OpsWay_Actions_Block_Toolbar
     */
    public function setCollection($collection)
    {
        $this->setOrdersToCollection($collection);

        return parent::setCollection($collection);
    }

    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     */
    private function setOrdersToCollection($collection)
    {
        $collection->addOrder('main_table.order', OpsWay_Actions_Model_Mysql4_Action_Collection::SORT_ORDER_ASC);
        $collection->addOrder('action_id', OpsWay_Actions_Model_Mysql4_Action_Collection::SORT_ORDER_DESC);
    }
}