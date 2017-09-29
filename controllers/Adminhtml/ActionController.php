<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/12/15
 * Time: 3:06 PM
 */
class OpsWay_Actions_Adminhtml_ActionController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('opsway_actions/actions');
    }
    public function indexAction()
    {
        $this->_redirect('*/*/list');
    }

    public function listAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function newAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function editAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if (!empty($data)) {
            try {
                $actionModel = Mage::getModel('opsway_actions/action');
                $actionModel->setData($data);
                $actionModel->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('opsway_actions')->__('Action successfully saved')
                );

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $this->_redirect('*/*/edit/action_id/' . $actionModel->getId());
                }

            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Something went wrong'));
            }
        }

        return $this->_redirect('*/*/list');
    }

    public function massDeleteAction()
    {
        $actionIds = $this->getRequest()->getParam('action');
        if (!is_array($actionIds)) {
            $this->_getSession()->addError($this->__('Please select action(s).'));
        } else {
            if (!empty($actionIds)) {
                try {
                    foreach ($actionIds as $saleId) {
                        $sale = Mage::getSingleton('opsway_actions/action')->load($saleId);
                        $sale->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d action(s) have been deleted.', count($actionIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/list');
    }

    public function deleteAction()
    {
        $actionId = $this->getRequest()->getParam('action_id');

        if (empty($actionId)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Something went wrong'));
            $this->_redirect('*/*/list');
        }

        $action = Mage::getModel('opsway_actions/action')->load($actionId);

        if ($action->getId() == '') {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Action is not found'));
            $this->_redirect('*/*/list');
        }

        $action->delete();

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action has been deleted'));
        $this->_redirect('*/*/list');
    }
}