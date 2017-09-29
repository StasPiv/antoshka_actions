<?php

abstract class OpsWay_Actions_Block_Label_Mode_Abstract
{
    /** @var  OpsWay_Actions_Block_Label */
    private $labelBlock;

    /**
     * @param \OpsWay_Actions_Block_Label $labelBlock
     */
    public function setLabelBlock($labelBlock)
    {
        $this->labelBlock = $labelBlock;
    }

    /**
     * @return \OpsWay_Actions_Block_Label
     */
    public function getLabelBlock()
    {
        return $this->labelBlock;
    }

    public function getStyle()
    {
        if ($this->getCssClass() == '') {
            return 'display:none;';
        }

        return 'background-color: #' . $this->getColor().';';
    }

    abstract protected function getColor();

    abstract public function getText();

    abstract public function getCssClass();
}