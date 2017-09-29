<?php

/**
 * Class OpsWay_Actions_Block_Action
 *
 */
class OpsWay_Actions_Block_Action extends Mage_Catalog_Block_Product_Abstract implements OpsWay_Actions_Model_Action_Container, OpsWay_Actions_Model_Label_Container
{
            /** @var OpsWay_Actions_Model_Action  */
    private $action,
            /** @var OpsWay_Actions_Model_Label */
            $label;

    public function setCurrentAction(OpsWay_Actions_Model_Action $action)
    {
        $this->action = $action;
        return $this;
    }

    public function setLabel(OpsWay_Actions_Model_Label $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return OpsWay_Actions_Model_Action
     */
    public function getCurrentAction()
    {
        if (isset($this->action)) {
            return $this->action;
        }

        return Mage::registry('current_action');
    }

    /**
     * @return OpsWay_Actions_Model_Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function getTickerHtml()
    {
        /** @var OpsWay_Actions_Block_Ticker $ticker */
        $ticker = $this->getLayout()->createBlock('opsway_actions/ticker');
        $ticker->setActionContainer($this);

        return $ticker->toHtml();
    }

}