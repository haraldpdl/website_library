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
      return '<pre class="prettyprint">' . HTML::outputProtected($string) . '</pre>';
    }
  }
?>
