<?php

interface OpsWay_Actions_Model_Label_Container
{
    public function setLabel(OpsWay_Actions_Model_Label $label);

    /**
     * @return OpsWay_Actions_Model_Label
     */
    public function getLabel();
}