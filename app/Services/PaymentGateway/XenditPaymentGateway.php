<?php

namespace App\Services\PaymentGateway;

use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class XenditPaymentGateway implements PaymentGatewayInterface
{
    protected InvoiceApi $apiInstance;

    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
        $this->apiInstance = new InvoiceApi();
    }

    public function createInvoice(array $data): array
    {
        try {
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => $data['external_id'] ?? 'inv-' . time(),
                'description' => $data['description'] ?? 'Payment Invoice',
                'amount' => $data['amount'],
                'invoice_duration' => $data['invoice_duration'] ?? 86400, // 24 hours
                'currency' => $data['currency'] ?? 'IDR',
                'reminder_time' => $data['reminder_time'] ?? 1,
                'customer' => $data['customer'] ?? [],
                'success_redirect_url' => $data['success_url'] ?? route('profile'),
                'failure_redirect_url' => $data['failure_url'] ?? route('profile'),
                'payment_methods' => $data['payment_methods'] ?? ['BCA', 'BNI', 'BSI', 'BRI', 'MANDIRI', 'PERMATA', 'ALFAMART', 'INDOMARET', 'OVO', 'DANA', 'LINKAJA', 'QRIS'],
            ]);

            $forUserId = $data['for_user_id'] ?? null;
            $invoice = $this->apiInstance->createInvoice($createInvoiceRequest, $forUserId);

            return [
                'invoice_id' => $invoice['external_id'],
                'invoice_url' => $invoice['invoice_url'],
                'amount' => $invoice['amount'],
                'status' => $invoice['status'],
                'currency' => $invoice['currency'],
                'expiry_date' => $invoice['expiry_date'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Xendit Invoice Creation Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getInvoice(string $invoiceId): array
    {
        try {
            $invoice = $this->apiInstance->getInvoiceById($invoiceId);
            return [
                'invoice_id' => $invoice['external_id'],
                'invoice_url' => $invoice['invoice_url'],
                'amount' => $invoice['amount'],
                'status' => $invoice['status'],
                'currency' => $invoice['currency'],
            ];
        } catch (\Exception $e) {
            Log::error('Xendit Get Invoice Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function verifyWebhook(array $payload, string $signature): bool
    {
        $expectedToken = config('services.xendit.webhook_secret');
        
        // Xendit uses x-callback-token header
        return $signature === $expectedToken;
    }

    public function processCallback(array $payload): array
    {
        // Xendit uses 'external_id' as the invoice identifier
        return [
            'status' => $payload['status'] ?? 'UNKNOWN',
            'invoice_id' => $payload['external_id'] ?? $payload['id'] ?? '',
            'payment_method' => $payload['payment_method'] ?? null,
            'payment_channel' => $payload['payment_channel'] ?? null,
            'paid_amount' => $payload['paid_amount'] ?? 0,
            'paid_at' => $payload['paid_at'] ?? null,
            // Include original payload for backward compatibility
            'external_id' => $payload['external_id'] ?? $payload['id'] ?? '',
        ];
    }
}

