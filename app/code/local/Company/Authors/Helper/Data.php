<?php


class Company_Authors_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PARENT_CATEGORY_ID = 50;
    const AUTHOR_CATEGORY_NAME = 'Autor';
    const COMPANY_AUTHOR_ATTRIBUTE_ID = 135;

    /**
     * @param $author
     * @return bool
     */
    public function isSetSubcategory($author)
    {
        $parentCategory = Mage::getModel('catalog/category')->load($this->getAuthorCategoryId());
        $childCategory = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToFilter('is_active', true)
            ->addIdFilter($parentCategory->getChildren())
            ->addAttributeToFilter('name', $author)
            ->getFirstItem();

        return (($childCategory->getId()) ? true : false);
    }

    /**
     * @param $author
     * @return mixed
     */
    public function getExistingAuthorCategoryId($author)
    {
        $parentCategory = Mage::getModel('catalog/category')->load($this->getAuthorCategoryId());
        $childCategory = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToFilter('is_active', true)
            ->addIdFilter($parentCategory->getChildren())
            ->addAttributeToFilter('name', $author)
            ->getFirstItem();

        return $childCategory->getId();
    }

    /**
     * @return mixed
     */
    public function getAuthorCategoryId()
    {
        $authorCategoryName = self::AUTHOR_CATEGORY_NAME;
        $parentCategory = Mage::getModel('catalog/category')->load(self::PARENT_CATEGORY_ID);
        $childCategory = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToFilter('is_active', true)
            ->addIdFilter($parentCategory->getChildren())
            ->addAttributeToFilter('name', $authorCategoryName)
            ->getFirstItem();

        return $childCategory->getId();
    }

    /**
     * @param $author
     * @return mixed
     */
    public function createNewCategoryForAuthor($author)
    {
        try {
            $category = Mage::getModel('catalog/category');
            $category->setName($author);
            $category->setUrlKey($author);
            $category->setIsActive(1);
            $category->setIsAnchor(1);
            //$category->includeInNavigationMenu(0);
            $category->setStoreId(Mage::app()->getStore()->getId());
            $parentCategory = Mage::getModel('catalog/category')->load($this->getAuthorCategoryId());
            $category->setCompanyth($parentCategory->getCompanyth());
            $category->save();
            return $category->getId();

        } catch(Exception $e) {

            Mage::logException($e);
        }
    }

    /**
     * @param $entityId
     * @param $categoryId
     * @throws Exception
     */
    public function addProductToCategory($entityId, $categoryId)
    {
        $product = Mage::getModel('catalog/product')->load($entityId);
        $categories = $product->getCategoryIds();
        $categories[] = $categoryId;
        $product->setCategoryIds($categories);
        $product->save();
    }

    /**
     * @param $author
     * @return mixed|string
     */
    public function decodeCustomUrlKeyForAuthor($author)
    {
       $author = str_replace('-', ' ', $author);
       $author = ucwords($author);
       return $author;
    }
}
