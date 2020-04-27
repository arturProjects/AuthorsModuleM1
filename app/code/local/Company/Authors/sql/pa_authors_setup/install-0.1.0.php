<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();
$authors = $connection
    ->newTable($installer->getTable('Company_authors/authors'))
    ->addColumn('authors_author_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'auto_increment' => true,
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ], 'Unique identifier')
    ->addColumn('origin_entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned'  => true,
        'nullable'  => true
    ], 'Origin Entity Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable'  => false
    ], 'Value of attribute Company_author')
    ->addColumn('is_author_name_ok', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, [
        'unsigned'  => true,
        'nullable'  => false,
        'default' => false
    ], 'Yes or Not')
    ->addColumn('author_url_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable'  => true
    ], 'Author url key')
    ->addColumn('author_description', Varien_Db_Ddl_Table::TYPE_TEXT, [
        'nullable'  => true
    ], 'Author description')
    ->addColumn('author_products', Varien_Db_Ddl_Table::TYPE_LONGVARCHAR, null, [
        'unsigned'  => true,
        'nullable'  => true,
    ], 'Author products');

$connection->createTable($authors);
$installer->endSetup();



