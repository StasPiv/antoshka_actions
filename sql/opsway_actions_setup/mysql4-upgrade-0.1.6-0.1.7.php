<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 06.05.15
 * Time: 14:44
 */

/* @var $installer OpsWay_Actions_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->createLabelsForOnlineActions();

$installer->endSetup();