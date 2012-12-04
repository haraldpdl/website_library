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
    static $_content = array();
    static $_language;

    public static function load($language) {
      static::$_language = $language;

      static::$_content = json_decode(file_get_contents(OSCOM::BASE_DIRECTORY . 'Custom/Site/Library/Asset/Online/content_' . static::$_language . '.json'), true);
    }

    public static function getContent() {
      return static::$_content;
    }

    public static function bookExists($book) {
      return array_key_exists($book, static::$_content);
    }

    public static function chapterExists($chapter, $book) {
      return array_key_exists($chapter, static::$_content[$book]['chapters']);
    }

    public static function pageExists($page, $chapter, $book) {
      return file_exists(OSCOM::BASE_DIRECTORY . 'Custom/Site/Library/Asset/Online/Content/' . static::$_language . '/' . basename($book) . '/' . basename($chapter) . '/' . basename($page) . '.html');
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
      return OSCOM::BASE_DIRECTORY . 'Custom/Site/Library/Asset/Online/Content/' . static::$_language . '/' . basename($book) . '/' . basename($chapter) . '/' . basename($page) . '.html';
    }
  }
?>
