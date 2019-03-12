<?php

namespace AndrewAndante\MagicLinks\Controller;

use AndrewAndante\MagicLinks\Model\MagicLink;
use SilverStripe\Control\Controller;

class MagicLinkController extends Controller
{
  
  public function index()
  {
    $hash = $this->getRequest()->param('ID');

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
    
    
  }
}