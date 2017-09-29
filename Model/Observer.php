<?php

/**
 * Class OpsWay_Actions_Model_Observer
 */
class OpsWay_Actions_Model_Observer
{
    /**
     * On product after save
     *
     * @param Varien_Event_Observer $observer
     */
    public function updateAction(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer['product'];

        return Mage::getModel('opsway_actions/action')->updateOrCreateFromProduct($product);
    }

    public function controllerActionLayoutLoadBefore(Varien_Event_Observer $observer)
    {
        /** @var $layout Mage_Core_Model_Layout */
        $layout = $observer->getEvent()->getLayout();

        if (!in_array('opsway_actions_offers_offline',$layout->getUpdate()->getHandles())) {
            return false;
        }

        $layout->getUpdate()->addHandle(
            'opsway_actions_offers_offline_' . Mage::app()->getRequest()->getParam('date', 'active')
        );
    }
}