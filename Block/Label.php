<?php

class OpsWay_Actions_Block_Label extends Mage_Core_Block_Template
{
            /** @var  OpsWay_Actions_Model_Label_Container */
            /** @var  OpsWay_Actions_Block_Label_Mode_Abstract */
    private $labelContainer,
            $mode;

    /**
     * @return \OpsWay_Actions_Block_Label_Mode_Abstract
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param \OpsWay_Actions_Model_Label_Container $labelContainer
     */
    public function setLabelContainer(OpsWay_Actions_Model_Label_Container $labelContainer)
    {
        $this->labelContainer = $labelContainer;
        $this->initMode($labelContainer);
        return $this;
    }

    /**
     * @param OpsWay_Actions_Model_Label_Container $labelContainer
     */
    private function initMode(OpsWay_Actions_Model_Label_Container $labelContainer)
    {
        $product = $labelContainer->getLabel()->getProduct();
        if (isset($product)) {
            $this->mode = new OpsWay_Actions_Block_Label_Mode_Online();
        } else {
            $this->mode = new OpsWay_Actions_Block_Label_Mode_Offline();
        }

        $this->mode->setLabelBlock($this);
    }

    /**
     * @return \OpsWay_Actions_Model_Label_Container
     */
    public function getLabelContainer()
    {
        return $this->labelContainer;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->getMode()->getText();
    }

    /**
     * @return string
     */
    public function getStyle()
    {
        return $this->getMode()->getStyle();
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->getMode()->getCssClass();
    }

    public function getTemplate()
    {
        return 'opsway/actions/label.phtml';
    }

    protected function _toHtml()
    {
        if (!$this->getLabelContainer()->getLabel()->getId()) {
            return '';
        }

        return parent::_toHtml();
    }
}