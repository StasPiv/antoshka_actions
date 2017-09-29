<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/11/15
 * Time: 1:03 PM
 */
class OpsWay_Actions_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $actionCollectionKey = 'current_action_list';

    public function getCategoriesForMultipleSelect()
    {
        $values = array();

        foreach (Mage::getModel('opsway_actions/category')->getCollection()->toOptionHash() as $value => $label) {
            $values[] = array(
                'label' => $label,
                'value' => $value
            );
        }

        return $values;
    }

    /**
     * @return OpsWay_Actions_Model_Mysql4_Action_Collection
     */
    public function getActionCollection()
    {
        if (!Mage::registry($this->actionCollectionKey) instanceof OpsWay_Actions_Model_Mysql4_Action_Collection) {
            Mage::register($this->actionCollectionKey, Mage::getResourceModel('opsway_actions/action_collection'));
        }

        return Mage::registry($this->actionCollectionKey);
    }

    /**
     * @return int
     */
    public function getCurrentActionType()
    {
        return $this->_getRequest()->getActionName() == 'offline' ?
                OpsWay_Actions_Model_Action::OFFLINE_TYPE :
                OpsWay_Actions_Model_Action::ONLINE_TYPE;
    }

    public function addListActionBreadcrumb($type = OpsWay_Actions_Model_Action::OFFLINE_TYPE, $showUrl = false)
    {
        /** @var Mage_Page_Block_Html_Breadcrumbs $breadCrumbs */
        $breadCrumbs = Mage::app()->getLayout()->getBlock('breadcrumbs');
        $crumbTitle = $type == OpsWay_Actions_Model_Action::OFFLINE_TYPE ?
                      $this->__('Акции сети магазинов') :
                      $this->__('Акции интернет-магазина');

        $crumbInfo = array(
            'label' => $crumbTitle,
            'title' => $crumbTitle,
        );

        if ($showUrl) {
            $crumbInfo['link'] = Mage::getSingleton('core/session')->getLastFilterUrl();
        } else {
            Mage::getSingleton('core/session')->setLastFilterUrl(Mage::helper('core/url')->getCurrentUrl());
        }

        $breadCrumbs->addCrumb('section', $crumbInfo);
    }

    public function getAgeInMonths($ageFrontendValue)
    {
        if (preg_match('/лет|год/', $ageFrontendValue)) {
            return (int)$ageFrontendValue * 12;
        }

        return (int)$ageFrontendValue;
    }

    public function isArchive()
    {
        return in_array('opsway_actions_offers_offline_archive', Mage::app()->getLayout()->getUpdate()->getHandles());
    }
}