<?php

namespace AndrewAndante\MagicLinks\Extension;

use AndrewAndante\MagicLinks\Model\MagicLink;
use SilverStripe\ORM\DataExtension;

class MagicLinkExtension extends DataExtension
{
  /**
   * @var array 
   */
  private static $has_one = [
    'MagicLink' => MagicLink::class,
  ];

  public function generateMagicLink()
  {
    // There should only ever be one, so expire an existing one
    if ($this->MagicLink()->exists()) {
      $this->MagicLink()->expire()->write();
    }
    
    $newMagicLink = MagicLink::create();
    
  }
}