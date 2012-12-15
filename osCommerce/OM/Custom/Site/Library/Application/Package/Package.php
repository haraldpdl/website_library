<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Package;

  use osCommerce\OM\Core\DirectoryListing;

  class Package extends \osCommerce\OM\Core\Site\Library\BookAbstract {
    public function __construct($language) {
      $this->_language = $language;

      $this->_asset_path = OSCOM_PUBLIC_BASE_DIRECTORY . 'public/sites/Library/Asset/Package/Content/' . $this->_language . '/';

      $DLpack = new DirectoryListing($this->_asset_path);
      $DLpack->setIncludeFiles(false);

      foreach ( $DLpack->getFiles() as $dir ) {
        if ( file_exists($DLpack->getDirectory() . '/' . $dir['name'] . '/content.json') ) {
          $content = json_decode(file_get_contents($DLpack->getDirectory() . '/' . $dir['name'] . '/content.json'), true);

          $this->_content[$dir['name']] = $content;
        }
      }
    }

    public function getPages($chapter, $book) {
      $pages = array();

      foreach ( $this->_content[$book]['chapters'][$chapter]['pages'] as $key => $page ) {
        $pages[] = array('code' => $key,
                         'title' => $page['title']);
      }

      return $pages;
    }

    public function getPageTitle($code, $chapter, $book) {
      return $this->_content[$book]['chapters'][$chapter]['pages'][$code]['title'];
    }
  }
?>
