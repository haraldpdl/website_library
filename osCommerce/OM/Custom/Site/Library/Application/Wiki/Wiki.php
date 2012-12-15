<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Application\Wiki;

  class Wiki extends \osCommerce\OM\Core\Site\Library\BookAbstract {
    public function __construct($language) {
      $this->_language = $language;

      $this->_asset_path = OSCOM_PUBLIC_BASE_DIRECTORY . 'public/sites/Library/Asset/Wiki/Content/' . $this->_language . '/';

      $this->_content = json_decode(file_get_contents($this->_asset_path . 'content.json'), true);
    }
  }
?>
