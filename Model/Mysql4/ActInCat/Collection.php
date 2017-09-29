<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:59 AM
 */
class OpsWay_Actions_Model_Mysql4_ActInCat_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('opsway_actions/actInCat');
    }

    /**
     * @param OpsWay_Actions_Model_Category $category
     */
    public function getActionCountByCategory(OpsWay_Actions_Model_Category $category)
    {
        $this->getSelect()->join(array('act' => 'opsway_actions'), 'act.action_id = main_table.action_id');
        return $this->addFieldToFilter('category_id', $category->getId())->getSize();
    }

}