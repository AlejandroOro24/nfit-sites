<template>
    <div>
        <div class="planes">
            <!-- Page Header Component -->
            <div class="page-header grid">
                <div class="title col-18 col-9-m">
                    <h1 class="page-heading">Planes</h1>
                </div>
                <div class="buttons col-18 col-9-m" v-if="has_flow">
                    <a href="/u/plans/buy" class="btn primary">Comprar un Plan</a>
                </div>
            </div>

            <section class="section tu-plan grid" v-if="actual_plan">
                <div class="section-header">
                    <h3 class="section-heading">
                        Tu Plan
                    </h3>
                </div>
                <div class="card-tu-plan">
                    <div class="img" :style="`background-image: url(${actual_plan.image ? actual_plan.image : '/img/plans/default.png'});`"></div>
                    <div class="data">
                        <div class="header">
                            <h2 class="plan-name">{{ actual_plan.plan }}</h2>
                            <p class="period">{{ capitalizeFirstLetter(plan_periods[actual_plan.plan_period_id]) }}</p>
                        </div>
                        <div class="body">
                            <div class="data-item">
                                <p>Contratado el</p>
                                <span>{{ actual_plan.human_start_date }}</span>
                            </div>
                            <div class="data-item">
                                <p>Vence el</p>
                                <span>{{ actual_plan.human_finish_date }}</span>
                            </div>
                            <div class="data-item">
                                <p>Estado</p>
                                <span class="tag confirmed">{{ capitalizeFirstLetter(plan_statuses[actual_plan.plan_status_id]) }}</span>
                            </div>
                            <div class="data-item">
                                <p>Valor</p>
                                <span class="price">{{ actual_plan.amount ? valueToCurrency(actual_plan.amount) : 'sin pago asociado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section pagos grid">
                <div class="section-header">
                    <h3 class="section-heading">Historial de Pagos</h3>
                </div>
                <div class="card">
                    <div class="responsive-table">
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Contratado</th>
                                    <th scope="col">Vencimiento</th>
                                    <th scope="col">Período</th>
                                    <th scope="col">Método de Pago</th>
                                    <th scope="col">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="plan in plans_history" :key="plan.billId">
                                    <th scope="col">{{ plan.plan }}</th>
                                    <th scope="col">{{ plan.human_start_date }}</th>
                                    <th scope="col">{{ plan.human_finish_date }}</th>
                                    <th scope="col">{{ capitalizeFirstLetter(plan_periods[plan.plan_period_id]) }}</th>
                                    <th scope="col">{{ plan.payment_type_id ? payment_types[plan.payment_type_id] : 'sin pago asociado' }}</th>
                                    <th scope="col">{{ plan.amount ? valueToCurrency(plan.amount) : 'no aplica' }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="full table-load" v-if="nextPage" @click="fetch(nextPage)">Cargar más</button>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'PlansIndex',
    props: ['payment_types', 'has_flow'],
    data() {
        return {
            actual_plan: {},
            plan_statuses: {},
            plan_periods: {},
            plans_history: {},
            nextPage: '',
        }
    },
    mounted() {
// console.log('this.has_flow');

        // console.log(this.has_flow);
        this.getPlanStatuses();
        this.getPlanPeriods();
        // Get historic authenticated user plans
        this.plansHistory();
        this.getActualPlan();
    },
    methods: {
        /** Put just the first letter in Mayus, the rest all in minus */
        capitalizeFirstLetter(value) {
            if (value) {
                value = value.toLowerCase();
                return value.charAt(0).toUpperCase() + value.slice(1);

            }
        },
        /** Get the actual plan of the authenticated user */
        getActualPlan() {
            axios.get('/u/plans/active').then(response => {
                // console.log(response.data.actual_plan);
                this.actual_plan = response.data.actual_plan;
            });
        },
        /** Get all plan statuses ('activo', 'precompra', 'cancelado') */
        getPlanStatuses() {
            axios.get('/u/plans/statuses').then(response => {
                this.plan_statuses = response.data.plan_statuses;
            });
        },
        /** Get all plan periods ('mensual', 'bimensual', 'trimestral') */
        getPlanPeriods() {
            axios.get('/u/plans/periods').then(response => {
                this.plan_periods = response.data.plan_periods;
            });
        },
        /** Get all plan periods ('mensual', 'bimensual', 'trimestral') */
        plansHistory() {
            axios.get('/u/plans/historial').then(response => {
                // console.log(response.data.data);
                // console.log(response.data.next_page_url);
                this.nextPage = response.data.next_page_url;
                this.plans_history = response.data.data;

            });
        },
        fetch(nextPage) {
            axios.get(nextPage).then(response => {
                this.nextPage = response.data.next_page_url;
                response.data.data.forEach(element => this.plans_history.push(element));
            });
        },
        /**  Convert string value to curency  */
        valueToCurrency(value) {
            if (value && value > 0) {
                return '$' + value.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
            }
            return '';
        }
    },
}
</script>
