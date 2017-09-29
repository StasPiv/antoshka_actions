<?php

abstract class OpsWay_Actions_Helper_Filter_Abstract extends Mage_Core_Helper_Abstract
{
    const ATTRIBUTE_CODE = 'label';

    /**
     * @return string
     */
    abstract protected function getLabel();

    /**
     * @return array
     */
    abstract protected function getProductIds();

    public function assign()
    {
        $this->assignLabelToProducts($this->getLabel(), $this->getProductIds());
    }

    /**
     * @param string $label
     * @param array $productIds
     * @throws Mage_Core_Exception
     */
    private function assignLabelToProducts($label, $productIds)
    {
        $attribute = Mage::getModel('catalog/product')->getResource()->getAttribute(self::ATTRIBUTE_CODE);
        if ($attribute->usesSource()) {
            $optionId = $attribute->getSource()->getOptionId($label);
        } else {
            return;
        }

        $attributeId = Mage::getModel('eav/entity_attribute')->loadByCode(4, self::ATTRIBUTE_CODE)->getAttributeId();

        $values = $valuesForIndex = array();
        foreach ($productIds as $entityId) {
            $values[] = '(' . implode(',', array(4,$attributeId,0,$entityId,$optionId)) . ')';
            $valuesForIndex[] = '(' . implode(',', array($entityId,$attributeId,1,$optionId)) . ')';
        }

        $this->getConnection()->query(
            "REPLACE INTO catalog_product_entity_int(entity_type_id, attribute_id, store_id, entity_id, value)
            VALUES " . implode(',', $values)
        );

        $this->getConnection()->query(
            "REPLACE INTO catalog_product_index_eav(entity_id, attribute_id, store_id, value)
            VALUES " . implode(',', $valuesForIndex)
        );
    }

    public static function clearLabels()
    {
        $attributeId = Mage::getModel('eav/entity_attribute')->loadByCode(4, self::ATTRIBUTE_CODE)->getAttributeId();
        self::getConnection()->query(
            "DELETE FROM catalog_product_entity_int WHERE attribute_id = $attributeId"
        );
        self::getConnection()->query(
            "DELETE FROM catalog_product_index_eav WHERE attribute_id = $attributeId"
        );
    }

    /**
     * @return OpsWay_Actions_Model_Resource_Setup_ActionProducts
     */
    protected function getLabelModel()
    {
        return Mage::getModel('opsway_actions/resource_setup_actionProducts');
    }

    private static function getConnection()
    {
        return Mage::getSingleton('core/resource')->getConnection('core_write');
    }
}