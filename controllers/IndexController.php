<?php

class OpsWay_Actions_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->_redirect('actions/offers/online');
    }
}