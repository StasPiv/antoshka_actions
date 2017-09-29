<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:53 AM
 */
class OpsWay_Actions_Model_Mysql4_Action_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
            /** @var array */
    private $availableFilters = array('age', 'label', 'type');

    private $requiredFilters = array('date', 'active');

    protected function _construct()
    {
        $this->_init('opsway_actions/action');

        $this->availableFilters[] =
            Mage::helper('opsway_actions')->getCurrentActionType() == OpsWay_Actions_Model_Action::OFFLINE_TYPE ?
            'category_offline' :
            'category_online';
    }

    protected function _initSelect()
    {
        $result = parent::_initSelect();

        if (Mage::getModel('smile_adminhtml/offlineManager')->isCurrentRole()) {
            $this->addFieldToFilter('type', OpsWay_Actions_Model_Action::OFFLINE_TYPE);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return int
     */
    public function getCountByParams($params)
    {
        foreach ($this->availableFilters as $filterName) {
            /** @var OpsWay_Actions_Model_Filter $filter */
            $filter = Mage::getModel('opsway_actions/filter_' . $filterName);

            if (!$filter instanceof OpsWay_Actions_Model_Filter) {
                continue;
            }

            if (isset($params[$filter->getRequiredParam()])) {
                $filter->setRequestData($params);
                $filter->applyFilterToCollection($this);
            }
        }

        foreach ($this->requiredFilters as $filterName) {
            /** @var OpsWay_Actions_Model_Filter $filter */
            $filter = Mage::getModel('opsway_actions/filter_' . $filterName);

            if (!$filter instanceof OpsWay_Actions_Model_Filter) {
                continue;
            }

            $filter->setRequestData($params);
            $filter->applyFilterToCollection($this);
        }

        return $this->getSize();
    }

}