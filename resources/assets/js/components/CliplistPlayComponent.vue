<template>
    <div class="container-fluid">
        <h5 class="text-light my-2"><a class="text-light" :href="'/'+ platform + '/' + platform_channel_id">&lt;</a>&nbsp;{{ cliplist.title }}</h5>
        <div class="row no-gutters">
            <div id="player" class="col-12 col-md-8 col-lg-9">
                <youtube :video-id="videoId" ref="youtube" :player-vars="playerVars" :resize="true" @ended="next" @playing="playing"></youtube>
            </div>
            <div id="cliplists" class="col-12 col-md-4 col-lg-3">
                <div class="list-group text-left">
                    <button
                        v-for="(clip, index) in cliplist.cliplist_clips"
                        v-on:click="click(index)"
                        :class="[clip.active ? 'list-group-item-success' : '', 'list-group-item', 'list-group-item-action', 'h6']"
                    >{{ clip.order}}.&nbsp;{{ clip.comment }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
#player {
    position: relative;
    padding-bottom: 50%;
    padding-top: 30px;
    height: 0;
    overflow: hidden;
}

#player iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

<script>
    import VueYoutube from 'vue-youtube'
    Vue.use(VueYoutube)
    export default {
        props:['platform','platform_channel_id','cliplist_id'],
        created() {
            this.getCliplist()
        },
        mounted() {
        },
        data() {
            return {
                hoge: false,
                videoId: "",
                playlistNo: 0,
                lastPlaylistNo: 0,
                cliplist: [],
                playerVars: {
                    autoplay: 1,
                    rel: 0,
                    fs: 0,
                    controls: 2,
                    cc_load_policy: 0,
                    iv_load_policy: 0,
                    start: 0,
                    end: 0,
                    showinfo: 0
                },
                lock: false
            }
        },
        methods: {
            getCliplist() {
                window.axios.get('/api/cliplist/' + this.cliplist_id).then(({data}) => {
                    this.cliplist = data.data[0]
                    var clips = this.cliplist.cliplist_clips[0]
                    this.cliplist.cliplist_clips.forEach((value, i) => {
                        if(i == 0) {
                            this.$set(value, 'active', true)
                        } else {
                            this.$set(value, 'active', false)
                        }
                        this.lastPlaylistNo = i
                    })
                    this.change(clips.movie_id, clips.start_sec, clips.end_sec)
                });
            },
            next() {
                if(!this.lock) {
                    this.$set(this.cliplist.cliplist_clips[this.playlistNo], "active", false)
                    if(this.playlistNo < this.lastPlaylistNo) {
                        this.lock = true
                        this.playlistNo++
                        this.$set(this.cliplist.cliplist_clips[this.playlistNo], "active", true)
                        this.change()
                    }
                } else {
                    this.lock = false
                }
            },
            click(index) {
                this.$set(this.cliplist.cliplist_clips[this.playlistNo], "active", false)
                if(!this.lock) {
                    this.lock = true
                    this.playlistNo = index
                    this.$set(this.cliplist.cliplist_clips[this.playlistNo], "active", true)
                    this.change()
                }
            },
            change() {
                var clips = this.cliplist.cliplist_clips[this.playlistNo]
                this.$refs.youtube.player.loadVideoById({
                    'videoId': clips.movie_id,
                    'startSeconds': clips.start_sec,
                    'endSeconds': clips.end_sec
                })
            },
            playing() {
                this.lock = false
            }
        }
    }
</script>
