<?php

namespace AndrewAndante\MagicLinks\Model;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injector;
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

  use Configurable;

  /**
   * @var int
   */
  private static $expiry_minutes;

  /**
   * @var int
   */
  private static $hash_length;

  /**
   * @var int
   */
  private static $hash_generation_retries;

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

  public function __construct()
  {
    parent::__construct();
    $this->setHash($this->generateHash());
    $now = DBDatetime::now()->getTimestamp();
    $expiry = $now + (self::config()->get('expiry_minutes') * 60);
    $this->setExpiry($expiry);
  }

  /**
   * @return bool
   */
  public function hasNotExpired()
  {
    return DBDatetime::now()->getTimestamp() < $this->getExpiry()->getTimestamp();
  }

  /**
   * @return self
   */
  public function expire()
  {
    if ($this->hasNotExpired()) {
      $this->setExpiry(DBDatetime::now());
    }

    return $this;
  }

  /**
   * Generates a URL-safe, unique string to match to the target 
   * @return string
   *
   * @throws \Exception
   * @throws \RuntimeException
   */
  protected function generateHash()
  {
    $hash = '';
    $length = self::config()->get('hash_length');
    $retries = self::config()->get('hash_generation_retries');
    $characters = array_merge(
      range('a', 'z'),
      range('0', '9')
    );
    $max = count($characters) - 1;

    for ($i = 0; $i < $retries; ++$i) {
      for ($j = 0; $j < $length; ++$j) {
        $randomIndex = random_int(0, $max);
        $hash .= $characters[$randomIndex];
      }
      if (!MagicLink::get()->filter(['Hash' => $hash])->exists()) {
        return $hash;
      }
    }

    throw new \RuntimeException(_t(
      'MAGICLINK.NO_UNIQUE_HASH', 
      "Could not generate unique hash for magic link within $retries retries"
    ));
  }

}