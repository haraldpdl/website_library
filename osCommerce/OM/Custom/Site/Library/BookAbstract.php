<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2014 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library;

  abstract class BookAbstract {
    protected $_language;
    protected $_asset_path;
    protected $_content = array();

    public function getContent($book = null) {
      if ( isset($book) ) {
        return $this->_content[$book];
      }

      return $this->_content;
    }

    public function exists($book) {
      return array_key_exists($book, $this->_content);
    }

    public function getBooks() {
      $books = array();

      foreach ( $this->_content as $key => $book ) {
        $books[] = array('code' => $key,
                         'title' => $book['title']);
      }

      return $books;
    }

    public function hasImage($code) {
      return isset($this->_content[$code]['image']);
    }

    public function getImage($code) {
      return $this->_content[$code]['image'];
    }

    public function getTitle($code) {
      return $this->_content[$code]['title'];
    }

    public function getDescription($code) {
      return $this->_content[$code]['description'];
    }

    public function getCopyright($book) {
      return $this->_content[$book]['copyright'];
    }

    public function getAuthors($book) {
      $authors = array();

      foreach ( $this->_content[$book]['authors'] as $author ) {
        $authors[] = array('name' => $author['name']);
      }

      return $authors;
    }

    public function chapterExists($chapter, $book) {
      return array_key_exists($chapter, $this->_content[$book]['chapters']);
    }

    public function getChapters($book) {
      $chapters = array();

      foreach ( $this->_content[$book]['chapters'] as $key => $chapter ) {
        $chapters[] = array('code' => $key,
                            'title' => $chapter['title']);
      }

      return $chapters;
    }

    public function getChapterTitle($code, $book) {
      return $this->_content[$book]['chapters'][$code]['title'];
    }

    public function pageExists($page, $chapter, $book) {
      return file_exists($this->getPageFile($page, $chapter, $book));
    }

    public function getPageTitle($code, $chapter, $book) {
      return $this->_content[$book]['chapters'][$chapter]['pages'][$code];
    }

    public function getPages($chapter, $book) {
      $pages = array();

      foreach ( $this->_content[$book]['chapters'][$chapter]['pages'] as $key => $title ) {
        $pages[] = array('code' => $key,
                         'title' => $title);
      }

      return $pages;
    }

    public function getPageFile($page, $chapter, $book) {
      return $this->_asset_path . basename($book) . '/' . basename($chapter) . '/' . basename($page) . '.html';
    }

    public function getPreviousPage($page, $chapter, $book) {
      $result = null;

      $pos = array_search($page, array_keys($this->_content[$book]['chapters'][$chapter]['pages']));

      if ( $pos > 0 ) {
        $result = array('book' => $book,
                        'chapter' => $chapter,
                        'page' => key(array_slice($this->_content[$book]['chapters'][$chapter]['pages'], $pos-1, 1, true)));
      } else {
        $pos = array_search($chapter, array_keys($this->_content[$book]['chapters']));

        if ( $pos > 0 ) {
// last page of previous chapter
          $previous_chapter = key(array_slice($this->_content[$book]['chapters'], $pos-1, 1, true));

          $result = array('book' => $book,
                          'chapter' => $previous_chapter,
                          'page' => key(array_slice($this->_content[$book]['chapters'][$previous_chapter]['pages'], (count($this->_content[$book]['chapters'][$previous_chapter]['pages'])-1), 1, true)));
        }
      }

      return $result;
    }

    public function getNextPage($page, $chapter, $book) {
      $result = null;

      $pos = array_search($page, array_keys($this->_content[$book]['chapters'][$chapter]['pages']));

      if ( $pos < (count($this->_content[$book]['chapters'][$chapter]['pages'])-1) ) {
        $result = array('book' => $book,
                        'chapter' => $chapter,
                        'page' => key(array_slice($this->_content[$book]['chapters'][$chapter]['pages'], $pos+1, 1, true)));
      } else {
        $pos = array_search($chapter, array_keys($this->_content[$book]['chapters']));

        if ( $pos < (count($this->_content[$book]['chapters'])-1) ) {
// first page of next chapter
          $next_chapter = key(array_slice($this->_content[$book]['chapters'], $pos+1, 1, true));

          $result = array('book' => $book,
                          'chapter' => $next_chapter,
                          'page' => key(array_slice($this->_content[$book]['chapters'][$next_chapter]['pages'], 0, 1, true)));
        }
      }

      return $result;
    }
  }
?>
