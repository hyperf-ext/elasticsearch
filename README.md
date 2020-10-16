# Hyperf Elasticsearch 组件

该组件为 [Elasticsearch](https://github.com/elastic/elasticsearch-php) 客户端的创建提供了工厂类封装。同时，得益于 [hyperf/guzzle](https://github.com/hyperf/guzzle) 协程组件，该组件为 Elasticsearch 的 `Handler` 实现了协程化，可配置为连接池模式。

## 安装

```shell script
composer require hyperf-ext/elasticsearch
```

> 如启用 Elasticsearch 客户端日志则需安装 [`hyperf/logger`](https://hyperf.wiki/2.0/#/zh-cn/logger) 组件。

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
    | Elasticsearch 日志设置
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

```php
<?php

use Elasticsearch\Client;
use Hyperf\Utils\ApplicationContext;

$client = ApplicationContext::getContainer()->get(Client::class);

$info = $client->info();
```