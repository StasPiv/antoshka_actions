<?php
/* @var $installer OpsWay_Actions_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->createActionsFromProductsWithSpecialPrice();

$installer->endSetup();