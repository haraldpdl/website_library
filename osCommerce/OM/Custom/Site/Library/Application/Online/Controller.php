<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Online;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class Controller extends \osCommerce\OM\Core\Site\Library\ApplicationAbstract {
    protected function initialize() {
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      $OSCOM_CoreBook = Registry::get('CoreBook');

      $OSCOM_Template->setValue('books', $OSCOM_CoreBook->getBooks());

      $this->_page_contents = 'main.html';
      $this->_page_title = OSCOM::getDef('html_page_title');

      $book = $chapter = $page = null;

      $keys = array_keys($_GET);
      $position = array_search(OSCOM::getSiteApplication(), $keys);

      if ( isset($keys[$position + 1]) ) {
        $position++;

        if ( $OSCOM_Language->exists($keys[$position]) ) {
          $position++;
        }

        if ( isset($keys[$position]) ) {
          $requested_book = $keys[$position];

          if ( $OSCOM_CoreBook->exists($requested_book) ) {
            $book = $requested_book;

            if ( isset($keys[$position + 1]) ) {
              $requested_chapter = $keys[$position + 1];

              if ( $OSCOM_CoreBook->chapterExists($requested_chapter, $book) ) {
                $chapter = $requested_chapter;

                if ( isset($keys[$position + 2]) ) {
                  $requested_page = $keys[$position + 2];

                  if ( $OSCOM_CoreBook->pageExists($requested_page, $chapter, $book) ) {
                    $page = $requested_page;
                  }
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
        $this->_page_contents = 'chapters.html';

        $OSCOM_Template->setValue('book_title', $OSCOM_CoreBook->getTitle($book));
        $OSCOM_Template->setValue('book_description', $OSCOM_CoreBook->getDescription($book));
        $OSCOM_Template->setValue('book_chapters', $OSCOM_CoreBook->getChapters($book));

        $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title');

        if ( isset($chapter) ) {
          $this->_page_contents = 'pages.html';

          $OSCOM_Template->setValue('chapter_title', $OSCOM_CoreBook->getChapterTitle($chapter, $book));
          $OSCOM_Template->setValue('book_chapter_pages', $OSCOM_CoreBook->getPages($chapter, $book));

          $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title') . ', ' . $OSCOM_Template->getValue('chapter_title');

          if ( isset($page) ) {
            $this->_page_contents = 'page.html';

            $OSCOM_Template->setValue('current_page_file', $OSCOM_CoreBook->getPageFile($page, $chapter, $book));

            $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title') . ', ' . $OSCOM_Template->getValue('chapter_title') . ', ' . $OSCOM_CoreBook->getPageTitle($page, $chapter, $book);
          }
        }
      }
    }
  }
?>
