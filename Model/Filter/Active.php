<?php

class OpsWay_Actions_Model_Filter_Active extends OpsWay_Actions_Model_Filter
{
    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!Mage::helper('opsway_actions')->isArchive()) {
            $collection->addFieldToFilter('is_active', true);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Active';
    }

    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'active';
    }

    /**
     * @return array
     */
    public function getDataSource()
    {
        return array();
    }

    /**
     * @param $item
     * @return bool
     */
    public function isActiveItem($item)
    {
        // TODO: Implement isActiveItem() method.
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        // TODO: Implement getItemName() method.
    }

    /**
     * @return array
     */
    public function getParams($item)
    {
        // TODO: Implement getParams() method.
    }

}