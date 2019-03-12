<?php

namespace AndrewAndante\MagicLinks\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * Class MagicLink
 *
 * @package AndrewAndante\MagicLinks
 *
 * @property string $Hash
 * @property DBDatetime $Expiry
 * @method DataObject Target()
 * @method DBDatetime getExpiry()
 * @method MagicLink setExpiry()
 * @method string getHash()
 * @method MagicLink setHash()
 */
class MagicLink extends DataObject
{
  /**
   * @var int
   */
  private $expiry_minutes;

  /**
   * @var string
   */
  private static $table_name = 'AndrewAndante_MagicLink';

  /**
   * @var array
   */
  private static $db = [
    'Hash' => DBVarchar::class,
    'Expiry' => DBDatetime::class,
  ];

  /**
   * @var array
   */
  private static $has_one = [
    'Target' => DataObject::class,
  ];

  /**
   * @return bool
   */
  public function hasNotExpired()
  {
    return DBDatetime::now()->getTimestamp() < $this->getExpiry()->getTimestamp();
  }

}