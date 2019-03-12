<?php

namespace AndrewAndante\MagicLinks\Extension;

use AndrewAndante\MagicLinks\Controller\MagicLinkController;
use AndrewAndante\MagicLinks\Model\MagicLink;
use SilverStripe\Control\Controller;
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
    $newMagicLink->TargetID = $this->getOwner()->ID;
    $newMagicLink->write();

    $this->MagicLinkID = $newMagicLink->ID;
    $this->write();
  }

  /**
   * @param null $member
   *
   * @return bool
   */
  public function canView($member = null)
  {
    if (Controller::curr() instanceof MagicLinkController) {
      return true;
    }

    return $this->getOwner()->canView($member);
  }
}