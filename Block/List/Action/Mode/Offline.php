<?php

class OpsWay_Actions_Block_List_Action_Mode_Offline extends OpsWay_Actions_Block_List_Action_Mode_Abstract
{
    /**
     * @return OpsWay_Actions_Model_Label
     */
    public function getLabel()
    {
        return $this->getActionBlock()->getCurrentAction()->getLabel();
    }

    /**
     * @return string
     */
    public function getAfterDescriptionText()
    {
        return '<div class="more"><a href="' . $this->getActionUrl() . '">' . Mage::helper('opsway_actions')->__('more') . '</a></div>';
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return Mage::getUrl('actions/offer/index', array('id' => $this->getActionBlock()->getCurrentAction()->getId()));
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->getActionBlock()->getCurrentAction()->getSmallImage();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getActionBlock()->getCurrentAction()->getShortDescription();
    }

    public function getBeforeDescriptionText()
    {
        return '';
    }

}