<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Widget\info_online;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class Controller extends \osCommerce\OM\Core\Template\WidgetAbstract {
    static public function execute($param = null) {
      $OSCOM_CoreBook = Registry::get('CoreBook');
      $OSCOM_Template = Registry::get('Template');

      $book = $OSCOM_Template->getValue('current_book');

      $OSCOM_Template->setValue('book_copyright', $OSCOM_CoreBook->getCopyright($book));
      $OSCOM_Template->setValue('book_authors', $OSCOM_CoreBook->getAuthors($book));

      $file = OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Module/Template/Widget/info_online/pages/main.html';

      if ( !file_exists($file) ) {
        $file = OSCOM::BASE_DIRECTORY . 'Core/Site/' . OSCOM::getSite() . '/Module/Template/Widget/info_online/pages/main.html';
      }

      return file_get_contents($file);
    }
  }
?>
