<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Action_Edit_Form
 */
class OpsWay_Actions_Block_Adminhtml_Action_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @var OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Abstract
     */
    private $mode;

    /**
     * @return \OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Abstract
     */
    public function getMode()
    {
        if (isset($this->mode)) {
            return $this->mode;
        }

        if (Mage::getModel('smile_adminhtml/offlineManager')->isCurrentRole()) {
            $this->mode = new OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Offline($this);
        } else {
            $this->mode = new OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Admin($this);
        }

        return $this->mode;
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $return;
    }

    /**
     *
     */
    protected function _prepareForm()
    {
        /**
         * @var $quote OpsWay_Actions_Model_Action
         */
        $quote = Mage::registry('current_quote');

        $form = new Varien_Data_Form(
            array(
                'enctype' => 'multipart/form-data'
            )
        );

        $helper = Mage::helper('opsway_actions');

        $fieldset = $form->addFieldset(
            'edit_quote',
            array(
                'legend' => $helper->__('Action Details'),
                'class' => 'fieldset-wide',
            )
        );

        $this->getMode()->addFieldsToFieldSet($fieldset);


        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setValues($quote->getData());

        $this->setForm($form);
    }
}