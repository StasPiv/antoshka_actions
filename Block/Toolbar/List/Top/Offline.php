<?php

class OpsWay_Actions_Block_Toolbar_List_Top_Offline extends OpsWay_Actions_Block_Toolbar_List_Top_Abstract
{
    const LIMIT = 5;

    public function getLimit()
    {
        return self::LIMIT;
    }

    /**
     * @return OpsWay_Actions_Model_Filter_Category_Offline
     */
    protected function getCategoryFilter()
    {
        return Mage::helper('opsway_actions/filter_category_offline');
    }

    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return OpsWay_Actions_Block_Toolbar_List_Top_Offline
     */
    public function setCollection($collection)
    {
        $collection->addFieldToFilter('type', OpsWay_Actions_Model_Action::OFFLINE_TYPE);
        return parent::setCollection($collection);
    }
}