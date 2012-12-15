<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Tag;

  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class image extends \osCommerce\OM\Core\Template\TagAbstract {
    static public function execute($string) {
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      $caption = null;

      if ( strpos($string, '|') !== false ) {
        list($image, $caption) = explode('|', $string, 2);
      } else {
        $image = $string;
      }

      $result = '<p align="center"><img src="' . OSCOM::getPublicSiteLink('Asset/' . OSCOM::getSiteApplication() . '/Content/' . $OSCOM_Language->getCode() . '/' . $OSCOM_Template->getValue('current_book') . '/' . $OSCOM_Template->getValue('current_chapter') . '/_images/' . $image) . '" />';

      if ( isset($caption) ) {
        $result .= '<br /><small><strong><em>' . $caption . '</em></strong></small>';
      }

      $result .= '</p>';

      return $result;
    }
  }
?>
