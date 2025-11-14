<?php

namespace App\Services\PaymentGateway;

interface PaymentGatewayInterface
{
    /**
     * Create an invoice/payment request
     *
     * @param array $data ['external_id', 'amount', 'description', 'customer', 'success_url', 'failure_url', ...]
     * @return array ['invoice_id', 'invoice_url', 'amount', 'status', ...]
     */
    public function createInvoice(array $data): array;

    /**
     * Get invoice details
     *
     * @param string $invoiceId
     * @return array
     */
    public function getInvoice(string $invoiceId): array;

    /**
     * Verify webhook signature/callback
     *
     * @param array $payload
     * @param string $signature
     * @return bool
     */
    public function verifyWebhook(array $payload, string $signature): bool;

    /**
     * Process payment callback/webhook
     *
     * @param array $payload
     * @return array ['status', 'invoice_id', 'payment_method', ...]
     */
    public function processCallback(array $payload): array;
}

