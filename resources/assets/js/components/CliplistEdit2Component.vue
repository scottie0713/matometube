<template>
    <div class="container-fluid">
        <h5 class="text-light my-2">{{ cliplist.title }} 編集</h5>
        <ul class="nav nav-pills">
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit1'" class="nav-link">名前編集</a></li>
          <li class="nav-item"><div class="nav-link active">クリップ編集</div></li>
          <li class="nav-item"><a :href="'/' + platform + '/' + platform_channel_id + '/cliplist/' + cliplist_id + '/edit3'" class="nav-link">クリップ並び替え</a></li>
        </ul>
        <div class="my-4">
            <div v-on:click="togglePlaylist" class="togglebutton h6 text-white-50">クリップする動画を選択してください</div>
            <slide-up-down :active="active.playlist">
                <div class="element">
                    <ul class="nav nav-tabs">
                        <div :class="'nav-item nav-link text-white-50 ' + [navStatus.playlistActive ? 'active' : '']" v-on:click="clickPlaylistTab()">再生リスト</div>
                        <div :class="'nav-item nav-link text-white-50 ' + [navStatus.playlistItemActive ? 'active' : ''] + [navStatus.playlistItemDisabled ? 'disabled' : '']" v-on:click="clickPlaylistItemTab()">{{ navStatus.playlistItemName }}</div>
                        <div :class="'nav-item nav-link text-white-50 ' + [navStatus.videosActive ? 'active' : '']" v-on:click="clickVideosTab()">動画</div>
                    </ul>

                    <!-- 再生リスト -->
                    <div v-show="navStatus.playlistActive">
                        <div class="list-group">
                            <button v-for="l in playlists" class="list-group-item list-group-item-secondary list-group-item-action" v-on:click="clickPlaylistItem(l.id, l.snippet.title)">
                                <img :src="l.snippet.thumbnails.medium.url" style="width:64px" />
                                {{ l.snippet.title }}
                            </button>
                        </div>
                        <nav aria-label="pager" class="my-2">
                            <ul class="pagination justify-content-between">
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="prevPlaylistPage">&lt;&nbsp;Prev</button>
                                </li>
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="nextPlaylistPage">Next&nbsp;&gt;</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /再生リスト -->

                    <!-- 再生リスト中身一覧 -->
                    <div v-show="navStatus.playlistItemActive">
                        <div class="list-group">
                            <button v-for="l in playlistItems" class="list-group-item list-group-item-secondary list-group-item-action" v-on:click="setVideo(l.snippet.resourceId.videoId, l.snippet.title)">
                                <img :src="l.snippet.thumbnails.default.url" style="width:64px" />
                                {{ l.snippet.title }}
                            </button>
                        </div>
                        <nav aria-label="pager" class="my-2">
                            <ul class="pagination justify-content-between">
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="prevPlaylistItemPage">&lt;&nbsp;Prev</button>
                                </li>
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="nextPlaylistItemPage">Next&nbsp;&gt;</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /再生リスト中身一覧 -->

                    <!-- 動画リスト一覧 -->
                    <div v-show="navStatus.videosActive">
                        <div class="list-group">
                            <button v-for="l in videos" class="list-group-item list-group-item-secondary list-group-item-action" v-on:click="setVideo(l.id.videoId, l.snippet.title)">
                                <img :src="l.snippet.thumbnails.default.url" style="width:64px" />
                                {{ l.snippet.title }}
                            </button>
                        </div>
                        <nav aria-label="pager" class="my-2">
                            <ul class="pagination justify-content-between">
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="prevVideosPage">&lt;&nbsp;Prev</button>
                                </li>
                                <li>
                                    <button class="btn btn-sm page-link px-4 bg-transparent text-light" v-on:click="nextVideosPage">Next&nbsp;&gt;</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /動画リスト一覧 -->
                </div>
            </slide-up-down>
            <div class="togglefooter border-top rounded-bottom py-2"></div>
        </div>

        <div class="my-4">
            <div v-on:click="togglePlayer" class="togglebutton h6 text-white-50">再生時間設定 / コメント設定</div>
            <slide-up-down :active="active.player">
                <div class="element">
                    <div class="container-fluid">
                        <div class="text-center">
                            <youtube :video-id="currentClip.movie_id" ref="youtube" :player-vars="{autoplay: 1}" :width="800" :resize="true"></youtube>
                        </div>

                        <div class="row">
                            <div class="col-6 my-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="copyStartSec()">シーク位置から再生する</button>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="prevStartSec()">&lt;</button>
                                    </div>
                                    <span class="form-control text-center" id="addon-wrapping">{{ startText }}</span>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="nextStartSec()">&gt;</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 my-2 text-center">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="copyEndSec()">シーク位置まで再生する</button>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="prevEndSec()">&lt;</button>
                                    </div>
                                    <span class="form-control text-center" id="addon-wrapping">{{ endText }}</span>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary" v-on:click="nextEndSec()">&gt;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="addon-wrapping">コメント</span>
                                    </div>
                                    <input type="text" class="form-control" v-model="currentClip.comment">
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <button class="btn btn-sm btn-secondary" v-on:click="setPlayer()">プレビュー</span></button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-sm btn-primary" v-on:click="addClip()">
                                <span v-if="currentClip.is_new">登録</span>
                                <span v-else>更新</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </slide-up-down>
            <div class="togglefooter border-top rounded-bottom py-2"></div>
        </div>

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
<style>
.togglefooter {
    //background-color: #dadad8;
}
iframe {
  width: 100%;
  max-width: 2436px;
  //height: 400px;
}
</style>

