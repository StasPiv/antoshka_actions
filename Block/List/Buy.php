<?php

class OpsWay_Actions_Block_List_Buy extends Mage_Core_Block_Template
{
    /** @var OpsWay_Actions_Block_List_Action_Mode_Online */
    private $actionMode;

    /**
     * @param \OpsWay_Actions_Block_List_Action_Mode_Online $actionMode
     */
    public function setActionMode($actionMode)
    {
        $this->actionMode = $actionMode;
    }

    /**
     * @return \OpsWay_Actions_Block_List_Action_Mode_Online
     */
    public function getActionMode()
    {
        return $this->actionMode;
    }

    public function getTemplate()
    {
        return 'opsway/actions/buy.phtml';
    }

    /**
     * @param bool $displayMinimalPrice
     * @param string $idSuffix
     * @internal param \Mage_Catalog_Model_Product $product
     * @return string
     */
    public function getPriceHtml($displayMinimalPrice = false, $idSuffix = '')
    {
        return $this->getActionMode()->getActionBlock()->getPriceHtml(
            $this->getActionMode()->getProduct(),
            $displayMinimalPrice,
            $idSuffix
        );
    }

    public function getAddToCartUrl()
    {
        $action = $this->getActionMode()->getActionBlock()->getCurrentAction();

        if ($action->getBundleOptionId()) {
            return $this->getUrlForBundle($action);
        }

        return $this->getActionMode()->getActionBlock()->getAddToCartUrl($this->getActionMode()->getProduct());
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     * @return string
     *
     * TODO: bad function, too many queries, need to optimize this functionality
     */
    private function getUrlForBundle($action)
    {
        $bundleOption = Mage::getModel('bundle/option')->load($action->getBundleOptionId());
        $product = Mage::getModel('catalog/product')->load($bundleOption->getParentId());

        $bundleSelections = Mage::getModel('bundle/selection')->getCollection();
        $bundleSelections->getSelect()->where('option_id = ?', $action->getBundleOptionId());

        return $this->getActionMode()->getActionBlock()->getAddToCartUrl($product) .
            '?' . implode(
            '&',
            array_map(
                function ($selection) {
                    return "bundle_option[" . $selection->getData('option_id') . "][]=" .
                           $selection->getData('selection_id');
                },
                $bundleSelections->getItems()
            )
        );
    }
}