@extends('user.layouts.app')

@section('content')
<div id="clases" class="clases">
    <!-- Page Header Component -->
    <div class="page-header grid">
        <div class="title col-18 col-6-m">
            <h1 class="page-heading">Clases</h1>
        </div>
        <div class="buttons col-18 col-12-m">
            <button class="primary" id="trigerModal-newReservation">Reservar Clase</button>
        </div>
    </div>
    
    <section class="section next-classes">
        <div class="section-header">
            <h3 class="section-heading">Próximas Clases</h3>
        </div>
        <div class="card">
            <clases-table filter="next" ></clases-table>
            {{-- <clases-test filter="next" ></clases-test> --}}
        </div>
    </section>

    <section class="section prev-classes">
        <div class="section-header">
            <h3 class="section-heading">Clases Anteriores</h3>
        </div>
        <div class="card">
            <clases-table filter="past"></clases-table>
        </div>
    </section>
</div>



@endsection

@section('modal')
 <!-- Modal: Confirmar Clase -->


<!-- Modal: Ceder Cupo -->
{{-- <div class="modal" id="centerModal-leave">
    <div class="modal-content center-modal">
        <div class="modal-alert">
            <img src="">
            <h2 class="modal-heading">Ceder cupo</h2>
            <p class="text-alert">
                Con esto confirmas que no asistirás a esta clase y podrás reservar otra en otro horario durante este día.
            </p>
            <div class="buttons">
                <button class="caution">Ceder</button>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('script')
<script>
    function confirmModalOpen(test) {
        console.log('open');
        console.log(test);
    }
    function confirmModalOpen(test) {
        console.log('close');
        console.log(test);
    }
    window.onload = function() {
        

        // const triggerModalConfirm = document.querySelector('.trigerModal-confirm');
        // const modalConfirm = document.querySelector('#centerModal-confirm');
        // const modalLeave = document.querySelector('#centerModal-leave');
        // const triggerCloseConfirm = document.querySelector('#centerModal-confirm .center-modal .modal-heading');
        // // const triggerCloseLeave = document.querySelector('#centerModal-leave .center-modal .modal-heading');

        // // Toggle Modal Open: Confirm Alert
        // if(triggerModalConfirm) {
        //     triggerModalConfirm.onclick = () => {
        //         modalConfirm.classList.add('open');
        //         modalConfirm.classList.remove('close');
        //         html.classList.add('o-hidden');
        //     }
        // }

        // // Toggle Modal Close: Confirm Alert
        // if(triggerCloseConfirm) {
        //     triggerCloseConfirm.onclick = () => {
        //         modalConfirm.classList.add('close');
        //         html.classList.remove('o-hidden');
        //         setTimeout(function(){
        //             modalConfirm.classList.remove('open');
        //             modalConfirm.classList.remove('close');
        //         // modalConfirm.classList.add('d-none');
        //         }, 600
        //         );
        //     }
        // }
    }
</script>
@endsection