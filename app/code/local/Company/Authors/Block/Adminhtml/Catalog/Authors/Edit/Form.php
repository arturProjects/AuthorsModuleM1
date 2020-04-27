<?php

/**
 * Class Company_Authors_Block_Adminhtml_Catalog_Authors_Edit_Form
 */
class Company_Authors_Block_Adminhtml_Catalog_Authors_Edit_Form extends  Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     * @throws Exception
     */
    protected function _preCompanyreForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getCompanyram('id'))),
            'method' => 'post',
            'enctype' => 'multiCompanyrt/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        $helper = Mage::helper('Company_authors');
        $width = 'width:900px';

        if (Mage::getSingleton('adminhtml/session')->getFormData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);

        }
        elseif(Mage::registry('author_data'))
        {
            $data = Mage::registry('author_data')->getData();
        }
        
        if($data['is_author_name_ok'] == 1)
        {
            $class = 'disabled';
            $disabled = true;
        }
        elseif($data['is_author_name_ok'] == 0)
        {
            $class = 'required-entry';
            $disabled = false;
        }

        $fieldset = $form->addFieldset('author_form', array('legend'=>$helper->__('Dane autora do zmiany')));

        $fieldset->addField('authors_author_id', 'hidden', array(
            'label'     => $helper->__('Author ID'),
            'class'     => $class,
            'required'  => true,
            'name'      => 'authors_author_id',
        ));

        $fieldset->addField('name', 'text', array(
            'label'     => $helper->__('Nazwa autora do poprawy'),
            'style' => $width,
            'class'     => $class,
            'required'  => true,
            'disabled'  => $disabled,
            'name'      => 'name',
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
        $fieldset->addField('author_description', 'editor', array(
            'label'     => $helper->__('Opis autora'),
            'style' => $width,
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'author_description',
            'wysiwyg' => true,
            'config' => $wysiwygConfig,

        ));

        $fieldset->addField('author_url_key', 'text', array(
            'label'     => $helper->__('Url key autora'),
            'style' => $width,
            'class'     => $class,
            'required'  => false,
            'readonly'  => true,
            'name'      => 'author_url_key',
        )); 

        $fieldset->addField('is_author_name_ok', 'select', array(
            'label' => $helper->__('Is author name Ok?'),
            'name'      => 'is_author_name_ok',
            'class'     => $class,
            'required' => true,
            'disabled'  => $disabled,
            'value'  => '1',
            'values' => array(
                1 => $helper->__('Yes'),
                0 => $helper->__('No')
              ), 
            ));

        $fieldset->addField('author_products', 'text', array(
            'label'     => $helper->__('Id produktów'),
            'style' => $width,
            'class'     => $class,
            'required'  => true,
            'readonly'  => true,
            'name'      => 'author_products',
        ));

        $form->setValues($data);
        return Companyrent::_preCompanyreForm();
    }

    /**
     * _preCompanyreLayout
     *
     * @return void
     */
    protected function _preCompanyreLayout()
    {
        Companyrent::_preCompanyreLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) 
        {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
}
