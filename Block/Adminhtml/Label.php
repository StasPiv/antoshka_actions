<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Label
 * @todo translations
 */
class OpsWay_Actions_Block_Adminhtml_Label extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'opsway_actions';
        $this->_controller = 'adminhtml_label';
        $this->_headerText = Mage::helper('opsway_actions')->__('Action Labels');
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

