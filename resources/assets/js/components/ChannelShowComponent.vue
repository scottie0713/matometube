<template>
    <div id="app">
        <div class="col-sm-12">
            <h4 class="text-light my-4">{{ channel.title }}</h4>

            <h5 class="text-white-50 my-4">クリップリスト</h5>
            <table class="table table-hover text-light">
                <tbody>
                    <tr v-for="l in cliplists">
                    <td>
                        <span class="h6">{{ l.title }}&nbsp;</span>
                    </td>
                    <td style="width:96px">
                        <button class="btn btn-sm btn-danger" v-on:click="clickPlay(l.id)">再生</button>
                    </td>
                    <td style="width:96px">
                        <button class="btn btn-sm btn-light" v-on:click="clickEdit(l.id)">編集</button>
                    </td>
                    <td style="width:96px">
                        <button class="btn btn-sm btn-light" v-on:click="clickDelete(l.id)">非表示</button>
                    </td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-8">
                    <a href="" v-on:click="createCliplist">
                        <h6 class="text-white-50">新しくクリップリストを追加する</h6>
                    </a>
                </div>
                <div class="col-4 text-right">
                    <a :href="'/' + platform + '/' + platform_channel_id + '/dust'">
                        <h6 class="text-muted">ゴミ箱</h6>
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['platform', 'platform_channel_id'],
        components: {},
        created() {
            this.getChannel()
        },
        mounted() {
        },
        data() {
            return {
                loading: true,
                channel: {},
                cliplists: []
            }
        },
        watch: {
        },
        methods: {
            getChannel() {
                window.axios.get('/api/channel/' + this.platform + '/' + this.platform_channel_id).then(({data}) => {
                    this.channel = data.data
                    this.getCliplist()
                });
            },
            getCliplist() {
                window.axios.get('/api/cliplist/channel/' + this.channel.id).then(({data}) => {
                    this.cliplists = data.data
                })
            },
            clickPlay(cliplist_id) {
                document.location = "/" + this.platform + "/" + this.platform_channel_id + "/cliplist/" + cliplist_id + "/play"
            },
            clickEdit(cliplist_id) {
                document.location = "/" + this.platform + "/" + this.platform_channel_id + "/cliplist/" + cliplist_id + "/edit1"
            },
            clickDelete(cliplist_id) {
                window.axios.post('/api/cliplist/delete', {
                    'cliplist_id': cliplist_id,
                }).then(({response}) => {
                    console.log("create success", response)
                    document.location = "/" + this.platform + "/" + this.platform_channel_id
                }).catch(({error}) => {
                })
            },
            createCliplist() {
                window.axios.post('/api/cliplist/create', {
                    'channel_id': this.channel.id,
                    'title': '新規クリップリスト'
                }).then(({response}) => {
                    console.log("create success", response)
                    document.location = "/" + this.platform + "/" + this.platform_channel_id
                }).catch(({error}) => {
                })
            }
        }
    }
</script>
