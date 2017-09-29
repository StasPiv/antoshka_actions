<?php

class OpsWay_Actions_Model_Filter_Date extends OpsWay_Actions_Model_Filter
{
    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (Mage::helper('opsway_actions')->isArchive()) {
            $this->applyFilterByArchiveActions($collection);
        } else {
            $this->applyFilterByActiveActions($collection);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'date';
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

    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     */
    private function applyFilterByActiveActions(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        $collection->getSelect()
            ->where('date_from <= ?', Mage::getModel('core/date')->date('Y-m-d'))
            ->where('date_to >= ?', Mage::getModel('core/date')->date('Y-m-d'));
    }

    /**
     * @param OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     */
    private function applyFilterByArchiveActions(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        $collection->getSelect()
            ->where('date_to < ? or is_active != 1', Mage::getModel('core/date')->date('Y-m-d'));
    }

}