<script>
    import SlideUpDown from 'vue-slide-up-down'
    import VueYoutube from 'vue-youtube'
    Vue.use(VueYoutube)
    Vue.component('slide-up-down', SlideUpDown)
    export default {
        components: {
        },
        props: ['platform', 'platform_channel_id', 'cliplist_id'],
        created() {
            this.getCliplist()
            this.getYoutubePlaylist()
            this.getYoutubeVideos()
        },
        data() {
            return {
                active: {
                    playlist: true,
                    playlistItem: false,
                    player: false,
                    cliplist: true
                },
                navStatus: {
                    playlistActive: true,
                    playlistItemActive: false,
                    playlistItemDisabled: false,
                    playlistItemName: '----',
                    videosActive: false
                },
                playlistPage: {
                    current: 1,
                    max: 1,
                    nextPageToken: '',
                    prevPageToken: ''
                },
                playlistItemPage: {
                    current: 1,
                    max: 1,
                    nextPageToken: '',
                    prevPageToken: ''
                },
                videosPage: {
                    current: 1,
                    max: 1,
                    nextPageToken: '',
                    prevPageToken: ''
                },
                currentPlaylistId: '',
                lastPlaylistNo: 0,
                cliplist: [],
                playlists: [],
                playlistItems: [],
                videos: [],
                sliderValue: 0,
                currentClip: {
                    is_new: false,
                    index: 0,
                    movie_id: '',
                    start_sec: 0,
                    end_sec: 0,
                    comment: ''
                },
                startText: '0:00',
                endText: '0:00',
                playerVars: {
                    autoplay: 1,
                    rel: 0,
                    fs: 0,
                    controls: 2,
                    cc_load_policy: 0,
                    iv_load_policy: 3,
                    start: 0,
                    end: 0,
                    showinfo: 0,
                    modestbranding: 1
                }
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
            // 動画一覧 Navバー関連
            // *************************************************
            clickPlaylistTab() {
                if(!this.navStatus.playlistActive) {
                    this.navStatus.playlistActive = true
                    this.navStatus.playlistItemActive = false
                    this.navStatus.videosActive = false
                }
            },
            clickPlaylistItemTab() {
                if(!this.navStatus.playlistItemActive && !this.navStatus.playlistItemDisabled) {
                    this.navStatus.playlistActive = false
                    this.navStatus.playlistItemActive = true
                    this.navStatus.videosActive = false
                }
            },
            clickVideosTab() {
                if(!this.navStatus.videosActive) {
                    this.navStatus.playlistActive = false
                    this.navStatus.playlistItemActive = false
                    this.navStatus.videosActive = true
                }
            },
            // *************************************************
            // 再生リスト関連
            // *************************************************
            getYoutubePlaylist(pageToken = false) {
                var url = 'https://www.googleapis.com/youtube/v3/playlists?part=id,snippet'
                url += '&key=AIzaSyAOTRHXFrkyIdcaTWR5VtbrwUGUNyqubko&maxResults=5'
                url += '&channelId=' + this.platform_channel_id
                if(pageToken) {
                    url += '&pageToken=' + pageToken
                }
                window.axios.get(url).then(({data}) => {
                    this.playlists = data.items
                    if(typeof data.prevPageToken !== 'undefined') {
                        this.playlistPage.prevPageToken = data.prevPageToken
                    } else {
                        this.playlistPage.prevPageToken = ''
                    }
                    if(typeof data.nextPageToken !== 'undefined') {
                        this.playlistPage.nextPageToken = data.nextPageToken
                    } else {
                        this.playlistPage.nextPageToken = ''
                    }
                });
            },
            prevPlaylistPage() {
                if(this.playlistPage.prevPageToken.length > 0) {
                    this.playlistPage.current--
                    this.getYoutubePlaylist(this.playlistPage.prevPageToken)
                }
            },
            nextPlaylistPage() {
                if(this.playlistPage.nextPageToken.length > 0) {
                    this.playlistPage.current++
                    this.getYoutubePlaylist(this.playlistPage.nextPageToken)
                }
            },
            clickPlaylistItem(playlistId, title) {
                this.currentPlaylistId = playlistId
                this.navStatus.playlistItemName = title
                this.clickPlaylistItemTab()
                this.getYoutubePlaylistItem()
            },
            // *************************************************
            // 再生リスト動画一覧関連
            // *************************************************
            getYoutubePlaylistItem(pageToken = false) {
                var url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=id,snippet,contentDetails'
                url += '&key=AIzaSyAOTRHXFrkyIdcaTWR5VtbrwUGUNyqubko&maxResults=5'
                url += '&playlistId=' + this.currentPlaylistId
                if(pageToken) {
                    url += '&pageToken=' + pageToken
                }
                window.axios.get(url).then(({data}) => {
                    this.playlistItems = data.items
                    if(typeof data.prevPageToken !== 'undefined') {
                        this.playlistItemPage.prevPageToken = data.prevPageToken
                    } else {
                        this.playlistItemPage.prevPageToken = ''
                    }
                    if(typeof data.nextPageToken !== 'undefined') {
                        this.playlistItemPage.nextPageToken = data.nextPageToken
                    } else {
                        this.playlistItemPage.nextPageToken = ''
                    }
                });
            },
            prevPlaylistItemPage() {
                if(this.playlistItemPage.prevPageToken.length > 0) {
                    this.playlistItemPage.current--
                    this.getYoutubePlaylistItem(this.playlistItemPage.prevPageToken)
                }
            },
            nextPlaylistItemPage() {
                if(this.playlistItemPage.nextPageToken.length > 0) {
                    this.playlistItemPage.current++
                    this.getYoutubePlaylistItem(this.playlistItemPage.nextPageToken)
                }
            },
            // *************************************************
            // 動画一覧関連
            // *************************************************
            getYoutubeVideos(pageToken = false) {
                var url = 'https://www.googleapis.com/youtube/v3/search?part=id,snippet'
                url += '&key=AIzaSyAOTRHXFrkyIdcaTWR5VtbrwUGUNyqubko&maxResults=5&order=date'
                url += '&channelId=' + this.platform_channel_id
                if(pageToken) {
                    url += '&pageToken=' + pageToken
                }
                window.axios.get(url).then(({data}) => {
                    this.videos = data.items
                    if(typeof data.prevPageToken !== 'undefined') {
                        this.videosPage.prevPageToken = data.prevPageToken
                    } else {
                        this.videosPage.prevPageToken = ''
                    }
                    if(typeof data.nextPageToken !== 'undefined') {
                        this.videosPage.nextPageToken = data.nextPageToken
                    } else {
                        this.videosPage.nextPageToken = ''
                    }
                });
            },
            prevVideosPage() {
                if(this.videosPage.prevPageToken.length > 0) {
                    this.videosPage.current--
                    this.getYoutubeVideos(this.videosPage.prevPageToken)
                }
            },
            nextVideosPage() {
                if(this.videosPage.nextPageToken.length > 0) {
                    this.videosPage.current++
                    this.getYoutubeVideos(this.videosPage.nextPageToken)
                }
            },
            // *************************************************
            // アコーディオン開閉系
            // *************************************************
            openTogglePlaylist() {
                this.active.playlist = true
            },
            closeTogglePlaylist() {
                this.active.playlist = false
            },
            openTogglePlayer() {
                this.active.player = true
            },
            closeTogglePlayer() {
                this.active.player = false
            },
            togglePlaylist() {
                this.active.playlist = !this.active.playlist
                this.active.playlistItem = false
            },
            togglePlaylistItem() {
                this.active.playlistItem = !this.active.playlistItem
                this.active.playlist = false
            },
            togglePlayer() {
                this.active.player = !this.active.player
            },
            // *************************************************
            // 再生開始・終了時間系
            // *************************************************
            setStartSec(sec) {
                this.currentClip.start_sec = sec
                this.startText = this.convertTime(sec)
            },
            copyStartSec() {
                this.$refs.youtube.player.getCurrentTime().then(value => {
                    this.currentClip.start_sec = parseInt(value)
                    this.startText = this.convertTime(this.currentClip.start_sec)
                })
            },
            prevStartSec() {
                if(this.currentClip.start_sec > 0) {
                    this.currentClip.start_sec--
                    this.startText = this.convertTime(this.currentClip.start_sec)
                }
            },
            nextStartSec() {
                this.currentClip.start_sec++
                this.startText = this.convertTime(this.currentClip.start_sec)
            },
            setEndSec(sec) {
                this.currentClip.end_sec = sec
                this.endText = this.convertTime(sec)
            },
            copyEndSec() {
                this.$refs.youtube.player.getCurrentTime().then(value => {
                    this.currentClip.end_sec = parseInt(value)
                    this.endText = this.convertTime(this.currentClip.end_sec)
                })
            },
            prevEndSec() {
                if(this.currentClip.end_sec > 0) {
                    this.currentClip.end_sec--
                    this.endText = this.convertTime(this.currentClip.end_sec)
                }
            },
            nextEndSec() {
                this.currentClip.end_sec++
                this.endText = this.convertTime(this.currentClip.end_sec)
            },
            // *************************************************
            // プレイヤー設定系
            // *************************************************
            setVideo(movieId, comment = '') {
                this.currentClip.movie_id = movieId
                this.currentClip.comment = comment
                this.currentClip.start_sec = 0
                this.currentClip.end_sec = 0
                this.currentClip.is_new = true
                this.openTogglePlayer()
            },
            setPlayer() {
                this.$refs.youtube.player.loadVideoById({
                    'videoId':  this.currentClip.movie_id,
                    'startSeconds': this.currentClip.start_sec,
                    'endSeconds': this.currentClip.end_sec
                })
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
