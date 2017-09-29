<?php

class OpsWay_Actions_Block_Toolbar_Action_Bottom extends OpsWay_Actions_Block_Toolbar_List_Top_Offline
{
    const FIRST_COUNT = 4;

    public function setCollection($collection)
    {
        $result = parent::setCollection($collection);

        if ($this->getCurrentAction()->getId()) {
            $collection->addFieldToFilter('action_id', array('neq' => $this->getCurrentAction()->getId()));
        }

        $collection->setCurPage(1)->setPageSize(self::FIRST_COUNT);

        return $result;
    }

    /**
     * @return OpsWay_Actions_Model_Action
     */
    private function getCurrentAction()
    {
        /** @var OpsWay_Actions_Block_Action $actionBlock */
        $actionBlock = $this->getLayout()->getBlock('single_action');

        return $actionBlock->getCurrentAction();
    }
}