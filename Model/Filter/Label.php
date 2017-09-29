<?php

class OpsWay_Actions_Model_Filter_Label extends OpsWay_Actions_Model_Filter
{
    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!isset($this->requestData['label'])) {
            return;
        }

        $collection->addFieldToFilter('label_id', $this->requestData['label']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Предложения';
    }

    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'label';
    }

    /**
     * @return array
     */
    public function getDataSource()
    {
        return Mage::getModel('opsway_actions/label')->getCollection()->getItems();
    }

    /**
     * @param $item
     * @return bool
     */
    public function isActiveItem($item)
    {
        /** @var OpsWay_Actions_Model_Label $item */
        return @$this->requestData['label'] == $item->getId();
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        /** @var OpsWay_Actions_Model_Label $item */
        return $item->getName();
    }

    /**
     * @return array
     */
    public function getParams($item)
    {
        /** @var OpsWay_Actions_Model_Label $item */
        return array('label' => $item->getId());
    }

}