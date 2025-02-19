<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

  public function invoiceDetail()
  {
      return $this->hasMany(InvoiceDetail::class, 'invoice_id');
  }

}
