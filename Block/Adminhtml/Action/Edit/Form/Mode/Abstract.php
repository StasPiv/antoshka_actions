<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Abstract
 */
abstract class OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Abstract
{
    /**
     * @var OpsWay_Actions_Block_Adminhtml_Action_Edit_Form
     */
    protected $form;

    public function __construct(OpsWay_Actions_Block_Adminhtml_Action_Edit_Form $form)
    {
        $this->form = $form;
    }

    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldSet
     * @return mixed
     */
    abstract public function addFieldsToFieldSet(Varien_Data_Form_Element_Fieldset $fieldSet);
}