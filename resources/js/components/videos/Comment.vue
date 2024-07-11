<template>
    <!-- Page Tags -->
    <div class="tab-content box-comentarios" id="box-comentarios">
        <div class="tab-content-body">
            <div class="comments" v-if="comments.length > 0">
                <div class="comment" v-for="comment in comments" :key="comment.id" >
                    <div class="comment-header">
                        <div class="img" v-bind:style="{ 'background-image': 'url(' + comment.avatar + ')', 'background-size': 'contain' }"></div>
                        <div class="data">
                            <h4 class="name">{{ comment.first_name }} {{ comment.last_name }}</h4>
                            <p class="time">{{ comment.created_date }}</p>
                        </div>
                    </div>
                    <div class="comment-body">
                        <p class="the-comment" v-html="comment.body"></p>
                    </div>
                     <div class="comment-footer">
                        <!-- Button for response comment -->
                        <a href="#" class="do-reply" @click="openReply(comment.id)">Responder</a>
                        <!-- Button for delete comment -->
                        <span @click="deleteComment($event, comment.id)" v-if="auth_user_id === comment.user_id">
                            <a href="#" class="answers">Eliminar</a>
                        </span>
                        <!-- Reply comment box -->
                        <div class="reply-comment" :ref="`box-reply-${comment.id}`" hidden>
                            <div class="reply-message">
                                <div :ref="`replyText-${comment.id}`" contenteditable="true" class="message-box"></div>
                                <button :ref="`replyButton-${comment.id}`" @click="sendReply($event, comment.id)"><span class="icon-icon-send"></span></button>
                            </div>
                            <button @click="closeReply(comment.id)">Cancelar</button>
                        </div>
                        <!-- All the replies of the comment -->
                        <reply v-if="comment.replies_count > 0"
                                @updateAComment="fetchComment"
                                :ref="`reply-component-${comment.id}`"
                                :parent_id="comment.id"
                                :videoId="videoId"
                                :replies_count="comment.replies_count"
                                :auth_user_id="auth_user_id">
                        </reply>
                    </div>
                </div>
            </div>
            <div class="comments" v-else>
                <p>Aun sin comentarios</p>
            </div>
        </div>
        <div class="tab-content-footer">
            <div class="message-box">
                <div contenteditable="true" class="textBox" ref="commentBox"></div>
                <button ref="buttonSendComment">
                    <span class="icon-icon-send" @click="sendComment" @enter="sendComment"></span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { mapGetters, mapActions } from 'vuex'
    // import Reply from '../videos/Reply'
    import ReplyVue from './Reply.vue'


    export default {
        props: [ 'videoId', 'auth_user_id' ],
        components: { ReplyVue },
        data() {
            return {
                comments: [],
                commentInput: '',
            }
        },
        mounted() {
            this.fetchComments();
        },
        methods: {
            ...mapActions(['sendAlert']),

            fetchComments() { // get comments
                axios.get('/u/videos/'+this.videoId+'/comments')
                    .then(response => {
                        this.comments = response.data.comments;
                    });
            },
            /**
             *  Get an specific comment, and update his replies number
             *
             *  @param  integer  The id of this comment
             */
            fetchComment(commentId) {
                // console.log(commentId);
                axios.get(`/u/comments/${commentId}`)
                    .then(response => {
                        // loop over all comments
                        this.comments.forEach(comment => {
                            // Update the comment replies count by the replies count of the bringed comment
                            if (comment.id === response.data.comment.id) {
                                comment.replies_count = response.data.comment.replies_count;
                            }
                        })
                    }).then(() => console.log(this.comments));
            },
            /**
             *
             */
            sendComment() { // send commnets
                let boxComment = this.$refs.commentBox.innerHTML;
                let sendButton = this.$refs.buttonSendComment;

                // if there is wrote more than 2 words and the send comment button is enabled, the user cand send a comment or reply
                if (boxComment.length > 2 && !sendButton.disabled) {
                    sendButton.disabled = true; // disable send comment button
                    axios.post('/u/videos/'+this.videoId+'/comments', { body: boxComment })
                        .then(response => {
                            this.fetchComments();
                            this.sendAlert({
                                message: 'Comentario enviado',
                                class: 'success'
                            })
                        }
                    ).then(() => {
                        this.$refs.commentBox.innerHTML = null;
                        sendButton.disabled = false; // enable send button for other commments
                    });
                }
            },
            /**
             *  Get the comment, check if his length is more than 2 words,
             *  post it, and reload comments
             *
             *  @param event
             *  @param parentCommentId  id of the comment
             */
            sendReply(event, parentCommentId) {
                /**  Get the child reply component */
                let replyText = this.$refs[`replyText-${parentCommentId}`][0].innerHTML; // reply Text
                let sendReplyButton = this.$refs[`replyButton-${parentCommentId}`][0];
                let replyComponent = this.$refs[`reply-component-${parentCommentId}`];

                /**  if there written more than 2 words the user cand send a comment or reply */
                if (replyText.length > 2 && !sendReplyButton.disabled) {
                    axios.post(`/u/videos/${this.videoId}/comments/${parentCommentId}/replies`, {
                        body: replyText
                    }).then(response => {
                        this.fetchComments()
                        this.sendAlert({ message: 'Comentario subido', class: 'success' })
                        this.closeReply(parentCommentId)
                    }).then(() => {
                        /**  to the reply component make a fetch of the replys  */
                        return replyComponent ? replyComponent[0].fetchReplys() : true;
                    }).then(() => replyComponent ? replyComponent[0].showReplies(true) : true);
                }
            },
            /**
             *  Display a confirm to ensure the user don't miss click
             *
             *  @param event
             *  @param parentCommentId  id of the comment
             */
            deleteComment(event, commentId) {
                event.target.disabled = true; // disable ELIMINAR button
                /**  Display a confirm to ensure the user don't miss click */
                if (confirm('¿Eliminar el comentario definitivamente?')) {
                    axios.delete(`/u/videos/${this.videoId}/comments/${commentId}`)
                    .then(response => {
                        this.comments = this.comments.filter(el => {
                            return el.id !== commentId
                        });
                        this.sendAlert({
                            class: response.data.status,
                            message: response.data.message
                        });
                    });
                } else {
                    event.target.disabled = false; // enable ELIMINAR button
                }
            },
            /**  Open div reply comment by his ref number  */
            openReply(commentId) {
                // console.log(commentId)

                this.$refs[`box-reply-${commentId}`][0].hidden = false;
            },
            /**  Close div reply comment  */
            closeReply(commentId) {
                let replyBox = this.$refs[`box-reply-${commentId}`][0];
                replyBox.hidden = true; // hide reply box
                this.$refs[`replyText-${commentId}`][0].innerHTML = null;
            }
        }
    }
</script>

