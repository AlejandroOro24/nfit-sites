import Vue from 'vue/dist/vue.esm.js';
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        clases: [],
        clase: [],
        alert: null,
        paginated_past_clases: [], // json of all the next clases of the authenticated user
        paginated_next_clases: [], // json of all the next clases of the authenticated user
        past_clases_paginator: {}, // object with data for the pagination of paginated_past_clases
        next_clases_paginator: {}, // object with data for the pagination of paginated_next_clases
        // paginated_clases_load_status: 0, // status of the GET paginated_clases http request
    },
    getters: {
        // Clases
        nextClases: state => {
            const filtered = state.clases.filter(item => item.status.id <=2);
            const sorted = filtered.sort((a, b) => new Date(a.date_time) - new Date(b.date_time))
            return sorted;
        },
        pastClases: state => {
            return state.clases.filter(item => item.status.id >=3);
        },
        /**
         *  Get all clases from status.paginated_past_clases
         *
         *  @return  object
         */
        getPastClases(state) {
            if (state.paginated_past_clases.length > 0) {
                return JSON.parse(JSON.stringify(state.paginated_past_clases));
            }
        },
        /**
         *  To check if there are next clases in the paginator to be called,
         *  and also get the paginator for the next clases (pendientes, confirmadas)
         *
         *  @return  object
         */
        getNextClases(state) {
            if (state.paginated_next_clases.length > 0) {
                return JSON.parse(JSON.stringify(state.paginated_next_clases));
            }
        },
        /**
         *  To check if there are past clases in the paginator to be called,
         *  and also get the paginator for the past clases (perdidas, consumidas)
         *
         *  @return  object  (from, to, per_page, first_page_url, prev_page_url, path)
         */
        getPastClasesPagination(state) {
            return state.past_clases_paginator;
        },
        /**
         *  Get all the data of the pagination
         *
         *  @return  object  (from, to, per_page, first_page_url, prev_page_url, path)
         */
        getNextClasesPagination(state) {
            return state.next_clases_paginator;
        },
        clase: state => {
            return state.clase
        },
        // General
        alert: state => {
            return state.alert
        }
    },
    mutations: {
        // clases
        setClases (state, clases) {
            state.clases = clases
        },
        // Pass all classes obtained by axios to state.paginated_clases
        paginatedNextClases (state, data) {
            if (data.reset) {
                state.paginated_next_clases = data.clases.data;
                return;
            }
            // console.log('if reset this shouldn`t be displayed');
            if (data.clases.data.length > 0) {
                data.clases.data.forEach(clase => {
                    state.paginated_next_clases.push(clase);
                });
            }
        },
        // Pass all classes obtained by axios to state.paginated_clases
        /**
         *  Pass the past clases to the past_clases object
         *
         *  @param  {*}        state
         *  @param  {*}        clases  // clases form request
         *  @param  {boolean}  reset   // if true reset the paginated_past_clases to 0
         */
        paginatedPastClases (state, data) {
            if (data.clases.data.length > 0) {
                data.clases.data.forEach(clase => {
                    state.paginated_past_clases.push(clase);
                });
            }
        },
        setPastPagination (state, page) {
            if (page) {
                state.past_clases_paginator = page
            }
        },
        setNextPagination (state, page) {
            if (page) {
                state.next_clases_paginator = page
            }
        },
        setClase (state, clase) {
            state.clase = clase
        },
        // General
        setAlert (state, alert) {
            state.alert = alert
            setTimeout(() => {
                state.alert = null
            }, 5000);
        },
        removeAlert (state) {
            state.alert = null
        },
        /**
        *   Get more clases for be appended to next_clases_paginator
        *
        *   @param {object}  state
        */
        loadNextClases(state) {
            // console.log('laodPastClases');
            // console.log('state');
            // console.log(state);
            // if nextPage is null there are no more items to call
            if (state.next_clases_paginator.nextPage) {
                this.dispatch('fetch', {
                    url: state.next_clases_paginator.nextPage,
                    options: {
                        method: 'paginatedNextClases',
                        methodPaginator: 'setNextPagination',
                        status_reservation: [1, 2], // all clases reservations with status "pendiente" "confirmada"
                    }
                });
            }
        },
        /**
         *   Get more clases for be appended to past_clases_paginator
         *
         *   @param {object}  state
         */
        loadPastClases(state) {
            // if nextPage is null there are no more items to call
            if (state.past_clases_paginator.nextPage) {
                this.dispatch('fetch', {
                    url: state.past_clases_paginator.nextPage,
                    options: {
                        method: 'paginatedPastClases',
                        methodPaginator: 'setPastPagination',
                        status_reservation: [3, 4],  // all clases reservations with status "consumida" "perdida"
                    }
                });
            }
        },
    },
    actions: {
        // Clases
        fetchClases: async function({commit}) {
            const response = await axios.get('/u/clases/get')
            commit('setClases', response.data.clases)
        },
        fetchNextClases() {
            // console.log('into fetchNextClases');
            this.dispatch('fetch', {
                url: '/u/clases/fetch',
                options: {
                    reset: false, // if it's true reset the clases to the first page
                    method: 'paginatedNextClases',
                    methodPaginator: 'setNextPagination',
                    status_reservation: [1, 2], // all clases reservations with status "pendiente" "confirmada"
                }
            });
        },
        fetchPastClases() {
            this.dispatch('fetch', {
                url: '/clases/fetch',
                options: {
                    reset: false,  // If it's true reset the clases to the first page
                    method: 'paginatedPastClases',
                    methodPaginator: 'setPastPagination',
                    status_reservation: [3, 4],  // all clases reservations with status "consumida" "perdida"
                }
            });
        },
        resetNextClases() {
            console.log('into resetNextClases');
            this.dispatch('fetch', {
                url: '/clases/fetch',
                options: {
                    reset: true,  //  If it's true, set the clases to first page
                    method: 'paginatedNextClases',
                    methodPaginator: 'setNextPagination',
                    status_reservation: [1, 2], // all clases reservations with status "pendiente" "confirmada"
                }
            });
        },
        fetchClase: async function({commit}, claseId) {
            const response = await axios.get('/u/clases/'+claseId+'/json')
            commit('setClase',response.data.clase)
        },
        // General
        sendAlert({commit}, alert) {
            commit('setAlert', alert)
        },
        removeAlert({commit}) {
            commit('removeAlert')
        },
        /**
         *  Get all the reservations clases of the authenticated user,
         *  filter by reservations status, the put in it corresponding method
         *
         *  @param {*} global
         *  @param {*} data
         */
        fetch(global, data) {
            let method = data.options.method;
            let methodPaginator = data.options.methodPaginator;
            // console.log(data.options);
            /**
             *  Get all the reservations statuses ids and convert to string to be append to the url
             *  If the url contains a specific page (search('page')) then merge ("&") with the status_reservation,
             *  else add ("?") to the status_reservation
             */
            let status_reservations = data.url.search('page') === -1 ?
                                        `?reservation_status_id=${data.options.status_reservation.join()}`:
                                        `&reservation_status_id=${data.options.status_reservation.join()}`;

            axios.get(`${data.url}${status_reservations}`)
                .then(response => {
                    this.commit(method, {
                        clases: response.data,
                        reset: data.options.reset
                    });
                    this.commit(methodPaginator, {
                        nextPage: response.data.next_page_url,
                    });
                })
                .catch(e => {
                    console.log(e);
                })
        }
    }
})
