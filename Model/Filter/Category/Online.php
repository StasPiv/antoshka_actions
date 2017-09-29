<?php

class OpsWay_Actions_Model_Filter_Category_Online extends OpsWay_Actions_Model_Filter_Category
{
    const SHOWCASE_ATTRIBUTE_ID = 358;
    const MAIN_CATEGORY_1_ID = 462;

    /**
     * @param \OpsWay_Actions_Model_Mysql4_Action_Collection $collection
     * @return mixed
     */
    public function applyFilterToCollection(OpsWay_Actions_Model_Mysql4_Action_Collection $collection)
    {
        if (!isset($this->requestData['category'])) {
            return;
        }

        $collection
            ->getSelect()
            ->join(
                array('main_category_1' => 'catalog_product_entity_int'),
                'main_category_1.entity_id = main_table.product_id
                  AND main_category_1.attribute_id = ' . self::MAIN_CATEGORY_1_ID .
                ' AND main_category_1.value = ' . $this->requestData['category'],
                array()
            );
    }

    /**
     * @return array
     */
    public function getDataSource()
    {
        $categoryCollection = Mage::getResourceModel('catalog/category_collection')
            ->addFieldToFilter('level', 2)
            ->addAttributeToSelect(
                array(
                    'name'
                )
            );

        $categoryCollection->getSelect()->join(
            array('showcase' => 'catalog_category_entity_int'),
            'showcase.entity_id = e.entity_id AND showcase.attribute_id = ' . self::SHOWCASE_ATTRIBUTE_ID . ' AND value <> 1',
            array()
        ); // exclude showcases

        return $categoryCollection->getItems();
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemName($item)
    {
        /** @var Mage_Catalog_Model_Category $item */
        return $item->getName();
    }
}