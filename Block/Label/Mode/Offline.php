<?php

class OpsWay_Actions_Block_Label_Mode_Offline extends OpsWay_Actions_Block_Label_Mode_Abstract
{
    const PADDING_TOP_FOR_TWO_WORDS = 15;
    const PADDING_TOP_FOR_ONE_WORD = 21;

    protected function getColor()
    {
        return $this->getLabelBlock()->getLabelContainer()->getLabel()->getColor();
    }

    public function getCssClass()
    {
        return 'offer_special-price';
    }

    public function getText()
    {
        return $this->getLabelBlock()->getLabelContainer()->getLabel()->getName();
    }

    public function getStyle()
    {
        $paddingTop = strpos($this->getText(),' ') !== false ?
                      self::PADDING_TOP_FOR_TWO_WORDS :
                      self::PADDING_TOP_FOR_ONE_WORD;
        return parent::getStyle() . ' padding-top:' . $paddingTop . 'px;';
    }

}