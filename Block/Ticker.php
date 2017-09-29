<?php

class OpsWay_Actions_Block_Ticker extends Mage_Core_Block_Template
{
            /** @var  OpsWay_Actions_Model_Action_Container */
    private $actionContainer;

    /**
     * @param \OpsWay_Actions_Model_Action_Container $actionContainer
     */
    public function setActionContainer(OpsWay_Actions_Model_Action_Container $actionContainer)
    {
        $this->actionContainer = $actionContainer;
        return $this;
    }

    /**
     * @return \OpsWay_Actions_Model_Action_Container
     */
    public function getActionContainer()
    {
        return $this->actionContainer;
    }

    public function getRemainingTime()
    {
        return strtotime($this->getActionContainer()->getCurrentAction()->getDateTo()) + 3600 * 24 - Mage::getModel('core/date')->timestamp();
    }

    public function getTemplate()
    {
        return $this->getRemainingTime() < 0 ? 'opsway/actions/ticker_for_archive.phtml' : 'opsway/actions/ticker.phtml';
    }

    public function getFormattedDate($date)
    {
        return Mage::getModel('core/date')->date('d.m.Y', strtotime($date));
    }
}