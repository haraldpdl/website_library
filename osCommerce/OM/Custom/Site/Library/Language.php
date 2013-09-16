<?php
/**
 * osCommerce Website
 * 
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 */

  namespace osCommerce\OM\Core\Site\Library;

  use osCommerce\OM\Core\DirectoryListing;
  use osCommerce\OM\Core\OSCOM;

  class Language extends \osCommerce\OM\Core\Site\Admin\Language {
    public function __construct() {
      $DLlang = new DirectoryListing(OSCOM::BASE_DIRECTORY . 'Custom/Site/Library/Language');
      $DLlang->setIncludeDirectories(false);
      $DLlang->setCheckExtension('php');

      foreach ( $DLlang->getFiles() as $file ) {
        $lang = $this->readIniFile($file['name']);

        $this->_languages[$lang['lang_code']] = array('code' => $lang['lang_code'],
                                                      'name' => $lang['lang_title'],
                                                      'locale' => $lang['lang_locale'],
                                                      'charset' => $lang['lang_character_set'],
                                                      'date_format_short' => $lang['lang_date_format_short'],
                                                      'date_format_long' => $lang['lang_date_format_long'],
                                                      'time_format' => $lang['lang_time_format'],
                                                      'text_direction' => $lang['lang_direction'],
                                                      'parent' => $lang['lang_parent_code']);
      }

      unset($lang);

      $language = null;

      $keys = array_keys($_GET);
      $position = array_search(OSCOM::getSiteApplication(), $keys);

      if ( isset($keys[$position + 1]) && $this->exists($keys[$position + 1]) ) {
        $language = $keys[$position + 1];
      }

      $this->set($language);

      header('Content-Type: text/html; charset=' . $this->getCharacterSet());
      setlocale(LC_TIME, explode(',', $this->getLocale()));

      $this->loadIniFile();
      $this->loadIniFile(OSCOM::getSiteApplication() . '.php');
    }

    public function set($code = null) {
      $this->_code = $code;

      if ( empty($this->_code) ) {
        if ( isset($_COOKIE[OSCOM::getSite()]['language']) ) {
          $this->_code = $_COOKIE[OSCOM::getSite()]['language'];
        } else {
          $this->_code = $this->getBrowserSetting();
        }
      }

      if ( empty($this->_code) || !$this->exists($this->_code) ) {
        $this->_code = 'en';
      }

      if ( !isset($_COOKIE[OSCOM::getSite()]['language']) || ($_COOKIE[OSCOM::getSite()]['language'] != $this->_code) ) {
        OSCOM::setCookie(OSCOM::getSite() . '[language]', $this->_code, time()+60*60*24*90);
      }
    }

    public function readIniFile($filename = null, $comment = '#') {
      if ( substr(realpath(OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Language/' . $filename), 0, strlen(realpath(OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Language/'))) != realpath(OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Language/') ) {
        return array();
      }

      if ( file_exists(OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Language/' . $filename) ) {
        $contents = file(OSCOM::BASE_DIRECTORY . 'Custom/Site/' . OSCOM::getSite() . '/Language/' . $filename);
      } else {
        return array();
      }

      $ini_array = array();

      foreach ( $contents as $line ) {
        $line = trim($line);

        $firstchar = substr($line, 0, 1);

        if ( !empty($line) && ( $firstchar != $comment) ) {
          $delimiter = strpos($line, '=');

          if ( ($delimiter !== false) && ( substr_count(substr($line, 0, $delimiter), ' ') == 1 ) ) {
            $key = trim(substr($line, 0, $delimiter));
            $value = trim(substr($line, $delimiter + 1));

            $ini_array[$key] = $value;
          } elseif ( isset($key) ) {
            $ini_array[$key] .= "\n" . trim($line);
          }
        }
      }

      unset($contents);

      return $ini_array;
    }

    public function loadIniFile($filename = null, $comment = '#', $language_code = null) {
      if ( !isset($language_code) ) {
        $language_code = $this->_code;
      }

      if ( !isset($filename) ) {
        $filename = $language_code . '.php';
      } else {
        $filename = $language_code . '/' . $filename;
      }

      if ( !empty($this->_languages[$language_code]['parent']) ) {
        $this->loadIniFile($filename, $comment, $this->_languages[$language_code]['parent']);
      }

      $this->_definitions = array_merge($this->_definitions, $this->readIniFile($filename));
    }
  }
?>
