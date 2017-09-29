<?php

class OpsWay_Actions_Model_Resource_Setup_ActionProducts
{
    private $fromDate, $toTime, $toDate;

    function __construct()
    {
        $this->fromDate = date('m/d/y', mktime(0, 0, 0, date('m'), date('d'), date('y')));
        $this->toTime = mktime(0, 0, 0, date('m'), date('d'), date('y'));
        $this->toDate = date('m/d/y', $this->toTime);
    }

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getBestsellers()
    {
        return Mage::getResourceModel('catalogsearch/advanced_collection')
            ->addAttributeToFilter(
                'is_special_price_date_to',
                array(
                    'date' => true,
                    'from' => $this->toDate
                )
            )
            ->addAttributeToFilter('is_special_price', 1);
    }

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getSpecialPriceProducts()
    {
        return $this->getProductsBetweenTwoDates('special_from_date', 'special_to_date')
                    ->addAttributeToFilter('special_price', array('gt' => 0));
    }

    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getNewProducts()
    {
        $newsProductsCollection = $this->getProductsBetweenTwoDates('news_from_date', 'news_to_date', true);
        Mage::log($newsProductsCollection->getSelect()->__toString(), null, 'news_products.log');
        return $newsProductsCollection;
    }

    public function getHits()
    {
        $collection = Mage::getResourceModel('catalogsearch/advanced_collection')
            ->addAttributeToFilter('is_bestseller', true)
            ->setOrder('entity_id', 'asc');

        return $collection;
    }

    /**
     * @param $fromField
     * @param $toField
     * @param bool $isToDateRequired
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    private function getProductsBetweenTwoDates($fromField, $toField, $isToDateRequired = false)
    {
        $dateModel = Mage::getModel('core/date');
        $tomorrow = $dateModel->gmtDate('Y-m-d', $dateModel->timestamp() + 3600 * 24);
        $yesterday = $dateModel->gmtDate('Y-m-d', $dateModel->timestamp() - 3600 * 24);
        $collection = Mage::getResourceModel('catalogsearch/advanced_collection')
            ->addAttributeToFilter(
                $fromField,
                array(
                    'or' => array(
                        array('date' => true, 'to' => $tomorrow),
                        array('is' => new Zend_Db_Expr('null'))
                    )
                ),
                'left'
            )
            ->addAttributeToFilter(
                $toField,
                array(
                    'or' => array(
                        array('date' => true, 'from' => $yesterday),
                        array('is' => new Zend_Db_Expr('null'))
                    )
                ),
                'left'
            )
            ->groupByAttribute('entity_id')
            ->setOrder('entity_id', 'asc');

        if ($isToDateRequired) {
            $collection->getSelect()->where("at_{$toField}.value IS NOT NULL");
        } else {
            $collection->getSelect()->where("at_{$fromField}.value IS NOT NULL OR at_{$toField}.value IS NOT NULL");
        }

        return $collection;
    }
}