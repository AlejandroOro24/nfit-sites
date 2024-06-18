<template>
            <section class="section next-classes">
                <div class="section-header">
                    <h3 class="section-heading">Inscritos en esta Clase</h3>
                </div>
                <div class="card" v-if="clase.assistants">
                    <div class="table-responsive" >
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="user of clase.assistants" :key="user.id">
                                    <td class="table-person">
                                        <div class="img" v-bind:style="{ 'background-image': 'url(' + user.avatar + ')' }"></div>
                                        <div class="name">{{user.full_name}}</div>
                                    </td>
                                    <td class="tag" :class="user.status.class">{{user.status.name}}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="card" v-else>
                    <p>Cargando....</p>
                </div>
            </section>
</template>

<script>
    import axios from 'axios'
    import { mapGetters, mapActions } from 'vuex' 
    export default {
        props: {
            claseId: String,
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters(['clase'])
        },
        methods:{

        } 

    }
</script>


