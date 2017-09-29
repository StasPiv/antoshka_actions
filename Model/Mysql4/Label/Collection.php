<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:56 AM
 */
class OpsWay_Actions_Model_Mysql4_Label_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('opsway_actions/label');
    }

    public function toOptionHash()
    {
        return $this->_toOptionHash('label_id', 'name');
    }
}