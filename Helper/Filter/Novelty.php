<?php

class OpsWay_Actions_Helper_Filter_Novelty extends OpsWay_Actions_Helper_Filter_Abstract
{
    /**
     * @return string
     */
    protected function getLabel()
    {
        return 'Новинка';
    }

    /**
     * @return array
     */
    protected function getProductIds()
    {
        return $this->getLabelModel()->getNewProducts()->getAllIds();
    }

}