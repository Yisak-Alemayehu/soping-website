<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ApiBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sylius\Bundle\ApiBundle\ApiPlatform\Bridge\Symfony\Bundle\Action\SwaggerUiAction;
use Sylius\Bundle\ApiBundle\DependencyInjection\SyliusApiExtension;

final class SyliusApiExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function it_loads_swagger_integration_if_it_is_turned_on()
    {
        $this->setParameter('api_platform.enable_swagger_ui', true);
        $this->load();

        $this->assertContainerBuilderHasService('api_platform.swagger.action.ui', SwaggerUiAction::class);
    }

    /**
     * @test
     */
    public function it_does_not_load_swagger_integration_if_it_is_turned_off()
    {
        $this->setParameter('api_platform.enable_swagger_ui', false);
        $this->load();

        $this->assertContainerBuilderNotHasService('api_platform.swagger.action.ui');
    }

    /**
     * @test
     */
    public function it_does_not_load_swagger_integration_if_it_does_not_exists()
    {
        $this->load();

        $this->assertContainerBuilderNotHasService('api_platform.swagger.action.ui');
    }

    protected function getContainerExtensions(): array
    {
        return [
            new SyliusApiExtension(),
        ];
    }
}
