<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:13 AM
 */

/**
 * Class OpsWay_Actions_Model_Category
 *
 * @method OpsWay_Actions_Model_Category setName(string $name)
 * @method string getName()
 * @method OpsWay_Actions_Model_Category setNameRu(string $name)
 * @method string getNameRu()
 */
class OpsWay_Actions_Model_Category extends Mage_Core_Model_Abstract
{
    private $actionCount;

    protected function _construct()
    {
        $this->_init('opsway_actions/category');
    }

    public function getActionCount()
    {
        if (isset($this->actionCount)) {
            return $this->actionCount;
        }

        return $this->actionCount = Mage::getResourceModel('opsway_actions/actInCat_collection')->getActionCountByCategory($this);
    }

}