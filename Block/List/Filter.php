<?php

class OpsWay_Actions_Block_List_Filter extends Mage_Core_Block_Template
{
    /** @var OpsWay_Actions_Model_Filter[] */
    private $filters;

    /**
     * @return \OpsWay_Actions_Model_Filter[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param OpsWay_Actions_Model_Filter|string $filter
     * @param $isVisible bool
     */
    public function addFilter($filter, $isVisible = true)
    {
        if (is_string($filter)) {
            $filter = Mage::getModel('opsway_actions/filter_'.$filter);
        }

        $filter->setFilterBlock($this);
        $filter->setRequestData($this->getRequest()->getParams());
        $filter->applyFilterToCollection(Mage::helper('opsway_actions')->getActionCollection());
        $filter->setIsVisible($isVisible && count($filter->getItems()));

        if ($filter->isVisible()) {
            $this->filters[] = $filter;
        }
    }

    public function getCategoryId()
    {
        return (int)$this->getRequest()->getParam('category');
    }

    public function getSwitchArchiveUrl()
    {
        if (!Mage::helper('opsway_actions')->isArchive()) {
            return Mage::getUrl('actions/offers/offline/', array('date' => 'archive'));
        } else {
            return Mage::getUrl('actions/offers/offline/');
        }
    }

    public function getSwitchArchiveLabel()
    {
        if (!Mage::helper('opsway_actions')->isArchive()) {
            return 'К архиву';
        } else {
            return 'К активным';
        }
    }
}