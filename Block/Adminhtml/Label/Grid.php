<?php

/**
 * Class OpsWay_Actions_Block_Adminhtml_Label_Grid
 * @todo translations
 */
class OpsWay_Actions_Block_Adminhtml_Label_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Label_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('opsway_actions/label')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Label_Grid
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('opsway_actions');

        $this->addColumn(
            'name',
            array(
                'header' => $helper->__('Label Name'),
                'index' => 'name'
            )
        );

        $this->addColumn(
            'color',
            array(
                'header' => $helper->__('Label color'),
                'index' => 'color'
            )
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));
        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * @return OpsWay_Actions_Block_Adminhtml_Label_Grid
     */
    protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('opsway_actions/label')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => $this->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
            )
        );
        return $this;
    }
}
