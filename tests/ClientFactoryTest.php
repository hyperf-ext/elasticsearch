<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/elasticsearch.
 *
 * @link     https://github.com/hyperf-ext/elasticsearch
 * @contact  eric@zhu.email
 * @license  https://github.com/hyperf-ext/elasticsearch/blob/master/LICENSE
 */
namespace HyperfTest\Elasticsearch;

use Elasticsearch\Client;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Hyperf\Utils\ApplicationContext;
use HyperfExt\Elasticsearch\ClientFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ClientFactoryTest extends TestCase
{
    protected function setUp()
    {
        ApplicationContext::setContainer($container = new Container((new DefinitionSourceFactory(true))()));
        $config = Mockery::mock(ConfigInterface::class);
        $config->shouldReceive('get')->with('elasticsearch')->andReturn([
            'client' => [
                'hosts' => [
                    'http://localhost:9200',
                ],
                'retries' => 1,
            ],
            'pool' => [
                'enabled' => true,
                'min_connections' => 1,
                'max_connections' => 30,
                'wait_timeout' => 3.0,
                'max_idle_time' => 60,
            ],
            'logger' => [
                'enabled' => false,
                'name' => 'elasticsearch',
                'group' => 'default',
            ],
        ]);
        $container->set(ConfigInterface::class, $config);
        $container->set(Client::class, (new ClientFactory())($container));
    }

    public function testClient()
    {
        $this->assertInstanceOf('\Elasticsearch\Client', ApplicationContext::getContainer()->get(Client::class));
    }
}
