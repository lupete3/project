<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'company_logo_path',
        'tax_number',
        'bank_name',
        'bank_iban',
        'bank_swift',
        'invoice_footer_text',
    ];
}
