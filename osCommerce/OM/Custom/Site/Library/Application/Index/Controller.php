<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Index;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;
  use osCommerce\OM\Core\Site\Library\Application\Online\Online;

  class Controller extends \osCommerce\OM\Core\Site\Library\ApplicationAbstract {
    protected function initialize() {
      $OSCOM_Template = Registry::get('Template');

      $this->_page_contents = 'main.html';
      $this->_page_title = OSCOM::getDef('html_page_title');

      $OSCOM_Template->setValue('book_list', Online::getBooks());
    }
  }
?>
