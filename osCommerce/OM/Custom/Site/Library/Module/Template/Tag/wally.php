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

  class wally extends \osCommerce\OM\Core\Template\TagAbstract {
    static public function execute($book) {
      $OSCOM_Book = Registry::get($book);
      $OSCOM_Language = Registry::get('Language');
      $OSCOM_Template = Registry::get('Template');

      $current_book = $OSCOM_Template->getValue('current_book');
      $current_chapter = $OSCOM_Template->getValue('current_chapter');
      $current_page = $OSCOM_Template->getValue('current_page');

      $result = '';

      $previous = $OSCOM_Book->getPreviousPage($current_page, $current_chapter, $current_book);

      if ( is_array($previous) ) {
        if ( isset($previous['page']) ) {
          $title = '';

          if ( $previous['chapter'] != $current_chapter ) {
            $title .= $OSCOM_Book->getChapterTitle($previous['chapter'], $previous['book']) . ': ';
          }

          $title .= $OSCOM_Book->getPageTitle($previous['page'], $previous['chapter'], $previous['book']);
        } else {
          $title = $OSCOM_Book->getChapterTitle($previous['chapter'], $previous['book']);
        }

        $result .= '<span id="wallyPrevious"><a href="' . OSCOM::getLink(null, OSCOM::getSiteApplication(), $OSCOM_Language->getCode() . '&' . $previous['book'] . '&' . $previous['chapter'] . (isset($previous['page']) ? '&' . $previous['page'] : '')) . '"><i class="icon-arrow-left"></i>' . $title . '</a></span>';
      }

      $next = $OSCOM_Book->getNextPage($current_page, $current_chapter, $current_book);

      if ( is_array($next) ) {
        if ( isset($next['page']) ) {
          $title = '';

          if ( $next['chapter'] != $current_chapter ) {
            $title .= $OSCOM_Book->getChapterTitle($next['chapter'], $next['book']) . ': ';
          }

          $title .= $OSCOM_Book->getPageTitle($next['page'], $next['chapter'], $next['book']);
        } else {
          $title = $OSCOM_Book->getChapterTitle($next['chapter'], $next['book']);
        }

        $result .= '<span id="wallyNext"><a href="' . OSCOM::getLink(null, OSCOM::getSiteApplication(), $OSCOM_Language->getCode() . '&' . $next['book'] . '&' . $next['chapter'] . (isset($next['page']) ? '&' . $next['page'] : '')) . '">' . $title . '<i class="icon-arrow-right"></i></a></span>';
      }

      if ( !empty($result) ) {
        $result = '<div id="wally">' . $result . '</div>';
      }

      return $result;
    }
  }
?>
