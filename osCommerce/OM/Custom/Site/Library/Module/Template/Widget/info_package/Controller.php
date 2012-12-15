<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Widget\info_package;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class Controller extends \osCommerce\OM\Core\Template\WidgetAbstract {
    static public function execute($param = null) {
      $OSCOM_PackageBook = Registry::get('PackageBook');
      $OSCOM_Template = Registry::get('Template');

      $book = $OSCOM_Template->getValue('current_book');

      $OSCOM_Template->setValue('book_copyright', $OSCOM_PackageBook->getCopyright($book));
      $OSCOM_Template->setValue('book_authors', $OSCOM_PackageBook->getAuthors($book));

      $file = OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Module/Template/Widget/info_package/pages/main.html';

      if ( !file_exists($file) ) {
        $file = OSCOM::BASE_DIRECTORY . 'Core/Site/' . OSCOM::getSite() . '/Module/Template/Widget/info_package/pages/main.html';
      }

      return file_get_contents($file);
    }
  }
?>
