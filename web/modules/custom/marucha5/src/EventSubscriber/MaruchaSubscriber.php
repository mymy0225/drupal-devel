<?php

namespace Drupal\marucha5\EventSubscriber;

use Drupal\marucha5\Event\MaruchaEvents;
use Drupal\marucha5\Event\MaruchaFirstEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MaruchaSubscriber implements EventSubscriberInterface{
    public static function getSubscribedEvents(){
        return [
            MaruchaEvents::FIRST_EVENT => 'onMaruchaFirstEvent',
        ];
    }

    public function onMaruchaFirstEvent(MaruchaFirstEvent $event){
        $account = $event->getAccount();
        \Drupal::messenger()->addStatus('ログインしました: ' . $account->getAccountName());
    }
}