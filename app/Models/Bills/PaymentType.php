<?php

namespace App\Models\Bills;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
      /**
     *  Payment types ids
     *
     *  @var  int
     */
    public const EFECTIVO = 1;
    public const TRANSFERENCIA = 2;
    public const CHEQUE = 3;
    public const DEBITO = 4;
    public const CREDITO = 5;
    public const FLOW = 6;
    public const TRANSBANK = 7;
    public const MERCADO_PAGO = 8;


        /**
     *  Return list of PaymentTypes
     *
     *  @return  array
     */
    public static function listPaymentType()
    {
        return [
            self::EFECTIVO      => 'EFECTIVO',
            self::TRANSFERENCIA => 'TRANSFERENCIA',
            self::CHEQUE        => 'CHEQUE',
            self::DEBITO        => 'DEBITO',
            self::CREDITO       => 'CREDITO',
            self::FLOW          => 'FLOW',
            self::TRANSBANK     => 'TRANSBANK',
            self::MERCADO_PAGO  => 'MERCADOPAGO',
        ];
    }
}
