<template>
    <div>
        <div class="planes">
            <!-- Page Header Component -->
            <div class="page-header grid">
                <div class="title col-18 col-9-m">
                    <h1 class="page-heading">Mi perfil</h1>
                </div>
            </div>
        <section class="section next-classes" >
            <div class="card">
                <!--  Profile photo  -->
                <div class="ibox">
                    <ul v-if="password.errors">
                         <li v-for="error in password.errors" v-bind:key="error">{{ error }}</li>
                    </ul>

                    <div class="ibox-head d-flex">
                        <div class="ibox-title">Actualizar contraseña</div>
                    </div>

                    <div class="ibox-body" style="margin-top: 12px;">
                            <div class="form-group mb-2" >
                                <div class="form-group inline ">
                                    <label class="col-form-label">
                                        Contraseña actual
                                    </label>

                                    <input type="password"
                                            class="form-control"
                                            name="current_password"
                                            id="current_password"
                                            autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group mb-2" style="margin-top: 8px;">
                                <div class="form-group inline ">
                                    <label class="col-form-label">
                                        Nueva contraseña
                                    </label>

                                    <input type="password" class="form-control" name="password" id="password" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group mb-2" style="margin-top: 8px;">
                                <div class="form-group inline ">
                                    <label class="col-form-label">
                                        Confirmar contraseña
                                    </label>

                                    <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" required="" autocomplete="off">
                                </div>
                            </div>

                            <button class="btn btn-success mt-3" style="margin-top: 12px;"
                                     @click="updatePassword">
                                Actualizar contraseña
                            </button>
                    </div>
                </div>

                                <!-- <div>
                    <label for="">Foto de perfil</label>
                    <input type="file" @change="loadNewImage"/>

                    <img v-if="profile_photo_url" :src="profile_photo_url"
                    style="margin-left: 26px;
                        width: 64px;
                        height: 64px;
                        border-radius: 100%;
                        cursor: pointer;
                        background-color: #FFFFF;
                        background-position: center;
                        background-size: cover;" />

                    <button @click="updateProfilePhoto" :disabled="!photoIsLoaded">Subir foto</button>
                </div> -->

                <!-- User general data -->
                <!-- <div>
                    Zona horaria
                    <select v-model="timezoneSelected" id="" @change="updateSelect($event)">
                        <option v-for="timezone in timezones" v-bind:key="timezone.id" :value="timezone.name">
                            {{ timezone.human_name }}
                        </option>
                    </select>

                    <button @click="updateSettings">Guardar ajustes</button>
                </div> -->
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
            auth_user: {},         // auth user data
            timezoneSelected: '',
            profile_photo_url: null,
            photoIsLoaded: false,
            profilePhoto: null,
            password: {
                'errors': {},
            }
        }
    },
    mounted() {
        this.getAuthUserData();
    },
    methods: {
        getAuthUserData() {
            axios.get('/u/profile/show').then(response => {
                this.auth_user = response.data.auth_user;
            })
            .then(() => this.fillFields());
        },
        fillFields() {
            this.timezoneSelected = this.auth_user.timezone;

            this.profile_photo_url = this.auth_user.avatar
        },
        updateSelect(event) {
            this.timezoneSelected = event.target.value;
        },
        updateSettings() {
            if (this.requiredValuesAreFilled()) {
                axios.patch('/u/settings/' + this.auth_user.id, {
                    'timezone' : this.timezoneSelected,
                    'auth_user_id': this.auth_user.id
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
        updateProfilePhoto() {
            console.log('updateProfilePhoto');
            if (this.profile_photo_url) {
                console.log('hay foto: ' + this.profilePhoto);
                console.log('hay foto: ' + this.auth_user);
                console.log('hay foto: ' + this.auth_user.id);

                let formData = new FormData();
                formData.append('avatar', this.profilePhoto);
                formData.append('auth_user_id', this.auth_user.id);

                axios.post(
                    `/u/profile/update-photo`,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    if (response.data.success) {
                        alert(response.data.success);
                    }
                });
            }
        },
        loadNewImage(event) {
            console.log(event.target.files[0]);
            this.profilePhoto = event.target.files[0];
            this.profile_photo_url = URL.createObjectURL(this.profilePhoto);
            this.photoIsLoaded = true;
        },
        updatePassword() {
            let values = ['current_password', 'password', 'password_confirmation']
            let current_password = document.getElementById('current_password').value;
            let password = document.getElementById('password').value;
            let password_confirmation = document.getElementById('password_confirmation').value;


            if (!current_password || !password || !password_confirmation) {
                alert("Debe completar los tres campos de contraseña para poder actualizarla.");

                return;
            }

            axios.post('/u/profile/update-password', {
                current_password, password, password_confirmation
            })
            .then(response => {
                if (response.data.success) {
                    document.getElementById('current_password').value = '';
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';

                    alert(response.data.success);
                }
            })
            .catch(function (error) {
                let errors = error.response.data.errors;

                if (errors) {
                    for (var [key, value] of Object.entries(errors)) {
                        if (key === 'current_password') {
                            alert(value[0])
                        }
                        if (key === 'password') {
                            alert(value[0])
                        }
                    }
                }
            });
        }
    }
}
</script>
