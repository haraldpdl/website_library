<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2014 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Tag;

  use osCommerce\OM\Core\HTML;
  use osCommerce\OM\Core\OSCOM;
  use osCommerce\OM\Core\Registry;

  class bookimage extends \osCommerce\OM\Core\Template\TagAbstract {
    static public function execute($string) {
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      $caption = null;

      if ( strpos($string, '|') !== false ) {
        list($image, $caption) = explode('|', $string, 2);
      } else {
        $image = $string;
      }

      return '<a href="' . OSCOM::getLink(null, 'Package', $OSCOM_Language->getCode() . '&' . $OSCOM_Template->getValue('current_book')) . '">' . HTML::image(OSCOM::getPublicSiteLink('Asset/' . OSCOM::getSiteApplication() . '/Content/' . $OSCOM_Language->getCode() . '/' . $OSCOM_Template->getValue('current_book') . '/_images/' . $image), $caption) . '</a>';
    }
  }
?>
