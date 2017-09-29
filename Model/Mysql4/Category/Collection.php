<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:34 AM
 */
class OpsWay_Actions_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('opsway_actions/category');
    }

    public function toOptionHash()
    {
        return $this->_toOptionHash('category_id', 'name_ru');
    }

}