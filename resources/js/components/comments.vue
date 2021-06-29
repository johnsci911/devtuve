<template>
    <div>
        <div class="media" v-for="comment in comments.data" :key="comment.user.id">
            <avatar :username="comment.user.name" class="mr-3" :size="30"></avatar>
            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
                <div class="mb-4">
                    <div class="form-inline my-4 w-full">
                        <input type="text" class="form-control form-control-sm w-80">
                        <button class="btn btn-sm btn-primary ml-2">
                            <small>Add reply</small>
                        </button>
                    </div>
					<votes :default_votes="comment.votes" :entity_id="comment.id" :entity_owner="comment.user.id"></votes>
                    <replies :comment="comment"></replies>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-success" @click="fetchComments" v-if="comments.next_page_url">
                Load More
            </button>
            <span v-else>No more comments to show</span>
        </div>
    </div>
</template>

<script>
    import Avatar from 'vue-avatar'

    export default {
        props: ['video'],
        components: {
            Avatar
        },
        mounted() {
            this.fetchComments()
        },
        data: () => ({
            comments: {
                data: []
            }
        }),
        methods: {
            fetchComments() {
                const url = this.comments.next_page_url ? this.comments.next_page_url : `/videos/${this.video.id}/comments`

                axios.get(url).then(({ data }) => {
                    this.comments = {
                        ...data,
                        data: [
                            ...this.comments.data,
                            ...data.data
                        ]
                    }
                })
            }
        }
    }
</script>
