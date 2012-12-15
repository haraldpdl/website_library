<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Wiki;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class Controller extends \osCommerce\OM\Core\Site\Library\ApplicationAbstract {
    protected function initialize() {
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      Registry::set('WikiBook', new Wiki($OSCOM_Language->getCode()));
      $OSCOM_WikiBook = Registry::get('WikiBook');

      $OSCOM_Template->setValue('wiki', $OSCOM_WikiBook->getBooks());

      $this->_page_contents = 'main.html';
      $this->_page_title = OSCOM::getDef('html_page_title_base');

      $book = $chapter = $page = null;

      $keys = array_keys($_GET);
      $position = array_search(OSCOM::getSiteApplication(), $keys);

      if ( isset($keys[$position + 2]) ) {
        $requested_book = $keys[$position + 2];

        if ( $OSCOM_WikiBook->exists($requested_book) ) {
          $book = $requested_book;

          if ( isset($keys[$position + 3]) ) {
            $requested_chapter = $keys[$position + 3];

            if ( $OSCOM_WikiBook->chapterExists($requested_chapter, $book) ) {
              $chapter = $requested_chapter;

              if ( isset($keys[$position + 4]) ) {
                $requested_page = $keys[$position + 4];

                if ( $OSCOM_WikiBook->pageExists($requested_page, $chapter, $book) ) {
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
        $this->_page_contents = 'chapters.html';

        $OSCOM_Template->setValue('book_title', $OSCOM_WikiBook->getTitle($book));
        $OSCOM_Template->setValue('book_description', $OSCOM_WikiBook->getDescription($book));
        $OSCOM_Template->setValue('book_chapters', $OSCOM_WikiBook->getChapters($book));

        $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title');

        if ( isset($chapter) ) {
          $this->_page_contents = 'pages.html';

          $OSCOM_Template->setValue('chapter_title', $OSCOM_WikiBook->getChapterTitle($chapter, $book));
          $OSCOM_Template->setValue('book_chapter_pages', $OSCOM_WikiBook->getPages($chapter, $book));

          $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title') . ', ' . $OSCOM_Template->getValue('chapter_title');

          if ( isset($page) ) {
            $this->_page_contents = 'page.html';

            $OSCOM_Template->setValue('current_page_file', $OSCOM_WikiBook->getPageFile($page, $chapter, $book));

            $this->_page_title = OSCOM::getDef('html_page_title_base') . ', ' . $OSCOM_Template->getValue('book_title') . ', ' . $OSCOM_Template->getValue('chapter_title') . ', ' . $OSCOM_WikiBook->getPageTitle($page, $chapter, $book);
          }
        }
      }
    }
  }
?>
