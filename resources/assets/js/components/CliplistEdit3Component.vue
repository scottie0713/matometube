<template>
    <div class="container-fluid">
        <h5 class="text-light my-2">{{ cliplist.title }} 編集</h5>
        <ul class="nav nav-pills">
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit1'" class="nav-link">名前編集</a></li>
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit2'" class="nav-link">クリップ編集</a></li>
          <li class="nav-item"><div class="nav-link active">クリップ並び替え</div></li>
        </ul>

        <div class="my-4">
            <div class="h6 text-white-50">登録クリップ</div>
            <table class="table table-sm text-light">
                <tbody>
                    <tr v-for="(c, index) in cliplist.cliplist_clips">
                      <td class="h6">{{ c.comment }}</td>
                      <td><button class="btn btn-sm btn-info" v-on:click="upOrderClip(index)">↑</button></td>
                      <td><button class="btn btn-sm btn-info" v-on:click="downOrderClip(index)">↓</button</td>
                      <td><button class="btn btn-sm btn-primary" v-on:click="editClip(index)">編集</button></td>
                      <td><button class="btn btn-sm btn-danger" v-on:click="deleteClip(index)">削除</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import SlideUpDown from 'vue-slide-up-down'
    Vue.component('slide-up-down', SlideUpDown)
    export default {
        components: {
        },
        props: ['platform', 'platform_channel_id', 'cliplist_id'],
        created() {
            this.getCliplist()
        },
        data() {
            return {
                active: {
                    playlist: true,
                    playlistItem: false,
                    player: false,
                    cliplist: true
                },
                cliplist: [],
            }
        },
        methods: {
            // *************************************************
            // 汎用系
            // *************************************************
            convertTime(sec) {
                var min = 0
                if(sec >= 60) {
                    min = parseInt(sec / 60)
                    sec = sec % 60
                }
                if(sec < 10) {
                    sec = '0' + sec
                }
                return min + ':' + sec
            },
            // *************************************************
            // DB取得/更新系
            // *************************************************
            getCliplist() {
                window.axios.get('/api/cliplist/' + this.cliplist_id).then(({data}) => {
                    this.cliplist = data.data[0]
                    if(this.cliplist.cliplist_clips.length == 0) {
                        this.cliplist.cliplist_clips = []
                    }
                });
            },
            editClip(index) {
                var clip = this.cliplist.cliplist_clips[index]
                console.log("editClip", clip)
                this.currentClip.movie_id = clip.movie_id
                this.currentClip.comment = clip.comment
                this.setStartSec(clip.start_sec)
                this.setEndSec(clip.end_sec)
                this.currentClip.is_new = false
                this.currentClip.index = index
                this.setPlayer()
                this.openTogglePlayer()
                this.closeTogglePlaylist()
            },
            addClip() {
                var clip = JSON.parse(JSON.stringify(this.currentClip))
                if(this.currentClip.is_new) {
                    this.cliplist.cliplist_clips.push(clip)
                    this.update()
                } else {
                    var index = this.currentClip.index
                    this.$set(this.cliplist.cliplist_clips[index], 'start_sec', clip.start_sec)
                    this.$set(this.cliplist.cliplist_clips[index], 'end_sec', clip.end_sec)
                    this.$set(this.cliplist.cliplist_clips[index], 'comment', clip.comment)
                    this.update()
                }
            },
            deleteClip(idx) {
                this.cliplist.cliplist_clips.splice(idx, 1)
                this.update()
            },
            upOrderClip(index) {
                if(index > 0) {
                    var idx1 = index
                    var idx2 = index - 1
                    var clip1 = JSON.parse(JSON.stringify(this.cliplist.cliplist_clips[idx1]))
                    var clip2 = JSON.parse(JSON.stringify(this.cliplist.cliplist_clips[idx2]))
                    this.$set(this.cliplist.cliplist_clips, idx1, clip2)
                    this.$set(this.cliplist.cliplist_clips, idx2, clip1)
                    this.update()
                }
            },
            downOrderClip(index) {
                if((this.cliplist.cliplist_clips.length + 1) > index) {
                    var idx1 = index
                    var idx2 = index + 1
                    var clip1 = JSON.parse(JSON.stringify(this.cliplist.cliplist_clips[idx1]))
                    var clip2 = JSON.parse(JSON.stringify(this.cliplist.cliplist_clips[idx2]))
                    this.$set(this.cliplist.cliplist_clips, idx1, clip2)
                    this.$set(this.cliplist.cliplist_clips, idx2, clip1)
                    this.update()
                }
            },
            update() {
                window.axios.post('/api/cliplist/' + this.cliplist_id + '/clip', {
                    'cliplist_clips': this.cliplist.cliplist_clips
                }).then(({response}) => {
                    console.log("update success", response)
                }).catch(({error}) => {
                    console.log("update error", error)
                })
            }
        }
    }
</script>
