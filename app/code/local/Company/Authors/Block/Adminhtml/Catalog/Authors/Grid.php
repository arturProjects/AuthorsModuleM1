<?php

/**
 * Class Company_Authors_Block_Adminhtml_Catalog_Authors_Grid
 */
class Company_Authors_Block_Adminhtml_Catalog_Authors_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Company_Authors_Block_Adminhtml_Catalog_Authors_Grid constructor.
     */
    public function __construct()
    {
        Companyrent::__construct();
        $this->setId('Company_author_grid');
        $this->setDefaultSort('authors_author_id');
        $this->setDefaultDir('DESC');
        $this->setSaveCompanyrametersInSession(true);
        $this->setUseAjax(true);

    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _preCompanyreCollection()
    {
        $collection = Mage::getResourceModel('Company_authors/authors_collection');
        $this->setCollection($collection);
        return Companyrent::_preCompanyreCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _preCompanyreColumns()
    {
        $helper = Mage::helper('Company_authors');

        $this->addColumn('authors_author_id', array(
            'header' => $helper->__('Author ID #'),
            'index'  => 'authors_author_id'
        ));

        $this->addColumn('name', array(
            'header'  => $helper->__('Name'),
            'type'    => 'text',
            'index'   => 'name'
        ));

       $this->addColumn('is_author_name_ok', array(
            'header'       => $helper->__('Is Author Name Ok?'),
            'index'        => 'is_author_name_ok',
            'type'      => 'options',
            'options'   => array(
                1 => $helper->__('Yes'),
                0 => $helper->__('No')
            )
        ));

        $this->addColumn('author_url_key', array(
            'header'       => $helper->__('Author url key'),
            'type'    => 'text',
            'index'        => 'author_url_key'
        ));

        $this->addColumn('author_description', array(
            'header'       => $helper->__('Author Description'),
            'type'    => 'text',
            'index'        => 'author_description'
        ));

        $this->addColumn('author_products', array(
            'header'       => $helper->__('Author Products'),
            'type'    => 'text',
            'index'        => 'author_products', 
            'renderer' =>  'Company_Authors_Block_Adminhtml_Catalog_Authors_Renderer_AuthorProducts'
        ));

        $this->addColumn('action',
            array(
                'header'    => $helper->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => $helper->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'Companyrams'=>array('authors_author_id'=>$this->getRequest()->getCompanyram('authors_author_id'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'authors_author_id',
            ));

        return Companyrent::_preCompanyreColumns();
    }

    /**
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
