<template>
    <div v-if="_hasReplies" style="margin-top: 2px">
        <a href="#" class="answers" @click="showReplies(false)">
            {{ !isOpen ? 'Mostrar' : 'Ocultar' }}
            <span>{{ my_replies_count }}</span> Respuestas
        </a>

        <div class="replies" v-if="isOpen">
            <div class="reply" v-for="reply in replies.data" :key="reply.id">
                <div class="reply-header">
                    <div class="img" v-bind:style="{ 'background-image': 'url(' + reply.avatar + ')', 'background-size': 'contain' }"></div>
                    <div class="data">
                        <h4 class="name">{{ reply.first_name }} {{ reply.last_name }}</h4>
                        <p class="time">{{ reply.created_date }}</p>
                    </div>
                </div>
                <div class="reply-body">
                    <p class="the-reply" v-html="reply.body"></p>
                    <!-- <a href="#" class="answers" @click="deleteReply($event, reply.id)">Eliminar</a> -->
                    <span @click="deleteReply($event, reply.id)" v-if="auth_user_id === reply.user_id">
                        <a href="#" class="answers">Eliminar</a>
                    </span>
                    <!-- <button @click="deleteReply($event, reply.id)">Eliminar</button> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { mapActions } from 'vuex'

    export default {
        name: 'Reply',
        props: ['parent_id', 'videoId', 'replies_count', 'auth_user_id'],
        data() {
            return {
                replies: { data: [], areLoaded: false },
                isOpen: false,
                my_replies_count : 0
            }
        },
        computed: {
            _hasReplies() {
                return true;
            }
        },
        updated() {
            this.my_replies_count = this.replies_count;
        },
        mounted() {
            this.my_replies_count = this.replies_count;
        },
        methods: {
            ...mapActions(['sendAlert']),
            showReplies(reload) {
                if (reload) {
                    this.fetchAndShow();
                    return;
                }
                if (!this.replies.areLoaded) {
                    this.fetchReplys();
                }
                this.isOpen = !this.isOpen; // toggle show replies
                // console.log('this.isOpen es igual a ' + this.isOpen);
            },
            fetchAndShow() {
                this.replies.data = null; // Deletes all replies in sessions data
                this.fetchReplys();
                this.isOpen = true;
            },
            fetchReplys() {
                axios.get(`/u/videos/${this.videoId}/comments/${this.parent_id}/replies`)
                    .then(response => {
                        if (response.data.replies.length > 0) {
                            this.replies.data = response.data.replies;
                        }
                        this.my_replies_count = response.data.replies.length;
                        this.replies.areLoaded = true;
                    });
            },
            deleteReply($event, replyId) {
                $event.target.disabled = true; // disable ELIMINAR button
                if (confirm('¿Eliminar el comentario definitivamente?')) {
                    axios.delete(`/u/videos/${this.videoId}/comments/${replyId}`)
                    .then(response => {
                        this.fetchAndShow();
                        this.sendAlert({
                            status: response.data.status,
                            message: response.data.message
                        });
                        // this.my_replies_count = this.replies.data.length;
                        // this.$parent.fetchComment(this.parent_id);
                        this.$emit('updateAComment', this.parent_id);
                    });
                } else {
                    $event.target.disabled = false; // enable ELIMINAR button
                }
            }
        },
    }
</script>

