<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 11:58 AM
 */

/**
 * Class OpsWay_Actions_Model_ActInCat
 *
 * @method OpsWay_Actions_Model_ActInCat setActionId(int $value)
 * @method int getActionId()
 * @method OpsWay_Actions_Model_ActInCat setCategoryId(int $value)
 * @method int getCategoryId()
 */
class OpsWay_Actions_Model_ActInCat extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('opsway_actions/actInCat');
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     */
    public function clearTableByAction(OpsWay_Actions_Model_Action $action)
    {
        foreach (Mage::getResourceModel('opsway_actions/actInCat_collection')
                     ->addFieldToFilter('action_id', $action->getId()) as $actInCat) {
            $actInCat->delete();
        }
    }

    /**
     * @param OpsWay_Actions_Model_Action $action
     */
    public function loadCategoriesByAction(OpsWay_Actions_Model_Action $action)
    {
        return Mage::getResourceModel('opsway_actions/actInCat_collection')
                   ->addFieldToFilter('action_id', $action->getId());
    }

}