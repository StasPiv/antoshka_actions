<?php

class OpsWay_Actions_Helper_Filter_Sale extends OpsWay_Actions_Helper_Filter_Abstract
{
    /**
     * @return string
     */
    protected function getLabel()
    {
        return 'Скидка';
    }

    /**
     * @return array
     */
    protected function getProductIds()
    {
        return $this->getLabelModel()->getSpecialPriceProducts()->getAllIds();
    }

}