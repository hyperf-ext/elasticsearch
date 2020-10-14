# Hyperf Elasticsearch 组件

实现通过协程和连接池来与 Elasticsearch 交互，同时对模型提供有限的支持。

## 安装

```shell script
composer require hyperf-ext/elasticsearch
```

> 如启用 ES 日志则需安装 [`hyperf/logger`](https://hyperf.wiki/2.0/#/zh-cn/logger) 组件。

## 发布配置

```shell script
php bin/hyperf.php vendor:publish hyperf-ext/elasticsearch
```

## 配置

```php
[
    /*
    |--------------------------------------------------------------------------
    | 自定义 Elasticsearch 客户端配置
    |--------------------------------------------------------------------------
    |
    | 详细设置请参阅:
    | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
    */

    'client' => [
        'hosts' => [
            'http://localhost:9200',
        ],
        'retries' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | 连接池设置
    |--------------------------------------------------------------------------
    */

    'pool' => [
        'enabled' => true,
        'min_connections' => 1,
        'max_connections' => 30,
        'wait_timeout' => 3.0,
        'max_idle_time' => 60.0,
    ],

    /*
    |--------------------------------------------------------------------------
    | 日志设置
    |--------------------------------------------------------------------------
    |
    | 启用日志需安装 `hyperf/logger` 组件。
    */

    'logger' => [
        'enabled' => false,
        'name' => 'elasticsearch',
        'group' => 'default',
    ],
];
```

## 使用

只需简单的注入 `Elasticsearch\Client` 类即可获取客户端实例对象，所有相关配置都已在 `HyperfExt\Elasticsearch\ClientFactory` 工厂类中完成。

默认配置下，组件会将 ES 的 `Handler` 设置为连接池版本。如果不需要使用连接池，请将 `pool.enabled` 配置项设置为 `false`，组件将会使用协程版本的 `Handler`。
