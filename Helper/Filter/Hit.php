<?php

class OpsWay_Actions_Helper_Filter_Hit extends OpsWay_Actions_Helper_Filter_Abstract
{
    /**
     * @return string
     */
    protected function getLabel()
    {
        return 'Хит продаж';
    }

    /**
     * @return array
     */
    protected function getProductIds()
    {
        return $this->getLabelModel()->getHits()->getAllIds();
    }

}