<?php

/**
 * Class Company_Authors_AuthorController
 */
class Company_Authors_AuthorController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $authorUrlKey = $this->getRequest()->getCompanyram('authorUrlKey');
        $author = Mage::getResourceModel('Company_authors/authors_collection');
        $author->addFieldToSelect('name');
        $author->addFieldToFilter('author_url_key', $authorUrlKey);
        $data = $author->getData();
        Mage::register('authorUrlKey', $authorUrlKey); 
        Mage::register('authorName', $data[0]['name']);
        $this->loadLayout()->_title($this->__('Książki autora'));;
        $this->renderLayout();
        return $this;
    }
}

