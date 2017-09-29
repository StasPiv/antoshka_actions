<?php

abstract class OpsWay_Actions_Block_Toolbar_List_Top_Abstract extends OpsWay_Actions_Block_Toolbar
{
    /**
     * @return OpsWay_Actions_Model_Filter_Category
     */
    abstract protected function getCategoryFilter();
}