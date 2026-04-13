<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_name',
        'customer_phone',
        'subtotal',
        'discount',
        'tax',
        'total',
        'payment_status'
    ];

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    // Add this inside your Bill class
    public function getWhatsappUrlAttribute()
    {
        // 1. Format the phone number
        $phone = $this->customer_phone;
        if (strlen($phone) == 10) {
            $phone = '91' . $phone;
        }

        // 2. Generate the secure signed URL for the PDF
        $pdfLink = \Illuminate\Support\Facades\URL::signedRoute('public.billing.download', ['bill' => $this->id]);

        // 3. Draft the message using actual PHP newlines (\n)
        $message = "Hello *{$this->customer_name}*,\n\n";
        $message .= "Here is your bill summary from *Medhi Medicos*:\n";
        $message .= "------------------------\n";
        $message .= "Invoice No: {$this->invoice_no}\n";
        $message .= "Date: " . $this->created_at->format('d M Y') . "\n";
        $message .= "Total Amount: *₹" . number_format($this->total, 2) . "*\n";

        if ($this->payment_status === 'pending') {
            $message .= "Payment Status: 🔴 *Pending (Credit)*\n";
        } else {
            $message .= "Payment Status: 🟢 *Paid*\n";
        }

        $message .= "------------------------\n\n";
        $message .= "📄 *Download your full PDF Invoice here:*\n";
        $message .= "{$pdfLink}\n\n";
        $message .= "Thank you for shopping with us! 💊";

        // 4. Return the official WhatsApp API link (urlencode converts \n to proper %0A)
        return "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);
    }
}
