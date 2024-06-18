<template>
    <div>
        <div class="planes">
            <!-- Page Header Component -->
            <div class="page-header grid">
                <div class="title col-18 col-9-m">
                    <h1 class="page-heading">Ajustes</h1>
                </div>
                <!-- <div class="buttons col-18 col-9-m" v-if="has_flow">
                    <a href="/u/plans/buy" class="btn primary">Comprar un Plan</a>
                </div> -->
            </div>
        <section class="section next-classes" >
            <!-- <div class="section-header">
                <h3 class="section-heading">Próximas Clases</h3>
            </div> -->
            <div class="card">
                <div>
                    Zona horaria
                    <select v-model="timezoneSelected" id="" @change="updateSelect($event)">
                        <option v-for="timezone in timezones" v-bind:key="timezone.id" :value="timezone.name">
                            {{ timezone.human_name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="">Foto de perfil</label>
                    <input type="file" @change="loadNewImage"/>

                    <img v-if="url" :src="url" />
                </div>

                <button @click="updateSettings">Guardar ajustes</button>
                <!-- <button class="full table-load"
                        v-if="getNextClasesPagination.nextPage"
                        @click="loadNext(getNextClasesPagination.nextPage)"
                >Cargar más</button> -->
            </div>
        </section>
        </div>
    </div>
    <!-- <div>
        Estos son los settings

        <select v-model="timezoneSelected" id="" @change="updateSelect($event)">
            <option v-for="timezone in timezones" v-bind:key="timezone.id" :value="timezone.name">
                {{ timezone.human_name }}
            </option>
        </select>

        <button @click="updateSettings">Guardar ajustes</button>
    </div> -->
</template>

<script>
import axios from 'axios';

export default {
    name: 'SettingIndex',
    props: ['timezones'],
    data() {
        return {
            auth_user: {},
            timezoneSelected: '',
            url: null
        }
    },
    mounted() {
        this.getAuthUserData();
    },
    methods: {
        getAuthUserData() {
            axios.get('/u/profile').then(response => {
                this.auth_user = response.data.auth_user;
            }).then(() => this.fillFields());
        },
        fillFields() {
            this.timezoneSelected = this.auth_user.timezone;
            this.url = this.auth_user.avatar
        },
        updateSelect(event) {
            console.log(event.target.value);
            this.timezoneSelected = event.target.value;
        },
        updateSettings() {
            if (this.requiredValuesAreFilled()) {
                axios.patch('/u/settings/' + this.auth_user.id, {
                    'timezone' : this.timezoneSelected,
                    'avatar': this.url
                }).then(response => {
                    if (response.data.success) {
                        alert(response.data.success);
                    }
                });
                return;
            }
        },
        requiredValuesAreFilled() {
            return !!this.timezoneSelected;
        },
        loadNewImage(event) {
            const image = event.target.files[0];

            this.url = URL.createObjectURL(image);
        }
    }
}
</script>

