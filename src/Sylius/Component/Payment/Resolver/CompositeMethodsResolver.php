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

namespace Sylius\Component\Payment\Resolver;

use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Registry\PrioritizedServiceRegistryInterface;

final class CompositeMethodsResolver implements PaymentMethodsResolverInterface
{
    public function __construct(private PrioritizedServiceRegistryInterface $resolversRegistry)
    {
    }

    public function getSupportedMethods(PaymentInterface $payment): array
    {
        /** @var PaymentMethodsResolverInterface $resolver */
        foreach ($this->resolversRegistry->all() as $resolver) {
            if ($resolver->supports($payment)) {
                return $resolver->getSupportedMethods($payment);
            }
        }

        return [];
    }

    public function supports(PaymentInterface $payment): bool
    {
        /** @var PaymentMethodsResolverInterface $resolver */
        foreach ($this->resolversRegistry->all() as $resolver) {
            if ($resolver->supports($payment)) {
                return true;
            }
        }

        return false;
    }
}
