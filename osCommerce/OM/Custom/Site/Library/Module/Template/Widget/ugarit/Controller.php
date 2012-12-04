<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Widget\ugarit;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;
  use osCommerce\OM\Core\Site\Library\Application\Online\Online;

  class Controller extends \osCommerce\OM\Core\Template\WidgetAbstract {
    static public function execute($param = null) {
      $OSCOM_Template = Registry::get('Template');
      $OSCOM_Language = Registry::get('Language');

      $current_book = $OSCOM_Template->valueExists('current_book') ? $OSCOM_Template->getValue('current_book') : null;
      $current_chapter = $OSCOM_Template->valueExists('current_chapter') ? $OSCOM_Template->getValue('current_chapter') : null;

      $online_books_list = '';

      foreach ( Online::getContent() as $key => $book ) {
        $online_books_list .= '<li';

        if ( isset($current_book) && ($current_book == $key) ) {
          $online_books_list .= ' class="active"';
        }

        $online_books_list .= '><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $key) . '">' . $book['title'] . '</a>';

        if ( isset($current_book) && ($current_book == $key) ) {
          $online_books_list .= '<ul class="nav nav-list">';

          foreach ( $book['chapters'] as $ckey => $chapter ) {
            $online_books_list .= '<li';

            if ( isset($current_chapter) && ($current_chapter == $ckey) ) {
              $online_books_list .= ' class="active"';
            }

            $online_books_list .= '><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $key . '&' . $ckey) . '">' . $chapter['title'] . '</a></li>';
          }

          $online_books_list .= '</ul>';
        }

        $online_books_list .= '</li>';
      }

      $OSCOM_Template->setValue('online_books_list', $online_books_list);

      $file = OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Module/Template/Widget/ugarit/pages/main.html';

      if ( !file_exists($file) ) {
        $file = OSCOM::BASE_DIRECTORY . 'Core/Site/' . OSCOM::getSite() . '/Module/Template/Widget/ugarit/pages/main.html';
      }

      return file_get_contents($file);
    }
  }
?>
