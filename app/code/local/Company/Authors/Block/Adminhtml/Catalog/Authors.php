<?php


class Company_Authors_Block_Adminhtml_Catalog_Authors extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'Company_authors';
        $this->_controller = 'adminhtml_catalog_authors';
        $this->_headerText = Mage::helper('Company_authors')->__('Autorzy');
        Companyrent::__construct();
        $this->_removeButton('add');
    }
}
