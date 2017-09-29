<?php

class OpsWay_Actions_Block_Label_Mode_Online extends OpsWay_Actions_Block_Label_Mode_Abstract
{
            /** @var  OpsWay_Actions_Model_Label  */
    private $label;

    /**
     * @return \OpsWay_Actions_Model_Label
     */
    public function getLabel()
    {
        if (isset($this->label)) {
            return $this->label;
        }

        return $this->label = $this->getLabelBlock()->getLabelContainer()->getLabel();
    }

    public function getCssClass()
    {
        $label = $this->getLabel();

        if ($label->isSale()) {
            return 'offer_sale';
        } elseif ($label->isSpecialPrice()) {
            return 'offer_special-price';
        } elseif ($label->isNovelty()) {
            return 'offer_new';
        } elseif ($label->isBestseller()) {
            return 'offer_bestseller';
        }

        return '';
    }

    protected function getColor()
    {
        return '';
    }

    public function getText()
    {
        $label = $this->getLabel();

        if ($label->getName()) {
            return $label->getName();
        }

        if ($label->isSale()) {
            return 'Скидка';
        } elseif ($label->isSpecialPrice()) {
            return 'Спец. цена';
        } elseif ($label->isNovelty()) {
            return 'Новинка';
        } elseif ($label->isBestseller()) {
            return 'Хит продаж';
        }

        return '';
    }

    public function getStyle()
    {
        return '';
    }

}