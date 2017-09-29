<?php

abstract class OpsWay_Actions_Model_Filter
{
    private $ignoreParams = array('p');
    /** @var  OpsWay_Actions_Block_List_Filter */
    private $filterBlock;

    /** @var  array */
    protected $requestData;

    private $isVisible = false;

    /** @var  OpsWay_Actions_Model_Filter_Item[] */
    private $items;

    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    abstract public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection);

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return string
     */
    abstract public function getRequiredParam();

    /**
     * @return array
     */
    abstract public function getDataSource();

    /**
     * @param $item
     * @return bool
     */
    abstract public function isActiveItem($item);

    /**
     * @param $item
     * @return string
     */
    abstract public function getItemName($item);

    /**
     * @return array
     */
    abstract public function getParams($item);

    public function getAllFilterParams()
    {
        return (array)$this->getRequiredParam();
    }

    /**
     * @param $item
     */
    public function addItem($item)
    {
        $filterItem = Mage::getModel('opsway_actions/filter_item');

        $requestData = $this->requestData;

        foreach($this->ignoreParams as $ignoreParam) {
            if (isset($requestData[$ignoreParam])) {
                unset($requestData[$ignoreParam]);
            }
        }

        $params = (array)$this->getParams($item) + (array)$requestData;

        $filterItem->setCount(Mage::getModel('opsway_actions/action')->getCollection()->getCountByParams($params));
        $filterItem->setIsActive($this->isActiveItem($item));
        $filterItem->setName($this->getItemName($item));

        if ($filterItem->isActive()) {
            $filterItem->setUrl($this->getUrlWithoutCurrentFilter());
        } else {
            $filterItem->setUrl(Mage::getUrl('actions/offers/*', $params));
        }

        if ($filterItem->getCount()) {
            $this->items[] = $filterItem;
        }
    }

    public function addItemsFromSource()
    {
        foreach ($this->getDataSource() as $item) {
            $this->addItem($item);
        }

        return $this->items;
    }

    public function getItems()
    {
        if (isset($this->items)) {
            return $this->items;
        }

        return $this->addItemsFromSource();
    }

    /**
     * @return int
     */
    public function getAllActionCount()
    {
        return Mage::getResourceModel('opsway_actions/action_collection')
                    ->getCountByParams($this->getParamsWithoutFilter());
    }

    /**
     * @return array
     */
    private function getParamsWithoutFilter()
    {
        $params = $this->requestData;
        foreach (array_merge($this->getAllFilterParams(), $this->ignoreParams) as $filterParam) {
            unset($params[$filterParam]);
        }
        return $params;
    }

    public function getUrlWithoutCurrentFilter()
    {
        return Mage::getUrl('actions/*/*', $this->getParamsWithoutFilter());
    }

    public function isNoneChecked()
    {
        return !isset($this->requestData[$this->getRequiredParam()]);
    }

    /**
     * @param boolean $isVisible
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
    }

    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param array $requestData
     */
    public function setRequestData($requestData)
    {
        $requestData['type'] = Mage::helper('opsway_actions')->getCurrentActionType();

        $this->requestData = $requestData;
    }

    /**
     * @return array
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * @param \OpsWay_Actions_Block_List_Filter $filter
     */
    public function setFilterBlock($filter)
    {
        $this->filterBlock = $filter;
    }

    /**
     * @return \OpsWay_Actions_Block_List_Filter
     */
    public function getFilterBlock()
    {
        return $this->filterBlock;
    }
}