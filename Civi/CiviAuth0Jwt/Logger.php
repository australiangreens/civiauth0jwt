<?php

namespace Civi\CiviAuth0Jwt;

class Logger {

  public static function debug($msg) {
    \CRM_Core_Error::debug_log_message($msg, FALSE, 'civiauth0jwt');
  }

}
