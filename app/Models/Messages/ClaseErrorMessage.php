<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseErrorMessage 
{
 
    /**
     *  @var  string
     */
    public const DISABLED = 'Esta clase todavía no puede ser tomada, pero pronto se podrá.';

    /**
     *  @var  string
     */
    public const HAS_ENDED = 'La clase ya no puede ser tomada por que la fecha y hora de inicio ya pasaron.';

    /**
     *  @var  string
     */
    public const IS_FULL = 'La clase esta llena.';
}
