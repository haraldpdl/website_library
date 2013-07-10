<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2012 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library\Module\Template\Tag;

  use osCommerce\OM\Core\HTML;

  class code extends \osCommerce\OM\Core\Template\TagAbstract {
    static public function execute($string) {
      $args = func_get_args();

      $language = 'php';

      if ( isset($args[1]) && !empty($args[1]) ) {
        $language = trim($args[1]);
      }

      return '<pre><code class="language-' . $language . '">' . HTML::outputProtected($string) . '</code></pre>';
    }
  }
?>
