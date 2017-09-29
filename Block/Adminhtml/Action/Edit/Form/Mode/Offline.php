<?php

class OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Offline extends OpsWay_Actions_Block_Adminhtml_Action_Edit_Form_Mode_Abstract
{
    /**
     * @param Varien_Data_Form_Element_Fieldset $fieldSet
     * @return mixed
     */
    public function addFieldsToFieldSet(Varien_Data_Form_Element_Fieldset $fieldSet)
    {
        /**
         * @var $quote OpsWay_Actions_Model_Action
         */
        $quote = Mage::registry('current_quote');

        $helper = Mage::helper('opsway_actions');

        if ($quote->getId()) {
            $fieldSet->addField(
                'action_id',
                'hidden',
                array(
                    'name' => 'action_id',
                    'required' => true
                )
            );
        }

        $fieldSet->addField(
            'name',
            'text',
            array(
                'name' => 'name',
                'label' => $helper->__('Action name'),
                'required' => true
            )
        );

        $defaultValuesForSelect = array(
            array(
                'label' => $helper->__('No change'),
                'value' => 0
            )
        );

        $fieldSet->addField(
            'label_id',
            'select',
            array(
                'name' => 'label_id',
                'label' => $helper->__('Label'),
                'values' => $defaultValuesForSelect + Mage::getModel('opsway_actions/label')->getCollection(
                    )->toOptionHash()
            )
        );

        $fieldSet->addField(
            'category_ids',
            'multiselect',
            array(
                'name' => 'category_ids[]',
                'label' => $helper->__('Category'),
                'values' => $helper->getCategoriesForMultipleSelect()
            )
        );

        $fieldSet->addField(
            'is_top_banner',
            'select',
            array(
                'name' => 'is_top_banner',
                'label' => $helper->__('Is Top Banner'),
                'values' => array($helper->__('No'), $helper->__('Yes'))
            )
        );

        $fieldSet->addField(
            'short_description',
            'editor',
            array(
                'name' => 'short_description',
                'label' => Mage::helper('opsway_actions')->__('Short description'),
                'title' => Mage::helper('opsway_actions')->__('Short description'),
                'style' => 'height:16em;',
                'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                'required' => true
            )
        );

        $fieldSet->addField(
            'full_description',
            'editor',
            array(
                'name' => 'full_description',
                'label' => Mage::helper('opsway_actions')->__('Full description'),
                'title' => Mage::helper('opsway_actions')->__('Full description'),
                'style' => 'height:36em;',
                'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                'required' => true
            )
        );

        $dateFormatIso = 'y-MM-dd';

        $fieldSet->addField(
            'date_from',
            'date',
            array(
                'name' => 'date_from',
                'label' => $helper->__('Date From'),
                'image' => $this->form->getSkinUrl('images/grid-cal.gif'),
                'required' => true,
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso
            )
        );

        $fieldSet->addField(
            'date_to',
            'date',
            array(
                'name' => 'date_to',
                'label' => $helper->__('Date To'),
                'image' => $this->form->getSkinUrl('images/grid-cal.gif'),
                'required' => true,
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso
            )
        );

        $fieldSet->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => $helper->__('Is Active'),
                'values' => array($helper->__('No'), $helper->__('Yes'))
            )
        );

        $fieldSet->addField(
            'age_from',
            'text',
            array(
                'name' => 'age_from',
                'label' => $helper->__('Age from')
            )
        );

        $fieldSet->addField(
            'age_to',
            'text',
            array(
                'name' => 'age_to',
                'label' => $helper->__('Age to')
            )
        );

        if ($quote->getId()) {
            $fieldSet->addField(
                'order',
                'text',
                array(
                    'name' => 'order',
                    'label' => $helper->__('Order')
                )
            );
        }

        $fieldSet->addField(
            'small_image_path',
            'file',
            array(
                'name' => 'small_image_path',
                'label' => $helper->__('Small image')
            )
        );

        $fieldSet->addField(
            'full_image_path',
            'file',
            array(
                'name' => 'full_image_path',
                'label' => $helper->__('Full image')
            )
        );
    }

}