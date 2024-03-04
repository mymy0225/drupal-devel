<?php

namespace Drupal\marucha6;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages tapioca plugins.
 */
class TapiocaPluginManager extends DefaultPluginManager{

    public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler){
        parent::__construct(
            //ディレクトリを指定(Pluginディレクトリ内のTapiocaクラス)
            'Plugin/Tapioca',
            $namespaces,
            $module_handler,
            //インターフェースの名前空間を指定
            'Drupal\marucha6\TapiocaPluginInterface',
            //アノテーションクラスの名前空間
            'Drupal\marucha6\Annotation\Tapioca'
            );

        $this->alterInfo('tapioca_info');
        $this->setCacheBackend($cache_backend, 'tapioca_plugins');
    }
}