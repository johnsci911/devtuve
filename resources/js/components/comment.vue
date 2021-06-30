<template>
	<div class="media bg-light p-2 my-2 rounded-lg">
		<avatar :username="comment.user.name" class="mr-3" :size="30"></avatar>
		<div class="media-body">
			<h6 class="mt-0">{{ comment.user.name }}</h6>
			<small>{{ comment.body }}</small>
            <div class="d-flex mb-4">
                <votes :default_votes="comment.votes" :entity_id="comment.id" :entity_owner="comment.user.id"></votes>
                <button @click="addingReply = !addingReply" class="btn btn-sm btn-default ml-2"  :class="{ 'btn-default': !addingReply, 'btn-danger': addingReply }">{{ addingReply ? 'Cancel' : 'Add reply' }}</button>
            </div>
            <div v-if="addingReply" class="form-inline my-4 mb-2 w-full">
                <input v-model="body" type="text" class="form-control form-control-sm w-80">
                <button @click="addReply" class="btn btn-sm btn-primary ml-2">Submit</button>
            </div>
            <replies ref="replies" :comment="comment"></replies>
		</div>
	</div>
</template>

<script>
	import Avatar from 'vue-avatar'
	import Replies from './replies.vue'

	export default {
		components: {
			Avatar,
			Replies
		},
		data() {
			return {
				addingReply: false,
                body: ''
			}
		},
		props: {
			comment: {
				required: true,
				default: () => ({})
			},
            video: {
                required: true,
                defualt: () => ({})
            }
		},
        methods: {
            addReply() {
                if (! this.body) return

                axios.post(`/comments/${this.video.id}`, {
                    body: this.body,
                    comment_id: this.comment.id,
                }).then(({ data }) => {
                    this.body = ''
                    this.addingReply = false
                    this.$refs.replies.addReply(data)
                })
            }
        }
	}
</script>
