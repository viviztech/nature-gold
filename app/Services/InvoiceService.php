<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    /**
     * Generate a GST-compliant invoice PDF for an order.
     */
    public function generate(Order $order): string
    {
        $order->loadMissing(['items', 'user']);

        $data = [
            'order' => $order,
            'company' => [
                'name' => config('app.name', 'Nature Gold'),
                'address' => 'Tamil Nadu, India',
                'phone' => config('app.phone', ''),
                'email' => config('app.email', ''),
                'gst' => config('app.gst_number', ''),
            ],
            'invoice_number' => 'INV-' . $order->order_number,
            'invoice_date' => $order->created_at->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data)
            ->setPaper('a4')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
            ]);

        $path = "invoices/{$order->order_number}.pdf";
        Storage::disk('local')->put($path, $pdf->output());

        return $path;
    }

    /**
     * Download the invoice PDF for an order.
     */
    public function download(Order $order)
    {
        $order->loadMissing(['items', 'user']);

        $data = [
            'order' => $order,
            'company' => [
                'name' => config('app.name', 'Nature Gold'),
                'address' => 'Tamil Nadu, India',
                'phone' => config('app.phone', ''),
                'email' => config('app.email', ''),
                'gst' => config('app.gst_number', ''),
            ],
            'invoice_number' => 'INV-' . $order->order_number,
            'invoice_date' => $order->created_at->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data)
            ->setPaper('a4')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download("Invoice-{$order->order_number}.pdf");
    }
}
