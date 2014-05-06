<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2014 osCommerce; http://www.oscommerce.com
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

      preg_match_all('/<h([1-6])[^>]*>(.*)<\/h.>/', $content, $matches);

      $level = 0;

      $result = '';

      foreach ( $matches[1] as $key => $value ) {
        if ( strpos($matches[0][$key], 'notoc') === false ) {
          if ( $value > $level ) {
            $result .= '<ul>';
          } else {
            $result .= str_repeat('</li></ul>', $level - $value) . '</li>';
          }

          if ( strpos($matches[2][$key], '<small>') !== false ) {
            $matches[2][$key] = substr($matches[2][$key], 0, strpos($matches[2][$key], '<small>'));
          }

          $result .= '<li><a href="#" onclick="$(window).scrollTop($(\'#bookPageContent :header:eq(' . $key . ')\').position().top - 40); return false;">' . $matches[2][$key] . '</a>';

          $level = $value;
        }
      }

      if ( !empty($result) ) {
        $result .= str_repeat('</li></ul>', $level - 1);

        $result = '<div id="toc">' . $result . '</div>';
      }

      return $result;
    }
  }
?>
