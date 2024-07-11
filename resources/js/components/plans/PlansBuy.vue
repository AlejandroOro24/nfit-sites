<template>
    <div id="planes" class="planes">
            <!-- Page Header Component -->
        <div class="page-header grid">
            <div class="title col-18 col-9-m">
                <div class="breadcrumb">
                    <a href="/u/plans">
                        &lt; Planes
                    </a>
                </div>
                <h1 class="page-heading">Comprar un Plan</h1>
            </div>
            <div class="selectable col-18 col-9-m">
                <select class="select-period" @change="plansByPeriod($event)">
                    <option value="" selected="">Todos los planes</option>
                    <option :value="key" v-for="(period, key) in plan_periods"  :key="key">{{ period }}</option>
                </select>
            </div>
        </div>

        <section class="section planes-list grid">
            <div class="card card-plan col-18 col-9-m" v-for="plan in filteredPlans" :key="plan.id">
                <div class="img" :style="`background-image: url(${plan.image_path ? plan.image_path : '/img/plans/default.png'});`"></div>
                <div class="data">
                    <h2 class="title">{{ plan.plan }}</h2>
                    <p class="description">
                        {{ plan.description }}
                    </p>
                    <div class="plan-details">
                        <div class="period">
                            <!-- <p>Contratable <span>Mensual</span><span>trimestral</span><span>semestral</span><span>anual</span></p> -->
                            <p>Contratable <span>{{ plan_periods[plan.plan_period_id] }}</span></p>
                        </div>
                        <!-- <div class="include">
                            <p>Incluye <span>CrossFit</span></p>
                        </div> -->
                        <!-- <div class="availability">
                            <p><span>1</span> Clase al día. Válido entre las <span>09:00</span> a <span>12:00</span> hrs</p>
                        </div> -->
                        <div class="price">
                            <p><span>{{ valueToCurrency(plan.amount) }}</span></p>
                        </div>
                        <div class="buttons">
                            <button class="primary trigerModal-confirmPlan" @click="modalBuyPlan(plan)">Contratar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal: Confirmar Clase -->
        <div class="modal" v-if="isActiveModal">
            <div class="modal-content center-modal" v-on:click.self="isActiveModal = !isActiveModal">
                <div class="modal-plan-confirm">
                <!-- <div @click="isActiveModal = !isActiveModal">X</div> -->
                    <button class="close-modal" v-on:click="isActiveModal = !isActiveModal"></button>
                    <!-- <img src=""> -->
                    <h2 class="modal-heading">Contratar el plan <span>{{ plan_to_buy.plan }}</span></h2>
                    <div class="details">
                        <!-- <p class="classes">
                            Incluye <span>CrossFit</span><span>HIIT</span>
                        </p> -->
                        <!-- <p class="times">
                            <span>1 Clase al día</span>.
                            <span>
                                Válido entre las <span>09:00</span> y las <span>12:00hrs</span>
                            </span>
                        </p> -->
                        <p class="times">
                            <span>
                                Comienza el <span>{{ next_plan_dates.start }}</span>
                                <br>
                                Termina el <span>{{ next_plan_dates.end }}</span>
                            </span>
                        </p>
                        <div>
                            <span>{{ valueToCurrency(plan_to_buy.amount) }}</span> {{ plan_periods[plan_to_buy.plan_period_id] }}
                        </div>
                        <div class="buttons">
                            <button class="primary" :disabled="buttonisDisabled" @click="buyPlan($event, plan_to_buy)">Ir a Pagar</button>
                        </div>
                    </div>
                    <!-- <div class="buttons">
                    </div> -->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'PlansBuy',
    data() {
        return {
            plan_periods: {},
            contractable_plans: {},
            filteredPlans: {},
            isActiveModal: false, // confirm buy plan modal
            plan_to_buy: {}, // plan to be displayed on the modal to be bought
            next_plan_dates: {}, // dates of the possible next plan
            buttonisDisabled: false
        }
    },
    mounted() {
        this.getContractablePlans();
        this.getPlanPeriods();
    },
    methods: {
        /** Get all plan periods ('mensual', 'bimensual', 'trimestral') */
        getPlanPeriods() {
            axios.get('/u/plans/periods').then(response => {
                this.plan_periods = response.data.plan_periods;
            });
        },
        /** Get all plans who can be contractables */
        getContractablePlans() {
            axios.get('/u/plans/contractables').then(response => {
                this.contractable_plans = response.data.contractable_plans;
            }).then(() => {
                this.filteredPlans = this.contractable_plans;
            });
        },
        /**  Convert value to currency  */
        valueToCurrency(value) {
            if (value && value > 0) {
                return '$' + value.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            }
            return 'sin valor';
        },
        /**  Show modal with data plan information  */
        modalBuyPlan(plan) {
            // load data plan
            this.getDatesPlanToBuy(plan);
            this.plan_to_buy = plan;
            this.isActiveModal = !this.isActiveModal;
        },
        buyPlan(event, plan) {
            this.buttonisDisabled = !this.buttonisDisabled; /** Disable button */
            event.target.innerHTML = 'Cargando...'; /** Change button text */

            axios.post('/u/plans', {
                plan_id: plan.id,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }).then(response => {
                if (response.data.status  === 'Created') {
                    window.location.href = response.data.redirect_to;
                }
            }).catch(error => {
                if (error.response) {
                    alert(error.response.data.message);
                } else if (error.message) {
                    alert(error.message);
                } else {
                    alert('No hemos podido procesar la compra del plan, por favor intente más tarde.');
                }

                event.target.innerHTML = 'Ir a Pagar'; /** Set back text for the button */
                this.buttonisDisabled = !this.buttonisDisabled;  /** Enable button */
            });
        },
         /**  Get plan's start and finish dates  */
        getDatesPlanToBuy(plan) {
            axios.get('/u/plans/'+ plan.id +'/next').then(response => {
                this.next_plan_dates = response.data.next_plan_dates;
                console.log(this.next_plan_dates);
            });
        },
        /**  Filter plans by period (mensual, bimestral, trimestral)  */
        plansByPeriod(event) {
            let periodId = parseInt(event.target.value);
            this.filteredPlans = this.contractable_plans;
            //  if there is a valid option selected filter by that option
            if (periodId) {
                this.filteredPlans = this.filteredPlans.filter(plan => {
                    return plan.plan_period_id === periodId;
                });
            }
        }
    },
}
</script>
