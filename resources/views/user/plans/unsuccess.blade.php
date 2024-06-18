@extends('user.layouts.app')

@section('content')
    <div class="col-18 col-18-m col-7-xl">
        <div class="section">
            <div class="card-no-data">
                <div class="row text-center mx-5 py-3 flex-column">
                    <img style="width: 40px; margin: auto;"
                            src="{{ asset('/icons/cross.png') }}"
                            class="text-center mb-3">

                    <h5 class="mb-3 font-bold text-center mx-5">Ha ocurrido un problema con la transacción</h5>

                    <p style="margin-top: 4px">
                        Por favor vuelve a intentar más tarde o prueba utilizando otro medio de pago. Lamentamos los inconvenientes.
                    </p>

                    <div style="margin-top: 8px">
                        <a href="/u/plans" class="button" >Ir a planes</a>

                        <a href="/" class="button">Ir al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
