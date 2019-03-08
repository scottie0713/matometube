<template>
    <div id="app">
        <div class="col-sm-12">
            <h4 class="text-light my-4"><a class="text-light" href="/channel">&lt;</a>&nbsp;{{ channel.title }}</h4>

            <h5 class="text-white-50 my-4">クリップリスト</h5>
            <table class="table table-hover text-light">
                <tbody>
                    <tr v-for="l in cliplists">
                    <td>
                        <span class="h6">{{ l.title }}&nbsp;</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" v-on:click="clickPlay(l.id)">再生</button>
                        <button class="btn btn-sm btn-light" v-on:click="clickEdit(l.id)">編集</button>
                    </td>
                    </tr>
                </tbody>
            </table>

            <nav aria-label="pager" class="my-2">
                <ul class="pagination justify-content-between">
                    <li>
                        <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="prevPage">&lt;&nbsp;前</button>
                    </li>
                    <li class="px-4 h6 text-light">{{ meta.current_page }}</li>
                    <li>
                        <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="nextPage">次&nbsp;&gt;</button>
                    </li>
                </ul>
            </nav>

            <div class="my-4">
                <a href="" v-on:click="createCliplist">
                    <h6 class="text-white-50">新しくクリップリストを追加する</h6>
                </a>
            </div>
            <div class="my-4">
                <a :href="'/' + platform + '/' + platform_channel_id + '/dust'">
                    <h6 class="text-muted">ゴミ箱</h6>
                </a>
            </div>
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
                cliplists: [],
                meta: {
                    current_page: 1,
                    last_page: 1,
                    to: null,
                    total: null,
                    from: null
                }
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
                var url = '/api/cliplist/channel/' + this.channel.id
                url += '?page=' + this.meta.current_page
                window.axios.get(url).then(({data}) => {
                    this.cliplists = data.data
                    this.meta = data.meta
                })
            },
            prevPage() {
                if(this.meta.current_page > 1) {
                    this.meta.current_page--
                    this.getCliplist()
                }
            },
            nextPage() {
                if(this.meta.current_page < this.meta.last_page) {
                    this.meta.current_page++
                    this.getCliplist()
                }
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
