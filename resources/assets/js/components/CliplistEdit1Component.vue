<template>
    <div class="container-fluid">
        <h5 class="text-light my-2"><a class="text-light" :href="'/'+ platform + '/' + platform_channel_id">&lt;</a>&nbsp;{{ cliplist.title }}</h5>
        <ul class="nav nav-pills">
          <li class="nav-item"><div class="nav-link active">名前編集</div></li>
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit2'" class="nav-link">クリップ</a></li>
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit3'" class="nav-link">並べ替え</a></li>
        </ul>
        <div class="my-4">
            <div class="togglebutton h6 text-white-50">タイトルを編集できます</div>
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">タイトル</span>
                    </div>
                    <input type="text" class="form-control" v-model="cliplist.title">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">パスワード</span>
                    </div>
                    <input type="text" class="form-control" value="未実装" disabled="disabled">
                </div>

                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-info" v-on:click="updateCliplist()">保存</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger" v-on:click="deleteCliplist()">削除</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
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
            // DB取得/更新系
            // *************************************************
            getCliplist() {
                window.axios.get('/api/cliplist/' + this.cliplist_id).then(({data}) => {
                    this.cliplist = data.data[0]
                });
            },
            updateCliplist() {
                window.axios.put('/api/cliplist/' + this.cliplist_id, {
                    'title': this.cliplist.title
                }).then(({response}) => {
                    console.log("update success", response)
                }).catch(({error}) => {
                    console.log("update error", error)
                })
            },
            deleteCliplist() {
                window.axios.post('/api/cliplist/' + this.cliplist_id + '/delete', {
                }).then(({response}) => {
                    console.log("delete success", response)
                    document.location = "/" + this.platform + "/" + this.platform_channel_id
                }).catch(({error}) => {
                    console.log("delete error", error)
                })
            }
        }
    }
</script>