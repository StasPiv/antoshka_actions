<?php

/**
 * Class OpsWay_Actions_Model_Filter_Item
 *
 * @method int getCount()
 * @method setCount(int $count)
 * @method string getName()
 * @method setName(string $name)
 * @method string getUrl()
 * @method setUrl(string $url)
 * @method bool getIsActive()
 * @method setIsActive(bool $isActive)
 */
class OpsWay_Actions_Model_Filter_Item extends Mage_Core_Model_Abstract
{
    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->getIsActive();
    }
}