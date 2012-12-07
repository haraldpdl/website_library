<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Online;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class Controller extends \osCommerce\OM\Core\Site\Library\ApplicationAbstract {
    protected function initialize() {
      $OSCOM_Template = Registry::get('Template');

      $this->_page_contents = 'main.html';
      $this->_page_title = OSCOM::getDef('html_page_title');

      $book = $chapter = $page = null;

      $keys = array_keys($_GET);
      $position = array_search(OSCOM::getSiteApplication(), $keys);

      if ( isset($keys[$position + 2]) ) {
        $requested_book = $keys[$position + 2];

        if ( Online::bookExists($requested_book) ) {
          $book = $requested_book;

          if ( isset($keys[$position + 3]) ) {
            $requested_chapter = $keys[$position + 3];

            if ( Online::chapterExists($requested_chapter, $book) ) {
              $chapter = $requested_chapter;

              if ( isset($keys[$position + 4]) ) {
                $requested_page = $keys[$position + 4];

                if ( Online::pageExists($requested_page, $chapter, $book) ) {
                  $page = $requested_page;
                }
              }
            }
          }
        }
      }

      $OSCOM_Template->setValue('current_book', $book);
      $OSCOM_Template->setValue('current_chapter', $chapter);
      $OSCOM_Template->setValue('current_page', $page);

      if ( isset($book) ) {
        $OSCOM_Template->setValue('book_title', Online::getBookTitle($book));
        $OSCOM_Template->setValue('book_chapters', Online::getChapters($book));
        $OSCOM_Template->setValue('book_info_file', Online::getBookInfoFile($book));

        if ( isset($chapter) ) {
          $this->_page_contents = 'pages.html';

          $OSCOM_Template->setValue('chapter_title', Online::getChapterTitle($chapter, $book));
          $OSCOM_Template->setValue('book_chapter_pages', Online::getPages($chapter, $book));
          $OSCOM_Template->setValue('chapter_info_file', Online::hasChapterInfoFile($chapter, $book) ? Online::getChapterInfoFile($chapter, $book) : null);

          if ( isset($page) ) {
            $this->_page_contents = 'page.html';

            $OSCOM_Template->setValue('current_page_file', Online::getPageFile($page, $chapter, $book));
          }
        }
      }
    }
  }
?>
