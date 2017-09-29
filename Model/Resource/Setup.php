<?php

/**
 * Created by PhpStorm.
 * User: stas
 * Date: 2/11/15
 * Time: 1:11 PM
 */
class OpsWay_Actions_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
    private $categoryNames = array(
        'Clothing' => 'Одежда',
        'Shoes' => 'Обувь',
        'Food' => 'Питание',
        'Hygien' => 'Гигиена',
        'Toys' => 'Игрушка'
    );

    const WEBSITE_ID = 1;

    const SLIDER_OFFERS_OFFLINE_IDENTIFIER = 'slider_offers_offline';

    private $onlineLabels = array(
        array(
            'name' => 'Скидка',
            'color' => 'a24fa9'
        ),
        array(
            'name' => 'Спец. цена',
            'color' => 'a24fa9'
        ),
        array(
            'name' => 'Новинка',
            'color' => 'a24fa9'
        ),
        array(
            'name' => 'Хит продаж',
            'color' => 'f1730d'
        )
    );

    public function createPrimaryStructure()
    {
        $this->createActionsTable();
        $this->createCategoriesTable();
        $this->createLabelsTable();
        $this->createActInCatTable();
        $this->fillCategoriesTable();
    }

    private function createActionsTable()
    {
        if ($this->getConnection()->isTableExists($this->getTable('opsway_actions/actions'))) {
            return true;
        }

        $table = $this->getConnection()
            ->newTable($this->getTable('opsway_actions/actions'))
            ->addColumn(
                'action_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ),
                'Id'
            )
            ->addColumn(
                'name',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(
                    'nullable' => false,
                ),
                'Name'
            )
            ->addColumn(
                'type',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => false,
                    'default' => OpsWay_Actions_Model_Action::ONLINE_TYPE
                ),
                'Action type'
            )
            ->addColumn(
                'short_description',
                Varien_Db_Ddl_Table::TYPE_TEXT,
                null,
                array(
                    'nullable' => false,
                ),
                'Short description'
            )
            ->addColumn(
                'full_description',
                Varien_Db_Ddl_Table::TYPE_TEXT,
                null,
                array(
                    'nullable' => false,
                ),
                'Full description'
            )
            ->addColumn(
                'is_top_banner',
                Varien_Db_Ddl_Table::TYPE_BOOLEAN,
                null,
                array(),
                'Is top banner'
            )
            ->addColumn(
                'label_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => true,
                ),
                'Label ID'
            )
            ->addColumn(
                'tie_type',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => false,
                    'default' => OpsWay_Actions_Model_Action::TIE_TYPE_PRODUCT
                ),
                'Tie type'
            )
            ->addColumn(
                'product_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => false,
                ),
                'Product'
            )
            ->addColumn(
                'bundle_option_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => true,
                ),
                'Option ID'
            )
            ->addColumn(
                'date_from',
                Varien_Db_Ddl_Table::TYPE_DATE,
                null,
                array(),
                'Date from'
            )
            ->addColumn(
                'date_to',
                Varien_Db_Ddl_Table::TYPE_DATE,
                null,
                array(),
                'Date to'
            )
            ->addColumn(
                'is_active',
                Varien_Db_Ddl_Table::TYPE_BOOLEAN,
                null,
                array(
                    'default' => OpsWay_Actions_Model_Action::IS_ACTIVE
                ),
                'Is Active'
            )
            ->addColumn(
                'age_from',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(),
                'Age from'
            )
            ->addColumn(
                'age_to',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(),
                'Age to'
            )
            ->addColumn(
                'order',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'default' => 9999
                ),
                'Order'
            )
            ->addColumn(
                'full_image_path',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(),
                'Full image'
            )
            ->addColumn(
                'small_image_path',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(),
                'Small image'
            )
            ->addColumn(
                'top_banner_image_path',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(),
                'Top banner image'
            )
            ->addIndex(
                'name',
                array('name'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
                )
            )
            ->addIndex(
                'age_from',
                array('age_from'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
                )
            )
            ->addIndex(
                'age_to',
                array('age_to'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
                )
            )
            ->addIndex(
                'product_id',
                array('product_id'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
                )
            );

        $this->getConnection()->createTable($table);
    }

    private function createCategoriesTable()
    {
        if ($this->getConnection()->isTableExists($this->getTable('opsway_actions/categories'))) {
            return true;
        }

        $table = $this->getConnection()
            ->newTable($this->getTable('opsway_actions/categories'))
            ->addColumn(
                'category_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ),
                'Id'
            )
            ->addColumn(
                'name',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(
                    'nullable' => false,
                ),
                'Name'
            )
            ->addColumn(
                'name_ru',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(
                    'nullable' => false,
                ),
                'Name Ru'
            )
            ->addIndex(
                'name',
                array('name'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
                )
            );

        $this->getConnection()->createTable($table);
    }

    private function createLabelsTable()
    {
        if ($this->getConnection()->isTableExists($this->getTable('opsway_actions/labels'))) {
            return true;
        }

        $table = $this->getConnection()
            ->newTable($this->getTable('opsway_actions/labels'))
            ->addColumn(
                'label_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ),
                'Id'
            )
            ->addColumn(
                'name',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(
                    'nullable' => false,
                ),
                'Name'
            )
            ->addColumn(
                'color',
                Varien_Db_Ddl_Table::TYPE_VARCHAR,
                255,
                array(
                    'nullable' => false,
                ),
                'Color'
            )
            ->addIndex(
                'name',
                array('name'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
                )
            );

        $this->getConnection()->createTable($table);
    }

    private function createActInCatTable()
    {
        if ($this->getConnection()->isTableExists($this->getTable('opsway_actions/act_in_cat'))) {
            return true;
        }

        $table = $this->getConnection()
            ->newTable($this->getTable('opsway_actions/act_in_cat'))
            ->addColumn(
                'act_in_cat_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true,
                ),
                'Id'
            )
            ->addColumn(
                'action_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => false,
                ),
                'Action'
            )
            ->addColumn(
                'category_id',
                Varien_Db_Ddl_Table::TYPE_INTEGER,
                null,
                array(
                    'nullable' => false,
                ),
                'Category'
            )
            ->addIndex(
                'act_cat',
                array('action_id', 'category_id'),
                array(
                    'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
                )
            );

        $this->getConnection()->createTable($table);
    }

    private function fillCategoriesTable()
    {
        if (!$this->getConnection()->isTableExists($this->getTable('opsway_actions/categories'))) {
            return true;
        }

        foreach ($this->categoryNames as $categoryName => $categoryNameRu) {
            Mage::getModel('opsway_actions/category')
                ->load($categoryName, 'name')
                ->setName($categoryName)
                ->setNameRu($categoryNameRu)
                ->save();
        }
    }

    public function createActionsFromProductsWithSpecialPrice()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $productCollection->addAttributeToFilter('is_special_price', 1);

        $productCollection->addAttributeToSelect(
            array(
                'name',
                'status',
                'age_from',
                'age_to',
                'is_special_price',
                'is_special_price_date_to',
                'description',
                'short_description'
            )
        );

        Mage::getModel('opsway_actions/action')->updateOrCreateFromProductCollection(
            $productCollection,
            Mage::getModel('opsway_actions/label')->load('Спец. цена', 'name')->getId()
        );
    }

    public function createDirectoryForOpswayActionImages()
    {
        mkdir('/var/www/current/media/opsway');
        mkdir('/var/www/current/media/opsway/actions');
    }

    public function createActionsFromActionProducts()
    {
        Mage::app()->getStore()->setWebsiteId(self::WEBSITE_ID);
        $actionProducts = Mage::getModel('opsway_actions/resource_setup_actionProducts');

        Mage::getModel('opsway_actions/action')->updateOrCreateFromProductCollection(
            $actionProducts->getBestsellers(),
            Mage::getModel('opsway_actions/label')->load('Скидка', 'name')->getId()
        );
        Mage::getModel('opsway_actions/action')->updateOrCreateFromProductCollection(
            $actionProducts->getSpecialPriceProducts(),
            Mage::getModel('opsway_actions/label')->load('Спец. цена', 'name')->getId()
        );
    }

    public function createSliderForOffline()
    {
        $newSlider = Mage::getModel('easyslide/easyslide')->load(self::SLIDER_OFFERS_OFFLINE_IDENTIFIER, 'identifier');
        $newSlider->setData(
            array(
                'title' => 'Offers Offline',
                'identifier' => self::SLIDER_OFFERS_OFFLINE_IDENTIFIER,
                'width' => 680,
                'height' => 350,
                'duration' => 0.5,
                'frequency' => 5.0,
                'autoglide' => true,
                'status' => true
            )
        );
        $newSlider->save();
    }

    public function addColumnAutoCreatedToActionsTable()
    {
        if (!$this->getConnection()->isTableExists($this->getTable('opsway_actions/actions'))) {
            return false;
        }

        $this->getConnection()->addColumn(
            $this->getTable('opsway_actions/actions'),
            'is_auto_created',
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
                'comment' => 'Is auto created',
                'default' => 0
            )
        );
    }

    public function createLabelsForOnlineActions()
    {
        foreach ($this->onlineLabels as $labelForCreating) {
            $labelModel = Mage::getModel('opsway_actions/label')->load($labelForCreating['name'], 'name');
            if ($labelModel->getId()) {
                continue;
            }

            $labelModel->setData($labelForCreating);
            $labelModel->save();
        }
    }

    public function createAttributeLabel()
    {
        $attributeCode = 'label';

        $entityResource = Mage::getModel('catalog/resource_eav_attribute');

        $entityResource->addData(
            array (
                'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                'group' => 'General',
                'frontend_label'    => 'Выгодные предложения',
                'visible'     => true,
                'frontend_input'    => 'select',
                'backend_type'    => 'int',
                'system'   => true,
                'required' => false,
                'user_defined' => 1,
                'is_filterable' => 1
            )
        );

        $entityResource->setAttributeCode($attributeCode);
        $entityResource->setEntityTypeId(4);
        $entityResource->save();


        $eavSetup = new Mage_Eav_Model_Entity_Setup('core_setup');
        foreach (array('Новинка','Хит продаж','Скидка','Специальная цена') as $value) {
            $eavSetup->addAttributeOption(
                array(
                    'attribute_id' => Mage::getModel('catalog/resource_eav_attribute')
                                            ->loadByCode('catalog_product', $attributeCode)
                                            ->getAttributeId(),
                    'value' => array(
                        $value => array(
                            0 => $value,
                            1 => $value
                        )
                    )
                )
            );
        }
    }
}