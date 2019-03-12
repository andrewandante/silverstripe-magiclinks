<?php

namespace AndrewAndante\MagicLinks\Controller;

use AndrewAndante\MagicLinks\Model\MagicLink;
use SilverStripe\Control\Controller;

class MagicLinkController extends Controller
{
  
  public function index()
  {
    $hash = $this->getRequest()->param('Hash');

    if (empty($hash)) {
      return $this->getResponse()
        ->setStatusCode(400);
    }

    $magicLink = MagicLink::get()->filter([
      'Hash' => $hash
    ])->first();
    
    if (
      $magicLink 
      && $magicLink->exists()
      && $magicLink->hasNotExpired()
    ) {
      return $magicLink->Target();
    }

    return $this->getResponse()->setStatusCode(404);
  }
}