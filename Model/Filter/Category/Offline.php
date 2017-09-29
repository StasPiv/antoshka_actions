<?php

class OpsWay_Actions_Model_Filter_Category_Offline extends OpsWay_Actions_Model_Filter_Category
{
    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!isset($this->requestData['category'])) {
            return;
        }

        $collection->addFieldToFilter('type', OpsWay_Actions_Model_Action::OFFLINE_TYPE);

        $collection->getSelect()->join(
            array('act_in_cat' => 'opsway_actions_act_in_cat'),
            'act_in_cat.action_id = main_table.action_id AND act_in_cat.category_id = ' . $this->requestData['category'],
            array('act_in_cat_action_id' => 'action_id')
        );
    }

    /**
     * @return array
     */
    public function getDataSource()
    {
        return Mage::getResourceModel('opsway_actions/category_collection')->getItems();
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        /** @var OpsWay_Actions_Model_Category $item */
        return $item->getNameRu();
    }
}