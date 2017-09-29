<?php

class OpsWay_Actions_Helper_Filter_SpecialPrice extends OpsWay_Actions_Helper_Filter_Abstract
{
    /**
     * @return string
     */
    protected function getLabel()
    {
        return 'Специальная цена';
    }

    /**
     * @return array
     */
    protected function getProductIds()
    {
        return $this->getLabelModel()->getBestsellers()->getAllIds();
    }

}