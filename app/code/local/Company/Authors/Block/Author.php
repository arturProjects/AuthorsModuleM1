<?php

/**
 * Class Company_Authors_Block_Author
 */
class Company_Authors_Block_Author extends Mage_Core_Block_Template
{
    /**
     * @return mixed
     */
    public function getAllProductsOfAuthor()
    {
        $authorUrlKey = Mage::registry('authorUrlKey');
        $collection = Mage::getResourceModel('Company_authors/authors_collection');
        $collection->addFieldToSelect('authors_author_id');
        $collection->addFieldToSelect('name');
        $collection->addFieldToSelect('author_products');
        $collection->addFieldToFilter('author_url_key', $authorUrlKey);
        $productsByAuthor = $collection->getData();  
        $productIds = [];
        foreach($productsByAuthor as $author)
        {
             $productIds = array_merge($productIds, json_decode($author['author_products']));
        }

        $productsByAuthor = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('status', array('in'=>Mage::getSingleton('catalog/product_status')->getSaleableStatusIds()))
            ->addFieldToFilter('entity_id', array('in'=> $productIds));
        return $productsByAuthor;
    }
}

