<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Tag;

  use osCommerce\OM\Core\Registry;

  class toc extends \osCommerce\OM\Core\Template\TagAbstract {
    static public function execute($file = null) {
      $OSCOM_Template = Registry::get('Template');

      if ( empty($file) ) {
        if ( $OSCOM_Template->valueExists('current_page_file') ) {
          $file = $OSCOM_Template->getValue('current_page_file');
        }
      }

      if ( empty($file) || !file_exists($file) ) {
        trigger_error('{toc} file does not exist' . (!empty($file) ? ': ' . $file : '') . '.');

        return false;
      }

      $content = file_get_contents($OSCOM_Template->getValue('current_page_file'));

      preg_match_all('/<h([2-6])[^>]*>(.*)<\/h.>/', $content, $matches);

      $level = 0;

      $result = '';

      foreach ( $matches[1] as $key => $value ) {
        if ( $value > $level ) {
          $result .= '<ul>';
        } else {
          $result .= str_repeat('</li></ul>', $level - $value) . '</li>';
        }

        $result .= '<li><a href="#" onclick="$(window).scrollTop($(\'#bookPageContent :header:not(\\\'h1, .ignore\\\'):eq(' . $key . ')\').position().top - 40); return false;">' . $matches[2][$key] . '</a>';

        $level = $value;
      }

      if ( !empty($result) ) {
        $result .= str_repeat('</li></ul>', $level - 1);

        $result = '<div id="slideout"><div id="slideout_trichome">TOC</div><div id="slideout_inner">' . $result . '</div></div>';
      }

      return $result;
    }
  }
?>
