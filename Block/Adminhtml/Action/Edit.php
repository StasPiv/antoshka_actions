<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Action_Edit
 */
class OpsWay_Actions_Block_Adminhtml_Action_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * @var string
     */
    /**
     * @var string
     */
    /**
     * @var string
     */
    protected $_objectId = 'action_id',
        $_blockGroup = 'opsway_actions',
        $_controller = 'adminhtml_action';

    public function __construct()
    {
        parent::__construct();

        $actionId = (int)$this->getRequest()->getParam($this->_objectId);
        $quote = Mage::getModel('opsway_actions/action')->load($actionId);
        Mage::register('current_quote', $quote);

        $this->_addButton(
            'save_and_continue',
            array(
                'label' => Mage::helper('opsway_actions')->__('Save and Continue Edit'),
                'onclick' => "editForm.submit($('edit_form').action + 'back/edit/')",
                'class' => 'save'
            ),
            0,
            99
        );
    }

    /**
     * @return OpsWay_Actions_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('opsway_actions');
    }

    /**
     * @return OpsWay_Actions_Model_Action
     */
    protected function _getModel()
    {
        return Mage::registry('current_quote');
    }

    /**
     * @return string
     */
    protected function _getModelTitle()
    {
        return 'Action';
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle") . $this->_getHelper()->__(" (ID: {$model->getId()})");
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }
}