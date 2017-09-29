<?php

class OpsWay_Actions_OffersController extends Mage_Core_Controller_Front_Action
{
    public function offlineAction()
    {
        $this->loadLayout();

        Mage::helper('opsway_actions')->addListActionBreadcrumb();

        $this->renderLayout();
    }

    public function onlineAction()
    {
        $this->loadLayout();

        Mage::helper('opsway_actions')->addListActionBreadcrumb(OpsWay_Actions_Model_Action::ONLINE_TYPE);

        $this->renderLayout();
    }
}