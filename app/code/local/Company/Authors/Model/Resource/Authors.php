<?php


/**
 * Company_Authors_Model_Resource_Authors
 */
class Company_Authors_Model_Resource_Authors extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('Company_authors/authors', 'authors_author_id');
    }
}
