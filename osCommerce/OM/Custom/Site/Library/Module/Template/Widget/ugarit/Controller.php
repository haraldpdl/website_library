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
      $current_page = $OSCOM_Template->valueExists('current_page') ? $OSCOM_Template->getValue('current_page') : null;

      $books = Online::getContent();

      $online_books_list = '';

      $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . (isset($current_book) ? Online::getBookTitle($current_book) : OSCOM::getDef('books_title')) . '<b class="caret"></b></a>
                               <ul class="dropdown-menu">';

      foreach ( $books as $key => $book ) {
        $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $key) . '">' . $book['title'] . '</a></li>';
      }

      $online_books_list .= '</ul></li>';

      if ( isset($current_chapter) ) {
        $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . Online::getChapterTitle($current_chapter, $current_book) . '<b class="caret"></b></a>
                                 <ul class="dropdown-menu">';

        foreach ( $books[$current_book]['chapters'] as $ckey => $chapter ) {
          $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $ckey) . '">' . $chapter['title'] . '</a></li>';
        }

        $online_books_list .= '</ul></li>';

        if ( isset($current_page) ) {
          $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . Online::getPageTitle($current_page, $current_chapter, $current_book) . '<b class="caret"></b></a>
                                   <ul class="dropdown-menu">';

          foreach ( $books[$current_book]['chapters'][$current_chapter]['pages'] as $pkey => $page_title ) {
            $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $current_chapter . '&' . $pkey) . '">' . $page_title . '</a></li>';
          }

         $online_books_list .= '</ul></li>';
        }
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
