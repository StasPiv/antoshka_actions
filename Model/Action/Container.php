<?php

interface OpsWay_Actions_Model_Action_Container
{
    public function setCurrentAction(OpsWay_Actions_Model_Action $action);

    /**
     * @return OpsWay_Actions_Model_Action
     */
    public function getCurrentAction();
}