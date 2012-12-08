<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Online;

  use osCommerce\OM\Core\OSCOM;

  class Online {
    static $_asset_path;
    static $_content = array();
    static $_language;

    public static function load($language) {
      static::$_asset_path = OSCOM_PUBLIC_BASE_DIRECTORY . 'public/sites/Library/Asset/';

      static::$_language = $language;

      static::$_content = json_decode(file_get_contents(static::$_asset_path . 'Online/Content/' . static::$_language . '/content.json'), true);
    }

    public static function getContent() {
      return static::$_content;
    }

    public static function bookExists($book) {
      return array_key_exists($book, static::$_content);
    }

    public static function getBookTitle($code) {
      return static::$_content[$code]['title'];
    }

    public static function getBookCopyright($book) {
      return static::$_content[$book]['copyright'];
    }

    public static function getBookAuthors($book) {
      $authors = array();

      foreach ( static::$_content[$book]['authors'] as $author ) {
        $authors[] = array('name' => $author['name']);
      }

      return $authors;
    }

    public static function getChapterTitle($code, $book) {
      return static::$_content[$book]['chapters'][$code]['title'];
    }

    public static function getPageTitle($code, $chapter, $book) {
      return static::$_content[$book]['chapters'][$chapter]['pages'][$code];
    }

    public static function chapterExists($chapter, $book) {
      return array_key_exists($chapter, static::$_content[$book]['chapters']);
    }

    public static function pageExists($page, $chapter, $book) {
      return file_exists(static::$_asset_path . 'Online/Content/' . static::$_language . '/' . basename($book) . '/' . basename($chapter) . '/' . basename($page) . '.html');
    }

    public static function getBooks() {
      $books = array();

      foreach ( static::$_content as $key => $book ) {
        $books[] = array('code' => $key,
                         'title' => $book['title']);
      }

      return $books;
    }

    public static function getChapters($book) {
      $chapters = array();

      foreach ( static::$_content[$book]['chapters'] as $key => $chapter ) {
        $chapters[] = array('code' => $key,
                            'title' => $chapter['title']);
      }

      return $chapters;
    }

    public static function getPages($chapter, $book) {
      $pages = array();

      foreach ( static::$_content[$book]['chapters'][$chapter]['pages'] as $key => $title ) {
        $pages[] = array('code' => $key,
                         'title' => $title);
      }

      return $pages;
    }

    public static function getPageFile($page, $chapter, $book) {
      return static::$_asset_path . 'Online/Content/' . static::$_language . '/' . basename($book) . '/' . basename($chapter) . '/' . basename($page) . '.html';
    }
  }
?>
