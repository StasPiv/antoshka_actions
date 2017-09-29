<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Action_Grid
 */
class OpsWay_Actions_Block_Adminhtml_Action_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('opsway_actions_grid');
        $this->setDefaultSort('action_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Action_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('opsway_actions/action_collection');

        $this->setCollection($collection);

        $this->hideAutoCreatedActions();

        return parent::_prepareCollection();
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Action_Grid
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('opsway_actions');

        $this->addColumn(
            'action_id',
            array(
                'header' => $helper->__('#'),
                'index' => 'action_id'
            )
        );

        $this->addColumn(
            'name',
            array(
                'header' => $helper->__('Action Name'),
                'index' => 'name'
            )
        );

        $this->addColumn(
            'is_auto_created',
            array(
                'header' => $helper->__('Is auto created'),
                'index' => 'is_auto_created'
            )
        );

        return parent::_prepareColumns();
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Action_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('action_id');
        $this->getMassactionBlock()->setFormFieldName('action');

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('opsway_actions')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('opsway_actions')->__('Are you sure?')
            )
        );

        return $this;
    }

    /**
     * @param OpsWay_Actions_Model_Action $row
     * @return string
     */
    public function getRowUrl(OpsWay_Actions_Model_Action $row)
    {
        return $this->getUrl('*/*/edit', array('action_id' => $row->getId()));
    }

    private function hideAutoCreatedActions()
    {
        $filter = $this->getParam('filter');
        $filterData = Mage::helper('adminhtml')->prepareFilterString($filter);

        if (!isset($filterData['is_auto_created'])) {
            $this->getCollection()->addFieldToFilter('is_auto_created', 0);
        }
    }
}