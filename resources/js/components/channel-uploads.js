import { default as axios } from "axios"

Vue.component('channel-uploads', {
    props: {
        channel: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },
    data: () => ({
        selected: false,
        videos: [],
        progress: {},
        uploads: [],
        intervals: {}
    }),
    methods: {
        upload() {
            this.selected = true
            this.videos = Array.from(this.$refs.videos.files)

            const uploaders = this.videos.map(async video => {
                const form = new FormData()

                this.progress[video.name] = 0

                form.append('video', video)
                form.append('title', video.name)

                const { data } = await axios.post(`/channels/${this.channel.id}/videos`, form, {
                    onUploadProgress: (event_1) => {
                        this.progress[video.name] = Math.ceil((event_1.loaded / event_1.total) * 100)

                        this.$forceUpdate()
                    }
                })
                this.uploads = [
                    ...this.uploads,
                    data
                ]
            })

            axios.all(uploaders)
                .then(() => {
                    this.videos = this.uploads

                    this.videos.forEach(video => {
                        this.intervals[video.id] = setInterval(() => {
                            axios.get(`/videos/${video.id}`).then(({ data }) => {

                                if (data.percentage === 100) {
                                    clearInterval(this.intervals[video.id])
                                }
                                
                                this.videos = this.videos.map(v => {
                                    if (v.id === data.id) {
                                        return data
                                    }

                                    return v
                                })
                            })
                        }, 3000)
                    })
                })
        }
    }
})
