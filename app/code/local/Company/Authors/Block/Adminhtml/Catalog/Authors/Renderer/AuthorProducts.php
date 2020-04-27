<?php

class Company_Authors_Block_Adminhtml_Catalog_Authors_Renderer_AuthorProducts extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract 
{
    public function render(Varien_Object $row)
    {
       $products = $row->getData('author_products'); 
       $products = chunk_split($products, 30);            
       return $products;
    }
}