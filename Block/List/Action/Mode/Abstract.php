<?php

/**
 * Class OpsWay_Actions_Block_List_Action_Mode_Abstract
 */
abstract class OpsWay_Actions_Block_List_Action_Mode_Abstract extends Mage_Core_Block_Template
{
    /** @var  OpsWay_Actions_Block_List_Action */
    protected $actionBlock;

    /**
     * @param \OpsWay_Actions_Block_List_Action $actionBlock
     */
    public function setActionBlock($actionBlock)
    {
        $this->actionBlock = $actionBlock;
    }

    /**
     * @return \OpsWay_Actions_Block_List_Action
     */
    public function getActionBlock()
    {
        if (!$this->actionBlock instanceof OpsWay_Actions_Block_List_Action) {
            Mage::throwException('Action block must be OpsWay_Actions_Block_List_Action');
        }

        return $this->actionBlock;
    }

    /**
     * @return string
     */
    abstract public function getAfterDescriptionText();

    /**
     * @return string
     */
    abstract public function getActionUrl();

    /**
     * @return string
     */
    abstract public function getImage();

    /**
     * @return string
     */
    abstract public function getDescription();

    /**
     * @return OpsWay_Actions_Model_Label
     */
    abstract public function getLabel();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getActionBlock()->getCurrentAction()->getName();
    }

    abstract public function getBeforeDescriptionText();
}