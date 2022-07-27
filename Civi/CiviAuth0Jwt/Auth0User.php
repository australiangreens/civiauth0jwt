<?php

namespace Civi\CiviAuth0Jwt;

/**
 * User
 *
 */
class Auth0User {

  public const AUTH0_SUB_PREFIX = 'auth0|';

  /**
   * @var string
   */
  public $subClaim;

  /**
   * @var int
   */
  public $auth0Id;

  /**
   * @var int
   */
  private $_cmsUserId;

  /**
   * @var string
   */
  protected $lookupTableName;

  /**
   * @var string
   */
  protected $lookupTableAuth0Col;

  /**
   * @var bool
   */
  protected $lookupTableAuth0ColIsPrefixed;

  /**
   * @var string
   */
  protected $lookupTableCmsCol;

  /**
   * Auth0User constructor.
   */
  public function __construct(string $jwtSubClaim) {
    if (substr($jwtSubClaim, 0, 6) !== self::AUTH0_SUB_PREFIX) {
      throw new Exception\SubClaimParseException("jwtSubClaim '$jwtSubClaim' does have expected prefix");
    }

    $this->subClaim = $jwtSubClaim;

    $this->auth0Id = substr($jwtSubClaim, 6);

    if (empty($this->auth0Id)) {
      throw new Exception\SubClaimParseException("jwtSubClaim '$jwtSubClaim' has expected prefix, but nothing after");
    }

    $this->lookupTableName = \Civi::settings()->get('civiauth0jwt_user_lookup_table_name');
    $this->lookupTableAuth0Col = \Civi::settings()->get('civiauth0jwt_user_lookup_table_auth0_col');
    $this->lookupTableAuth0ColIsPrefixed = \Civi::settings()->get('civiauth0jwt_user_lookup_table_auth0_col_contains_prefix');
    $this->lookupTableCmsCol = \Civi::settings()->get('civiauth0jwt_user_lookup_table_cms_col');

    if (empty($this->lookupTableName) || empty($this->lookupTableAuth0Col) || empty($this->lookupTableCmsCol)) {
      throw new Exception\CiviAuth0JwtException("Required settings for user lookup not set");
    }
  }

  public function getCmsUserId(): int {
    if (!$this->_cmsUserId) {
      $table = $this->lookupTableName;
      $auth0Col = $this->lookupTableAuth0Col;
      $cmsCol = $this->lookupTableCmsCol;

      // ! NEED TO ESCAPE THE NAMES?
      $result = \CRM_Core_DAO::singleValueQuery(
        " SELECT `$cmsCol`
          FROM `$table`
          WHERE `$auth0Col` = %1
        ",
        [
          1 => [$this->lookupTableSearchVal(), 'String'],
        ]
      );

      if (empty($result)) {
        throw new Exception\UserMatchNotFoundException("No entry found in '$table' for '" . $this->lookupTableSearchVal());
      }

      $this->_cmdUserId = $result;
    }

    return $this->_cmdUserId;
  }

  private function lookupTableSearchVal() {
    return $this->lookupTableAuth0ColIsPrefixed
      ? $this->subClaim
      : $this->auth0Id;
  }

}
