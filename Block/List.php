<?php

/**
 * Class OpsWay_Actions_Block_List
 *
 * @method OpsWay_Actions_Block_Toolbar getToolbarBlock()
 * @method OpsWay_Actions_Model_Mysql4_Action_Collection _getProductCollection()
 */
class OpsWay_Actions_Block_List extends Mage_Catalog_Block_Product_List
{
    public function __construct()
    {
        parent::__construct();
        $this->setCollection(Mage::helper('opsway_actions')->getActionCollection());
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('opsway_actions/list_pager', 'offers-product-list.pager')->setCollection(
            $this->_getProductCollection()
        );
        $this->setChild('pager', $pager);
        return $this;
    }

    public function getProductCollection()
    {
        return $this->_getProductCollection();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getToolbarBlockName()
    {
        return 'toolbar';
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     * @return string
     */
    public function getActionHtml(OpsWay_Actions_Model_Action $action)
    {
        /** @var OpsWay_Actions_Block_List_Action $actionBlock */
        $actionBlock = $this->getLayout()->createBlock('opsway_actions/list_action');
        $actionBlock->setCurrentAction($action);

        return $actionBlock->toHtml();
    }
}