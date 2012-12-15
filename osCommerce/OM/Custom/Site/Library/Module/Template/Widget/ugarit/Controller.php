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

  class Controller extends \osCommerce\OM\Core\Template\WidgetAbstract {
    static public function execute($param = null) {
      $OSCOM_CoreBook = Registry::get('CoreBook');
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      $current_book = $OSCOM_Template->valueExists('current_book') ? $OSCOM_Template->getValue('current_book') : null;
      $current_chapter = $OSCOM_Template->valueExists('current_chapter') ? $OSCOM_Template->getValue('current_chapter') : null;
      $current_page = $OSCOM_Template->valueExists('current_page') ? $OSCOM_Template->getValue('current_page') : null;

      $current_book_title = OSCOM::getDef('books_title');

      if ( (OSCOM::getSiteApplication() == 'Online') && isset($current_book) ) {
        $current_book_title = $OSCOM_CoreBook->getTitle($current_book);
      } elseif ( OSCOM::getSiteApplication() == 'Package' ) {
        $current_book_title = OSCOM::getDef('books_packages_title');
      } elseif ( OSCOM::getSiteApplication() == 'Wiki' ) {
        $current_book_title = OSCOM::getDef('books_wiki_title');
      }

      $online_books_list = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $current_book_title . '<b class="caret"></b></a>
                              <ul class="dropdown-menu">';

      foreach ( $OSCOM_CoreBook->getBooks() as $book ) {
        $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $book['code']) . '">' . $book['title'] . '</a></li>';
      }

      $online_books_list .= '<li class="divider"></li>' .
                            '<li><a href="' . OSCOM::getLink(null, 'Package', $OSCOM_Language->getCode()) . '">' . OSCOM::getDef('books_packages_title') . '</a></li>' .
                            '<li><a href="' . OSCOM::getLink(null, 'Wiki', $OSCOM_Language->getCode()) . '">' . OSCOM::getDef('books_wiki_title') . '</a></li>' .
                            '</ul></li>';

      if ( (OSCOM::getSiteApplication() == 'Online') && isset($current_book) && isset($current_chapter) ) {
        $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_CoreBook->getChapterTitle($current_chapter, $current_book) . '<b class="caret"></b></a>
                                 <ul class="dropdown-menu">';

        foreach ( $OSCOM_CoreBook->getChapters($current_book) as $chapter ) {
          $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $chapter['code']) . '">' . $chapter['title'] . '</a></li>';
        }

        $online_books_list .= '</ul></li>';

        if ( isset($current_page) ) {
          $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_CoreBook->getPageTitle($current_page, $current_chapter, $current_book) . '<b class="caret"></b></a>
                                   <ul class="dropdown-menu">';

          foreach ( $OSCOM_CoreBook->getPages($current_chapter, $current_book) as $page ) {
            $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Online', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $current_chapter . '&' . $page['code']) . '">' . $page['title'] . '</a></li>';
          }

          $online_books_list .= '</ul></li>';
        }
      } elseif ( (OSCOM::getSiteApplication() == 'Package') && isset($current_book) ) {
        $OSCOM_PackageBook = Registry::get('PackageBook');

        $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Package', $OSCOM_Language->getCode() . '&' . $current_book) . '">' . $OSCOM_PackageBook->getTitle($current_book) . '</a></li>';

        if ( isset($current_chapter) ) {
          $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_PackageBook->getChapterTitle($current_chapter, $current_book) . '<b class="caret"></b></a>
                                   <ul class="dropdown-menu">';

          foreach ( $OSCOM_PackageBook->getChapters($current_book) as $chapter ) {
            $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Package', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $chapter['code']) . '">' . $chapter['title'] . '</a></li>';
          }

          $online_books_list .= '</ul></li>';

          if ( isset($current_page) ) {
            $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_PackageBook->getPageTitle($current_page, $current_chapter, $current_book) . '<b class="caret"></b></a>
                                     <ul class="dropdown-menu">';

            foreach ( $OSCOM_PackageBook->getPages($current_chapter, $current_book) as $page ) {
              $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Package', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $current_chapter . '&' . $page['code']) . '">' . $page['title'] . '</a></li>';
            }

            $online_books_list .= '</ul></li>';
          }
        }
      } elseif ( (OSCOM::getSiteApplication() == 'Wiki') && isset($current_book) ) {
        $OSCOM_WikiBook = Registry::get('WikiBook');

        $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_WikiBook->getTitle($current_book) . '<b class="caret"></b></a>
                                <ul class="dropdown-menu">';

        foreach ( $OSCOM_WikiBook->getBooks() as $book ) {
          $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Wiki', $OSCOM_Language->getCode() . '&' . $book['code']) . '">' . $book['title'] . '</a></li>';
        }

        $online_books_list .= '</ul></li>';

        if ( isset($current_chapter) ) {
          $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_WikiBook->getChapterTitle($current_chapter, $current_book) . '<b class="caret"></b></a>
                                   <ul class="dropdown-menu">';

          foreach ( $OSCOM_WikiBook->getChapters($current_book) as $chapter ) {
            $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Wiki', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $chapter['code']) . '">' . $chapter['title'] . '</a></li>';
          }

          $online_books_list .= '</ul></li>';

          if ( isset($current_page) ) {
            $online_books_list .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $OSCOM_WikiBook->getPageTitle($current_page, $current_chapter, $current_book) . '<b class="caret"></b></a>
                                     <ul class="dropdown-menu">';

            foreach ( $OSCOM_WikiBook->getPages($current_chapter, $current_book) as $page ) {
              $online_books_list .= '<li><a href="' . OSCOM::getLink(null, 'Wiki', $OSCOM_Language->getCode() . '&' . $current_book . '&' . $current_chapter . '&' . $page['code']) . '">' . $page['title'] . '</a></li>';
            }

            $online_books_list .= '</ul></li>';
          }
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
