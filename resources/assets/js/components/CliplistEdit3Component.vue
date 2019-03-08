<template>
    <div class="container-fluid">
        <h5 class="text-light my-2"><a class="text-light" :href="'/'+ platform + '/' + platform_channel_id">&lt;</a>&nbsp;{{ cliplist.title }}</h5>
        <ul class="nav nav-pills">
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit1'" class="nav-link">名前編集</a></li>
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit2'" class="nav-link">クリップ</a></li>
          <li class="nav-item"><div class="nav-link active">並び替え</div></li>
        </ul>

        <div class="my-4 col-12">
            <div class="h6 text-white-50">ドラッグアンドドロップで並び替えできます</div>

            <div>
                <button type="button" class="btn btn-outline-info" v-on:click="update()">保存</button>
            </div>

            <draggable v-model="cliplist.cliplist_clips" group="people" @start="drag=true" @end="drag=false">
                <button class="btn btn-light btn-sm w-100 my-2" v-for="(c, index) in cliplist.cliplist_clips" :key="c.id">{{ c.comment }}</button>
            </draggable>

            <div>
                <button type="button" class="btn btn-outline-info" v-on:click="update()">保存</button>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        props: ['platform', 'platform_channel_id', 'cliplist_id'],
        created() {
            this.getCliplist()
        },
        data() {
            return {
                cliplist: []
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
            deleteClip(idx) {
                this.cliplist.cliplist_clips.splice(idx, 1)
                this.update()
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
