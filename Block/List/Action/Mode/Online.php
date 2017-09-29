<?php

class OpsWay_Actions_Block_List_Action_Mode_Online extends OpsWay_Actions_Block_List_Action_Mode_Abstract
{
    /** @var  Mage_Catalog_Model_Product */
    private $product;

    /**
     * @return OpsWay_Actions_Model_Label
     */
    public function getLabel()
    {
        if ($this->getActionBlock()->getCurrentAction()->getLabelId() &&
            $this->getActionBlock()->getCurrentAction()->getType() == OpsWay_Actions_Model_Action::OFFLINE_TYPE) {
            return $this->getActionBlock()->getCurrentAction()->getLabel();
        }

        $label = Mage::getModel('opsway_actions/label');
        $label->setId('online');
        $label->setProduct($this->getProduct());
        return $label;
    }

    public function setActionBlock($actionBlock)
    {
        parent::setActionBlock($actionBlock);
        $this->product = $actionBlock->getCurrentAction()->getProduct();
    }

    /**
     * @return \Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getAfterDescriptionText()
    {
        $buyBlock = $this->getActionBlock()->getLayout()->createBlock('opsway_actions/list_buy');
        $buyBlock->setActionMode($this);
        return $buyBlock->toHtml();
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getProduct()->getProductUrl();
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->getProduct()->getImageUrl();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getProduct()->getShortCharacteristics();
    }

    public function getBeforeDescriptionText()
    {
        if($this->getProduct()->getData('tm_id')) {
            return "<div class=\"product-brand-name\">Торговая марка: " .
                        $this->getProduct()->getResource()->getAttribute('tm_id')->getFrontend()->getValue($this->getProduct()) .
                    "</div><br />";
        }
    }

}