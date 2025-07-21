<?php

namespace App;

use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;

class TaxInvoice extends Model
{
    public function items(){
        return $this->hasMany(TaxInvoiceItem::class,'invoice_id');
    }

    public function customer(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }
    public function party(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }

    public function column_show(){
        return $this->hasOne(InvoiceColumnCheck::class,'tax_invoice_id');
    }
    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }


    // public function cost_center(){
    //     return $this->belongsTo(CostCenter::class,'project_id');
    // }

    // mominul
    public function created_by_user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function authorized_by_user(){
        return $this->belongsTo(User::class, 'authorized_by');
    }
    public function approved_by_user(){
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function declined_by_user(){
        return $this->belongsTo(User::class, 'declined_by');
    }
    public function toll_name(){
        return $this->belongsTo(TollFees::class, 'toll_name_id');
    }
    public function receipts(){
        return $this->hasMany(ReceiptSale::class,'sale_id');
    }
    public static function convertNumberToWords($number)
    {
        $units = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
        $words = [
            '0' => 'Zero', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four',
            '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen',
            '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty',
            '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety'
        ];

        if ($number < 0) return 'Negative ' . self::convertNumberToWords(abs($number));

        if ($number < 21) return $words[$number];

        if ($number < 100) return $words[10 * floor($number / 10)] . ($number % 10 ? ' ' . $words[$number % 10] : '');

        if ($number < 1000) return $words[floor($number / 100)] . ' Hundred' . ($number % 100 ? ' ' . self::convertNumberToWords($number % 100) : '');

        foreach ($units as $unitIndex => $unit) {
            $unitValue = pow(1000, $unitIndex);
            if ($number < $unitValue * 1000) {
                return self::convertNumberToWords(floor($number / $unitValue)) . ' ' . $unit . ($number % $unitValue ? ' ' . self::convertNumberToWords($number % $unitValue) : '');
            }
        }

        return '';
    }
}
