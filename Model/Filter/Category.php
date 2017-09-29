<?php

abstract class OpsWay_Actions_Model_Filter_Category extends OpsWay_Actions_Model_Filter
{
    /**
     * @return string
     */
    public function getRequiredParam()
    {
        return 'category';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'По категории';
    }

    /**
     * @param $item
     * @return bool
     */
    public function isActiveItem($item)
    {
        /** @var Varien_Object $item */
        return $item->getId() == @$this->requestData['category'];
    }

    /**
     * @return array
     */
    public function getParams($item)
    {
        /** @var Varien_Object $item */
        return array('category' => $item->getId());
    }
}