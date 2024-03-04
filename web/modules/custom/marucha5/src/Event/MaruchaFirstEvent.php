<?php

namespace Drupal\marucha5\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\user\UserInterface;

class MaruchaFirstEvent extends Event{

    protected $account;

    public function __construct(UserInterface $account){
        $this->account = $account;
    }

    public function getAccount(){
        return $this->account;
    }
}