<?php

namespace Drupal\marucha5\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(){
        return [
            ConfigEvents::SAVE => 'onConfigSave',
        ];
    }

    public function onConfigSave(ConfigCrudEvent $event){
        $config = $event->getConfig();
        \Drupal::messenger()->addStatus('設定が保存されました' . $config->getName());
    }
}