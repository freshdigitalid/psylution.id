<?php

namespace App\Services\PaymentGateway;

use Illuminate\Support\Facades\Log;

class PaymentGatewayFactory
{
    /**
     * Create payment gateway instance based on provider
     */
    public static function create(string $provider = null): PaymentGatewayInterface
    {
        $provider = $provider ?? config('services.payment_gateway.provider', 'xendit');

        return match ($provider) {
            'xendit' => new XenditPaymentGateway(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway provider: {$provider}"),
        };
    }
}

