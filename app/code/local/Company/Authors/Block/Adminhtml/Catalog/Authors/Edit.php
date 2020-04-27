<?php

/**
 * Class Company_Authors_Block_Adminhtml_Catalog_Authors_Edit
 */
class Company_Authors_Block_Adminhtml_Catalog_Authors_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_catalog_authors';
        $this->_blockGroup = 'Company_authors';
        Companyrent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('Company_authors')->__('Zapisz'));
    }
    
    /**
     * getHeaderText
     *
     * @return void
     */
    public function getHeaderText()
    {
        if(Mage::registry('author_data') && Mage::registry('author_data')->getId())
        {
            return Mage::helper('Company_authors')->__("Edytujesz: '%s'", $this->htmlEscape(Mage::registry('author_data')->getName()));
        }
        return Mage::helper('Company_authors')->__('Nie ma takiego autora');
    }
}
