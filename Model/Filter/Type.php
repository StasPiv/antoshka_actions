<?php

class OpsWay_Actions_Model_Filter_Type extends OpsWay_Actions_Model_Filter
{
    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!isset($this->requestData['type'])) {
            return;
        }

        $collection->addFieldToFilter('type', $this->requestData['type']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Type';
    }

    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'type';
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
        return false;
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        return 'item name';
    }

    /**
     * @return array
     */
    public function getParams($item)
    {
        return array();
    }

}