<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/11/15
 * Time: 1:03 PM
 */
/* @var $installer OpsWay_Actions_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->createPrimaryStructure();

$installer->endSetup();