<template>
    <div>
        <div v-for="stage in stages" :key="stage.id">
            <h3 style="font-weight: 900;">{{ stage.stage_name }}</h3> <br>

            <pre>{{ stage.description }}</pre> <br>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['wodId'],
        data() {
            return {
                stages: [],
            }
        },
        mounted() {
            this.fetchStages();
        },
        methods:{
            fetchStages() {
                axios.get(`/u/wods/${this.wodId}/stages`).then(
                    response => this.manageSuccessStagesResponse(response)
                );
            },
            manageSuccessStagesResponse(response) {
                if (this.thereAreWodsInThis(response)) {
                    this.fillTheStages(response.data.stages);
                }
            },
            thereAreWodsInThis(response) {
                return !! response.data.stages.length >= 1; // that means array wods has a index of 0
            },
            fillTheStages(stages) {
                this.stages = stages;
            },
        }
}
</script>
