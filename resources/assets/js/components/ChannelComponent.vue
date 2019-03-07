<template>
    <div id="app">
        <div class="col-sm-12">
            <h5 class="text-white-50 my-4">Youtubeチャンネル一覧</h5>
            <table class="table table-hover text-light">
                <tbody>
                    <tr v-for="l in lists"
                        :href="'/' + l.platform + '/' + l.platform_channel_id"
                        v-on:click="clickTr(l.platform, l.platform_channel_id)"
                    >
                      <td><img :src="'/storage/youtube_social_circle_white.png'" width="30"></td>
                      <td><span class="h6">{{ l.title }}</span></td>
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

            <a href="" data-toggle="modal" data-target="#modal1">
                <h6 class="text-white-50" >新しくチャンネルを登録する</h6>
            </a>
        </div>
        <div class="clearfix"></div>

        <!-- モーダル　新規登録 -->
        <div class="modal fade modal-lg" id="modal1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">チャンネル新規登録</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>登録するYoutubeチャンネルのIDを入力してください</p>
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">https://www.youtube.com/channel/</span>
                            </div>
                            <input type="text" class="form-control" v-model="createChannelId" placeholder="" aria-label="チャンネルID" aria-describedby="addon-wrapping">
                        </div>
                        <p v-if="createError" class="text-danger">{{ createErrorMsg }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" v-on:click="create">新規登録保存</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: [],
        created() {
            this.getCollection();
        },
        data() {
            return {
                lists: [],
                createChannelId: '',
                createError: false,
                createErrorMsg: '',
                meta: {
                    current_page: 1,
                    last_page: 1,
                    to: null,
                    total: null,
                    from: null
                }
            }
        },
        methods: {
            prevPage() {
                if(this.meta.current_page > 1) {
                    this.meta.current_page--
                    this.getCollection()
                }
            },
            nextPage() {
                if(this.meta.current_page < this.meta.last_page) {
                    this.meta.current_page++
                    this.getCollection()
                }
            },
            getCollection() {
                var param = '?page=' + this.meta.current_page
                window.axios.get('/api/channel' + param).then(({data}) => {
                    this.lists = data.data
                    this.meta = data.meta
                });
            },
            clickTr(platform, channelId) {
                document.location = "/" + platform + "/" + channelId
            },
            create() {
                var url = 'https://www.googleapis.com/youtube/v3/channels?part=id,snippet'
                url += '&key=AIzaSyAOTRHXFrkyIdcaTWR5VtbrwUGUNyqubko&id=' + this.createChannelId
                window.axios.get(url).then(({data}) => {
                    if(data.items.length == 0) {
                        this.createError = true
                        this.createErrorMsg = 'URLが間違っています'
                    } else {
                        var title = data.items[0].snippet.title
                        window.axios.post('/api/channel/create', {
                            'platform_channel_id': this.createChannelId,
                            'platform': 'youtube',
                            'title': title
                        }).then(({response}) => {
                            console.log("create success", response)
                            document.location = "/youtube/" + this.createChannelId
                        }).catch(({error}) => {
                            this.createError = true
                            this.createErrorMsg = '作成に失敗しました'
                        })
                    }
                })
            }
        }
    }
</script>
