<?php

/**
 * Class Company_Authors_Adminhtml_AuthorsController
 */
class Company_Authors_Adminhtml_AuthorsController extends Mage_Adminhtml_Controller_Action
{    
    
    /**
     * indexAction
     */
    public function indexAction()
    {
        $this->_title($this->__('Autorzy'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/author');
        $this->_addContent($this->getLayout()->createBlock('Company_authors/adminhtml_catalog_authors'));
        $this->renderLayout();
    }

    /**
     * gridAction
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('Company_authors/adminhtml_catalog_authors_grid')->toHtml()
        );
    }

    /**
     * @throws Mage_Core_Exception
     */
    public function editAction()
    {
        $author_id = $this->getRequest()->getCompanyram('id', null);
        $author  = Mage::getModel('Company_authors/authors');

        if ($author_id) {
            $author->load((int) $author_id);
            if ($author->getId())
            {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if($data)
                {
                    $author->setData($data)->setId($author_id);
                }
            }
            else
            {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('Company_authors')->__('Autor nie istnieje'));
                $this->_redirect('*/*/');
            }
        }
        Mage::register('author_data', $author);
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('Company_authors/adminhtml_catalog_authors_edit'));
        $this->renderLayout();
    }

            
    /**
     * saveAction
     *
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $authorProducts = $data['author_products'];
        $authorProducts = json_decode($data['author_products']);
        $authorId = $data['authors_author_id'];
        $value = $data['name'];
        $helper = Mage::helper('Company_authors');
        $attributeId = $helper::Company_AUTHOR_ATTRIBUTE_ID;

        // checking what has been changed: name, description, products,
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableEntity = $resource->getTableName('catalog_product_entity_text'); 
        $query = 'SELECT value FROM ' . $tableEntity . ' WHERE attribute_id = ' .(int)$attributeId. ' AND entity_id = ' .(int)$authorProducts[0];
        $result = $readConnection->fetchOne($query);
        
        if($result != $value)
        {
            if(is_int(strpos($value, ';')))
            {
                //change value in catalog_product_entity_text
                $writeConnection = $resource->getConnection('core_write');
                $q = count($authorProducts);
                for($j =0; $j < $q; $j++)
                {
                    $query = "UPDATE {$tableEntity} SET value = '{$value}' WHERE entity_id = "
                    . (int)$authorProducts[$j]. " AND attribute_id = " . (int)$attributeId;
                    $writeConnection->query($query);
                }
                //change in Company_authors_authors
                $authors = explode(';', $value);
                $n = count($authors);
                for($i = 0; $i < $n; $i++)
                {
                    // first checking if author exists in table because of something can be demaged 
                    /*$collection = Mage::getResourceModel('Company_authors/authors_collection');
                    $collection->addFieldToSelect('authors_author_id');
                    $collection->addFieldToSelect('name');
                    $collection->addFieldToSelect('author_products');
                    $collection->addFieldToFilter('name', $authors[$i]);
                    $data = $collection->getData();
                    if(count($data) > 0)
                    {
                        // add product
                        $products = explode(',', $data[0]['author_products']);
                        array_push($products, $entityId);
                        $data[0]['author_products'] = implode(',', $products);
                        $author = Mage::getModel('Company_authors/authors')->load($data[0]['authors_author_id'])->addData($data);
                        $author->setId($authorId)->save();
                        
                    }
                    else 
                    {*/
                        // add new author
                        $data = ['origin_entity_id' => 0, 'name' => trim($authors[$i]), 'is_author_name_ok' => 1, 
                                 'author_url_key' => Mage::helper('Company_product')->encodeCustomUrlKeyForAuthor($authors[$i]), 
                                 'author_description' => 'tu jest opis tego autora', 'author_products' => json_encode($authorProducts)];
                        $author = Mage::getModel('Company_authors/authors')->setData($data);
                        $author->save();

                    //}
                }

                //delete author 
                $author = Mage::getModel('Company_authors/authors')->setId($authorId)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('Company_authors')->__('Autor został pomyślnie przetworzony'));
                $this->_redirect('*/*/');
            }
            else
            {
                $author = Mage::getModel('Company_authors/authors')->load($authorId)->addData($data);
                $author->setId($authorId)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('Company_authors')->__('Autor został pomyślnie zaktualizowany'));
                $this->_redirect('*/*/');
            }
            
        }
        else
        {
                $author = Mage::getModel('Company_authors/authors')->load($authorId)->addData($data);
                $author->setId($authorId)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('Company_authors')->__('Autor został pomyślnie zaktualizowany'));
                $this->_redirect('*/*/');
        }
    }
    
}
