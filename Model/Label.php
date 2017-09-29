<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:55 AM
 */

/**
 * Class OpsWay_Actions_Model_Label
 *
 * @method OpsWay_Actions_Model_Label setName(string $value)
 * @method string getName()
 * @method OpsWay_Actions_Model_Label setColor(string $value)
 * @method string getColor()
 */
class OpsWay_Actions_Model_Label extends Mage_Core_Model_Abstract
{
    /** @var  Mage_Catalog_Model_Product */
    private $product;

    protected function _construct()
    {
        $this->_init('opsway_actions/label');
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return OpsWay_Actions_Model_Label
     */
    public function setProduct(Mage_Catalog_Model_Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return \Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return bool
     */
    public function isNovelty()
    {
        return $this->isLabel('news_to_date', 'news_from_date', 'news_to_date');
    }

    /**
     * @return bool
     */
    public function isSale()
    {
        return $this->isLabel('special_to_date', 'special_from_date', 'special_to_date');
    }

    /**
     * @return bool
     */
    public function isSpecialPrice()
    {
        return $this->isLabel('is_special_price', null, 'is_special_price_date_to');
    }

    /**
     * @return bool
     */
    public function isBestseller()
    {
        return $this->isLabel('is_bestseller');
    }

    /**
     * @param null $fieldCheck
     * @param null $fieldDateFrom
     * @param null $fieldDateTo
     *
     * @return bool
     */
    private function isLabel($fieldCheck = null, $fieldDateFrom = null, $fieldDateTo = null)
    {
        if (!isset($this->product) || !$fieldCheck || !$this->product->getData($fieldCheck)) {
            return false;
        }

        if ($fieldDateFrom && $this->product->getData($fieldDateFrom)) {
            $dateFrom = strtotime($this->product->getData($fieldDateFrom));
        } else {
            $dateFrom = time() - 10;
        }

        if ($fieldDateTo && $this->product->getData($fieldDateTo)) {
            $dateTo = strtotime($this->product->getData($fieldDateTo)) + 3600 * 24;
        } else {
            $dateTo = time() + 10;
        }

        return time() > $dateFrom && time() < $dateTo;
    }

}