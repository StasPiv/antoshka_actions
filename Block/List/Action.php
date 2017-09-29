<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/22/15
 * Time: 9:36 PM
 */

/**
 * Class OpsWay_Actions_Block_List_Action
 */
class OpsWay_Actions_Block_List_Action extends Mage_Catalog_Block_Product_Abstract implements OpsWay_Actions_Model_Action_Container, OpsWay_Actions_Model_Label_Container
{
            /** @var  OpsWay_Actions_Model_Label */
            /** @var  OpsWay_Actions_Block_List_Action_Mode_Abstract */
    private $label,
            $mode;

    /**
     * @return \OpsWay_Actions_Block_List_Action_Mode_Abstract
     */
    public function getMode()
    {
        if (!$this->mode instanceof OpsWay_Actions_Block_List_Action_Mode_Abstract) {
            Mage::throwException('Action mode must be OpsWay_Actions_Block_List_Action_Mode_Abstract');
        }

        return $this->mode;
    }

    public function setLabel(OpsWay_Actions_Model_Label $label)
    {
        $this->label = $label;
        return $this;
    }

    public function setCurrentAction(OpsWay_Actions_Model_Action $action)
    {
        $result = parent::setCurrentAction($action);
        $this->initMode($action);
        return $result;
    }

    private function initMode(OpsWay_Actions_Model_Action $action)
    {
        switch ($action->getType()) {
            case OpsWay_Actions_Model_Action::OFFLINE_TYPE:
                $this->mode = $this->getLayout()->createBlock('opsway_actions/list_action_mode_offline');
                break;
            case OpsWay_Actions_Model_Action::ONLINE_TYPE:
                $this->mode = $this->getLayout()->createBlock('opsway_actions/list_action_mode_online');
                break;
            default:
                Mage::throwException('Unknown action type');
        }

        $this->mode->setActionBlock($this);
    }

    /**
     * @return OpsWay_Actions_Model_Action
     */
    public function getCurrentAction()
    {
        return parent::getCurrentAction();
    }

    public function getTickerHtml()
    {
        /** @var OpsWay_Actions_Block_Ticker $ticker */
        $ticker = $this->getLayout()->createBlock('opsway_actions/ticker');
        $ticker->setActionContainer($this);

        return $ticker->toHtml();
    }

    public function getLabel()
    {
        if (isset($this->label)) {
            return $this->label;
        }

        return $this->label = $this->getMode()->getLabel();
    }

    public function getLabelStatus()
    {
        return 'offer_'.$this->label['class'];
    }

    public function getLabelClass()
    {
        return $this->label['class'];
    }

    public function getLabelText()
    {
        return $this->label['text'];
    }

    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    public function getRemainingTime()
    {
        return $this->getLabelMode()->getActionDateTo() - time();
    }

    public function getCurrentActionTradeMark()
    {
        return $this->getCurrentAction()->getResource()->getAttribute('tm_id')->getFrontend()->getValue($this->getCurrentAction());
    }

    public function getLabelHtml()
    {
        /** @var OpsWay_Actions_Block_Label $labelBlock */
        $labelBlock = $this->getLayout()->createBlock('opsway_actions/label');
        $labelBlock->setLabelContainer($this);
        return $labelBlock->toHtml();
    }

    public function getUrl()
    {
        return Mage::getUrl('actions/offer/index', array('id' => $this->getCurrentAction()->getId()));
    }

    public function getTemplate()
    {
        return 'opsway/actions/action.phtml';
    }
}