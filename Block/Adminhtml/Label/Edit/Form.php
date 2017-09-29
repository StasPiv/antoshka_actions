<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Label_Edit_Form
 * @todo translations
 */
class OpsWay_Actions_Block_Adminhtml_Label_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * @return mixed
     */
    protected function _getModel()
    {
        return Mage::registry('current_model');
    }

    /**
     * @return OpsWay_Actions_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('opsway_actions');
    }

    /**
     * @return string
     */
    protected function _getModelTitle()
    {
        return 'Label';
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset(
            'base_fieldset',
            array(
                'legend' => $this->_getHelper()->__("$modelTitle Information")
            )
        );

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField(
                $modelPk,
                'hidden',
                array(
                    'name' => $modelPk,
                )
            );
        }

        $fieldset->addField(
            'name',
            'text',
            array(
                'name' => 'name',
                'label' => Mage::helper('opsway_actions')->__('Label name'),
                'required' => true
            )
        );

        $fieldset->addField(
            'color',
            'text',
            array(
                'name' => 'color',
                'label' => Mage::helper('opsway_actions')->__('Label color'),
                'required' => true,
                'class' => 'color'
            )
        );


        if ($model) {
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
