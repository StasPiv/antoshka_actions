<?php

class OpsWay_Actions_OfferController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        /** @var OpsWay_Actions_Model_Action $action */
        $action = Mage::getModel('opsway_actions/action')->load($this->getRequest()->getParam('id'));

        if (!$action->getId()) {
            $this->_redirect('actions/offers/offline');
            return;
        }

        Mage::register('current_action', $action);
        $this->loadLayout();

        $this->addBreadCrumbs($action);
        $this->setMeta($action);

        $this->renderLayout();
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     */
    private function addBreadCrumbs(OpsWay_Actions_Model_Action $action)
    {
        Mage::helper('opsway_actions')->addListActionBreadcrumb($action->getType(), true);

        /** @var Mage_Page_Block_Html_Breadcrumbs $breadCrumbs */
        $breadCrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $breadCrumbs->addCrumb(
            'action',
            array(
                'label' => $action->getName(),
                'title' => $action->getName(),
                'link' => ''
            )
        );
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     */
    private function setMeta(OpsWay_Actions_Model_Action $action)
    {
        /** @var Mage_Page_Block_Html_Head $headBlock */
        $headBlock = $this->getLayout()->getBlock('head');

        $dateFromFormatted = Mage::getModel('core/date')->date('d.m.Y', strtotime($action->getDateFrom()));
        $dateToFormatted = Mage::getModel('core/date')->date('d.m.Y', strtotime($action->getDateTo()));

        $datesFormatted = $dateFromFormatted.'-'.$dateToFormatted;

        $headBlock->setTitle(
            "{$action->getName()} - акции в Антошке, срок действия акции: {$datesFormatted} - antoshka.ua"
        );
        $headBlock->setDescription("Акции в Антошке - {$action->getName()}. Срок действия акции: {$datesFormatted}");
        $headBlock->setKeywords("{$action->getName()}, антошка акции, акции в антошке, интернет-магазин антошка, antoshka.ua");
    }
}