<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Action
 */
class OpsWay_Actions_Block_Adminhtml_Action extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'opsway_actions';
        $this->_controller = 'adminhtml_action';
        $this->_headerText = Mage::helper('opsway_actions')->__('Action Offers');
        parent::__construct();
    }
}