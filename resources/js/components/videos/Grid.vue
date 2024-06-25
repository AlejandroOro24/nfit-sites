<template>
    <!-- Page Tags -->
<div>
    <div class="page-tags grid">
        <HorizontalList :items="allClasesTypes" v-on:nombre="filterByClaseType"/>
        <div class="col-18 col-4-xl search">
            <input type="text"
                    placeholder="Buscar Videos"
                    @keyup="filter"
                    v-model="wordFilter"
            />
        </div>
    </div>
    <div class="video-grid" v-if="showedVideos.length > 0">
        <a v-for="video in showedVideos" :key="video.id" class="video-item" :href="'/u/videos/'+ video.id"   >
            <div class="img" v-bind:style="{ 'background-image': 'url(' + video.thumbnail_path + ')' }">
                <div class="tag">Clase</div>
            </div>
            <div class="data">
                <h3 class="title">{{ video.title }}</h3>
                <div class="date">
                    <p class="the-date">
                        <span class="icon-calendar-simple"></span>
                        <span>{{ video.human_release_at }}</span>
                    </p>
                    <p class="time">
                        <span class="icon-time"></span>
                        <span>{{ video.duration }}</span>
                    </p>
                </div>
            </div>
        </a>
    </div>
    <div class="text-center" v-if="filteredVideos.length > 0 && _thereMoreVideos">
        <button class="btn btn-primary" v-on:click="showMore" >
            Cargar mas
        </button>
    </div>
    <div v-if="showedVideos.length <= 0">
        No hay videos para mostrar
    </div>
</div>
</template>

<script>
    import axios from 'axios'
    import HorizontalList from './HorizontalList.vue';

    export default {
        components: { HorizontalList },
        data() {
            return {
                allVideos: [],
                allClasesTypes: [],
                filteredVideos: [],
                showedVideos: [],
                claseTypeId: 0,
                page: 1,
                quantity: 6,
                wordFilter: '',
            }
        },
        mounted() {
            /**  Get videos  */
            axios.get('/u/videos/get').then(
                response => {
                    // this.allVideos = response.data.data;
                    this.allVideos = response.data;
                    this.filteredVideos = this.allVideos;
                    this.showedVideos = this.filteredVideos.slice(0,this.page*this.quantity+1);
            });

            /**  Get all clases types */
            axios.get('/admin/clases-types-all').then(
                response => {
                    response.data.data.forEach(item => {
                        this.allClasesTypes.push({
                            id: item.id,
                            clase_type: item.clase_type,
                            clicked: false,
                        });
                    })
            });
        },
        computed: {
            _thereMoreVideos() {
                return this.showedVideos.length !== this.filteredVideos.length;
            }
        },
        methods:{
            filter() {
                this.page = 1; /** reset to page one */
                this.filteredVideos = this.allVideos;
                /** if user write more than 2 words start to filter videos */
                if(this.wordFilter.length >= 2) {
                    this.filterByWord();
                    this.showedVideos = this.filteredVideos.slice(0, this.page*this.quantity+1);
                }
                /** if user delete text written and left it void, filter just by clase type */
                if (this.wordFilter.length === 0) {
                    this.filterVideoByClaseType(this.claseTypeId);
                    this.showedVideos = this.filteredVideos.slice(0, this.page*this.quantity+1);
                }
            },
            showMore() {
                this.page++;

                this.showedVideos = this.filteredVideos.slice(0, this.page * this.quantity + 1);

            },
            filterByClaseType(claseTypeId) {
                this.page = 1; /** reset to page one */
                this.filteredVideos = this.allVideos;
                this.claseTypeId = claseTypeId;  /**  Get selected "type clase id" and set it to this */

                /**  If there are a VALID clase type selected and somes words written start to filter by it text  */
                if(this.wordFilter.length >= 2) {
                    this.filterByWord();
                } else {
                    // Else show videos by clase type clicked on pill
                    this.filterVideoByClaseType(this.claseTypeId);
                }
                /**  After all rearrange videos in the grid */
                this.showedVideos = this.filteredVideos.slice(0,this.page*this.quantity+1);
            },
            filterVideoByClaseType(claseType = null) {
                this.filteredVideos = this.allVideos;
                if (claseType !== 0) {
                    this.filteredVideos = this.filteredVideos.filter(video => {
                        return video.clase_type_id === claseType;
                    });
                }
            },
            filterByWord() {
                this.filteredVideos = this.filteredVideos.filter(item => {
                    if (this.claseTypeId !== 0) {
                        return item.title.toLowerCase().includes(this.wordFilter.toLowerCase()) && item.clase_type_id === this.claseTypeId;
                    }
                    return item.title.toLowerCase().includes(this.wordFilter.toLowerCase());
                });
            }
        }
    }
</script>
