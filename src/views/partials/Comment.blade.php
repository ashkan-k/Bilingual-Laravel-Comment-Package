<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

{{--Bootstrap--}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

{{--Font-Awesome--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

{{--SweetAlert--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">

{{--Vue JS--}}
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
        integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
        crossorigin="anonymous"></script>

{{--Toastr--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
      integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
      crossorigin="anonymous"/>


{{--Loading--}}
<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

@if(config('comment.options.Pagination') == 1 || config('comment.options.Pagination') == 2)
    {{--Pagination--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
    <link rel="stylesheet" href="/assets/pagination.css">
@endif

@if(config('comment.options.Editor') == 1)

    {{--CKEDITOR--}}
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="https://unpkg.com/vue-ckeditor2"></script>

@elseif(config('comment.options.Editor') == 2)

    {{--Tiny MCE--}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/w-tinymce-vue@1.0.30/dist/w-tinymce-vue.umd.js"></script>

@endif



{{-- Font(Deafault is VAZIR) --}}
<link rel="stylesheet" href="{{ config('comment.font') }}">

{{--Styles--}}
<link rel="stylesheet" href="/assets/styles.css">

<style>
    @if(app()->getLocale() == 'fa')

            .box-header li {
        float: right
    }

    @endif
</style>


<div id="app">
    <div class="container main-margin" dir="rtl">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1" id="logout">
                <div class="page-header text-center">
                    <h3 class="reviews">{{ __('comment.Post New Comment') }}</h3>
                </div>
                <div class="comment-tabs">
                    <ul class="nav nav-tabs  box-header" role="tablist">
                        <li class="active"><a href="#comments-list" role="tab" data-toggle="tab"><h4
                                    class="reviews text-capitalize">{{ __('comment.Comments') }}</h4></a></li>
                        <li @click="SwitchToCreate()"><a href="#add-comment" role="tab" data-toggle="tab"><h4
                                    class="reviews text-capitalize">{{ __('comment.Add comment') }}</h4></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="comments-list">
                            @if(!auth()->check() && !config('comment.options.ALLOW_ANONYMOUS_Comment'))
                                <div>
                                    <div class="alert alert-info text-center"
                                         style="font-size: 15px; margin-bottom: 35px !important;">
                                        @if(app()->getLocale() == 'fa')
                                            برای ویرایش نظرات خود و یا لایک و دیس لایک کردن نظرات ابتدا باید <a
                                                href="/login"> وارد </a> شوید
                                        @else
                                            To edit your comments or like and dislike the comments, you must <a
                                                href="/login"> LOGIN </a> first
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                            @endif

                            <ul class="media-list">

                                @if(config('comment.options.SearchBox'))
                                    <div style="margin-bottom: 5%" class="form-inline text-center">
                                        <input @keyup="GetAllComments()" v-model="search_word" type="text" class="form-control" placeholder="search...">
                                        <span class="input-group-text border-0" id="search-addon">
                                        <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                @endif

                                <div v-if="comments['length'] !== 0">
                                    <li v-for="item in comments['data']" class="media">
                                        <a class="pull-right" href="#">

                                            <img class="media-object img-circle image"
                                                 :src="ShowImage(item.user)"
                                                 alt="profile">
                                        </a>
                                        <div class="media-body">
                                            <div class="well well-lg">
                                                <h4 class="media-heading text-uppercase reviews">
                                                    <span
                                                        class="glyphicon glyphicon-user"></span>
                                                    @{{ DisplayUserName(item.user) }}
                                                </h4>

                                                <span>&nbsp &nbsp</span>

                                                <ul class="media-date text-uppercase reviews list-inline">
                                                    @{{ item.created_at }}
                                                </ul>
                                                <h3 class="media-comment">
                                                    @{{ item.title }}
                                                </h3>

                                                <br>

                                                @if(config('comment.options.Editor') !== 3)
                                                    <p class="media-comment" v-html="item.content">

                                                    </p>
                                                @else
                                                    <p class="media-comment" v-text="item.content">

                                                    </p>

                                                @endif


                                                <div class="col-12 row" style="margin-top: 5% !important;">

                                                    @if(auth()->check() && config('comment.options.Has_Like_And_DisLike'))
                                                        <div class="col-6">
                                                            <div class="pull-left">
                                                                <a id="like" data-toggle="tooltip" data-placement="top"
                                                                   title="{{ __('comment.like') }}"
                                                                   @click="Like(item)"> <i
                                                                        :style="[isLiked(item.likes_and_dislikes) ? {'color' : 'red' } : '']"
                                                                        class="fa fa-thumbs-up Likes_And_Dislikes_Cursor  like_and_disLikeFont"></i>
                                                                </a>
                                                                <span
                                                                    v-text="GetLikesCount(item.likes_and_dislikes)"></span>
                                                            </div>

                                                            <span class="pull-left">&nbsp &nbsp</span>

                                                            <div class="pull-left">
                                                                <a id="dislike" data-toggle="tooltip"
                                                                   data-placement="top"
                                                                   title="{{ __('comment.dislike') }}"
                                                                   @click="DisLike(item)"> <i
                                                                        :style="[isDisLiked(item.likes_and_dislikes) ? {'color' : 'red' } : '']"
                                                                        class="fa fa-thumbs-down Likes_And_Dislikes_Cursor  like_and_disLikeFont"></i>
                                                                </a>
                                                                <span
                                                                    v-text="GetDisLikesCount(item.likes_and_dislikes)"></span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-6">
                                                        @if(config('comment.options.Has_Reply') &&  (auth()->check() || config('comment.options.ALLOW_ANONYMOUS_Comment')))
                                                            <a v-if="item.answer === null"
                                                               class="btn btn-info btn-circle text-uppercase"
                                                               @click="Answer(item)"
                                                               href="#add-comment" role="tab" data-toggle="tab"
                                                            ><span
                                                                    class="glyphicon glyphicon-share-alt"></span> {{ __('comment.Reply') }}
                                                            </a>
                                                        @endif

                                                        @if(auth()->check() && config('comment.options.Has_Edit'))
                                                            <a v-if="isForYou(item.user)"
                                                               @click="Edit(item)"
                                                               href="#add-comment" role="tab" data-toggle="tab"
                                                               class="btn btn-primary btn-circle text-uppercase"
                                                               id="reply"><span
                                                                    class="glyphicon glyphicon-edit"></span> {{ __('comment.Edit') }}
                                                            </a>
                                                        @endif

                                                        @if(auth()->check() && config('comment.options.Allow_Delete_Comment'))
                                                            <a v-if="isForYou(item.user)"
                                                               @click="Delete(item)"
                                                               class="btn btn-danger btn-circle text-uppercase"><span
                                                                    class="glyphicon glyphicon-trash"></span> {{ __('comment.Delete') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div v-if="item.answer !== null" id="replyOne"
                                             style="margin-right: 30px !important;">
                                            <ul class="media-list">
                                                <li class="media media-replied">
                                                    <a class="pull-right" href="#">
                                                        <img class="media-object img-circle image"
                                                             :src="ShowImage(item.answer.user)"
                                                             alt="profile">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="well well-lg">
                                                            <h4 class="media-heading text-uppercase reviews"><span
                                                                    class="glyphicon glyphicon-user"></span>
                                                                @{{ DisplayUserName(item.answer.user) }}
                                                            </h4>

                                                            <span>&nbsp &nbsp</span>

                                                            <ul class="media-date text-uppercase reviews list-inline">
                                                                @{{ item.answer.created_at }}
                                                            </ul>
                                                            <h3 class="media-comment">
                                                                @{{ item.answer.title }}
                                                            </h3>

                                                            <br>

                                                            @if(config('comment.options.Editor') !== 3)
                                                                <p class="media-comment" v-html="item.answer.content">

                                                                </p>
                                                            @else
                                                                <p class="media-comment" v-text="item.answer.content">

                                                                </p>

                                                            @endif

                                                            <div class="col-12 row"
                                                                 style="margin-top: 5% !important;">

                                                                @if(auth()->check() && config('comment.options.Has_Like_And_DisLike'))
                                                                    <div class="col-6">
                                                                        <div class="pull-left">
                                                                            <a id="like" data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="{{ __('comment.like') }}"
                                                                               @click="Like(item.answer)"> <i
                                                                                    :style="[isLiked(item.answer.likes_and_dislikes) ? {'color' : 'red' } : '']"
                                                                                    class="fa fa-thumbs-up Likes_And_Dislikes_Cursor  like_and_disLikeFont"></i>
                                                                            </a>
                                                                            <span
                                                                                v-text="GetLikesCount(item.answer.likes_and_dislikes)"></span>
                                                                        </div>

                                                                        <span class="pull-left">&nbsp &nbsp</span>

                                                                        <div class="pull-left">
                                                                            <a id="dislike" data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="{{ __('comment.dislike') }}"
                                                                               @click="DisLike(item.answer)"> <i
                                                                                    :style="[isDisLiked(item.answer.likes_and_dislikes) ? {'color' : 'red' } : '']"
                                                                                    class="fa fa-thumbs-down Likes_And_Dislikes_Cursor  like_and_disLikeFont"></i>
                                                                            </a>
                                                                            <span
                                                                                v-text="GetDisLikesCount(item.answer.likes_and_dislikes)"></span>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="col-6">
                                                                    @if(auth()->check() && config('comment.options.Has_Edit'))
                                                                        <a v-if="isForYou(item.answer.user)"
                                                                           @click="Edit(item.answer)"
                                                                           href="#add-comment" role="tab"
                                                                           data-toggle="tab"
                                                                           class="btn btn-primary btn-circle text-uppercase"
                                                                           id="reply"><span
                                                                                class="glyphicon glyphicon-edit"></span> {{ __('comment.Edit') }}
                                                                        </a>

                                                                        @if(auth()->check() && config('comment.options.Allow_Delete_Comment'))
                                                                            <a v-if="isForYou(item.answer.user)"
                                                                               @click="Delete(item.answer)"
                                                                               class="btn btn-danger btn-circle text-uppercase"><span
                                                                                    class="glyphicon glyphicon-trash"></span> {{ __('comment.Delete') }}
                                                                            </a>
                                                                        @endif

                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>


                                    @if(config('comment.options.Pagination') == 1)
                                        <div v-if="comments['last_page'] > 1" dir="ltr">
                                            <ul class="page">
                                                <li @click=" comments['prev_page_url']  ?  GetAllComments(comments['current_page'] - 1)  :  '' "
                                                    :class=" comments['prev_page_url'] == null ?  'disabled'  : 'page__btn' ">
                                                    <span class="material-icons">chevron_left</span>
                                                </li>
                                                <li @click="GetAllComments(page)"
                                                    v-for="page in comments['last_page']"
                                                    :class="[page === comments['current_page'] ? 'active' : '' , 'page__numbers']">
                                                    @{{ page }}
                                                </li>

                                                <li @click=" comments['next_page_url']  ?  GetAllComments(comments['current_page'] + 1)  : '' "
                                                    :class=" comments['next_page_url'] == null ?  'disabled'  : 'page__btn' ">
                                                    <span class="material-icons">chevron_right</span>
                                                </li>
                                            </ul>
                                        </div>

                                    @elseif(config('comment.options.Pagination') == 2)
                                        <nav v-if="comments['last_page'] > 1" class="text-center" aria-label="...">
                                            <ul class="pagination">
                                                <li @click=" comments['prev_page_url']  ?  GetAllComments(comments['current_page'] - 1)  :  '' "
                                                    :class="comments['prev_page_url'] == null ?  'disabled'  : 'pagination_cursor' ">
                                                    <a aria-label="Previous"><span aria-hidden="true">&raquo;</span></a>
                                                </li>

                                                <li @click="GetAllComments(page)" v-for="page in comments['last_page']"
                                                    :class="[page === comments['current_page'] ? 'active' : '' , 'pagination_cursor']">
                                                    <a> @{{ page }} <span class="sr-only">(current)</span></a></li>

                                                <li @click=" comments['next_page_url']  ?  GetAllComments(comments['current_page'] + 1)  : '' "
                                                    :class="comments['next_page_url'] == null ?  'disabled'  : 'pagination_cursor' ">
                                                    <a aria-label="Next"><span aria-hidden="true">&laquo;</span></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    @endif


                                </div>

                                <h4 class="text-center text-danger"
                                    v-else> {{ __('comment.No Comment have been commented yet!') }} </h4>

                            </ul>
                        </div>


                        <div class="tab-pane" id="add-comment">
                            <div class="row" style="margin: 2%">
                                <div class="card container col-md-12" dir="rtl">
                                    <div class="card-body">
                                        <div class="row">
                                            @if(auth()->check() || config('comment.options.ALLOW_ANONYMOUS_Comment'))
                                                <div>
                                                    <form @submit.prevent="Submit()" method="post" id="form">

                                                        <div class="form-group">
                                                            <label class="mb-2"> {{ __('comment.title') }} </label>
                                                            <input v-model="title"
                                                                   required
                                                                   class="form-control input-block-level" type="text"
                                                                   name="title">
                                                        </div>

                                                        <!-- /row -->
                                                        <div class="form-group">
                                                            <label class="mb-2"> {{ __('comment.content') }} </label>

                                                            @if(config('comment.options.Editor') == 1)

                                                                <ckeditor v-model="content"></ckeditor>

                                                            @elseif(config('comment.options.Editor') == 2)

                                                                <br>
                                                                <w-tinymce-vue
                                                                    style="width: 100%"
                                                                    :settings="TinyMCE_settings"
                                                                    v-model="content"
                                                                ></w-tinymce-vue>

                                                            @else

                                                                <textarea id="content" v-model="content"
                                                                          required
                                                                          class="form-control"
                                                                          rows="10"></textarea>

                                                            @endif

                                                        </div>

                                                        @if(config('comment.options.Captcha'))
                                                            <div class="row" style="margin-top: 60px !important;">
                                                                <div class="form-group mb-4 col-lg-4 pull-right">
                                                                    <div class="captcha">
                                                                        <span>{!! captcha_img() !!}</span>
                                                                        <button @click="ReloadCaptcha()" type="button"
                                                                                class="btn btn-primary" class="reload"
                                                                                id="reload">
                                                                            &#x21bb;
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-lg-8">
                                                                    <input v-model="captcha" required type="text"
                                                                           class="form-control" name="captcha">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <button class="btn btn-info btn-circle text-uppercase pull-left"
                                                                type="submit"><span
                                                                class="glyphicon glyphicon-edit"></span>

                                                            @{{ ButtonText() }}

                                                        </button>

                                                        <span class="pull-left">&nbsp &nbsp</span>

                                                        <button id="BackButton"
                                                                v-if="type === 'edit' || type === 'answer'"
                                                                @click="SwitchToCreate()"
                                                                href="#comments-list" role="tab"
                                                                data-toggle="tab"
                                                                class="btn btn-danger btn-circle text-uppercase pull-left"><span
                                                                class="glyphicon glyphicon-remove-sign"></span> {{ __('comment.Back') }}
                                                        </button>

                                                    </form>
                                                </div>
                                            @else
                                                <div>
                                                    <div class="alert alert-info text-center" style="font-size: 15px;">
                                                        @if(app()->getLocale() == 'fa')
                                                            برای ثبت نظر جدید ابتدا باید <a href="/login"> وارد </a>
                                                            شوید
                                                        @else
                                                            You must <a href="/login"> LOGIN </a> to post a new comment
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- /row -->
                                    </div>
                                    <!-- /container -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--############################################################################################################################--}}

<script>

    Vue.use(VueLoading);
    Vue.component('loading', VueLoading)

    @if(config('comment.options.Editor') == 1)
    Vue.component('ckeditor', VueCkeditor)
    @elseif(config('comment.options.Editor') == 2)
    Vue.component('w-tinymce-vue', window['w-tinymce-vue'])
    @endif

    new Vue({
        el: "#app",
        data() {
            return {
                TinyMCE_settings: {
                    menubar: '',
                    plugins: '',
                    directionality: "rtl",
                    toolbar: 'fontsizeselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    fontsize_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
                },

                base_url: '',
                current_page: 1,

                title: '',
                content: '',
                captcha: '',
                model_name: '',
                commentable_id: 0,
                parent_id: null,

                comment_id: null,
                type: 'create',

                loading: null,
                EnabledShowLoading: false,

                comments: [],

                results: [],

                search_word : ''
            }
        },

        methods: {
            ShowLoading() {
                if (this.EnabledShowLoading) {
                    this.loading = this.$loading.show({
                        container: this.$refs.loadingContainer,
                        color: '#077BFF',
                        loader: 'spinner',
                        width: 64,
                        height: 64,
                        backgroundColor: '#ffffff',
                        opacity: 0.5,
                        zIndex: 999,
                    },);
                }
            },

            HideLoading() {
                if (this.EnabledShowLoading) {
                    this.loading.hide()
                }
            },

            ButtonText() {
                if (this.type === 'create') {
                    return '{{ __('comment.Submit Comment') }}'
                } else if (this.type === 'edit') {
                    return '{{ __('comment.Edit') }}'
                }

                return '{{ __('comment.Answer Comment') }}'
            },

            DisplayUserName(user) {
                if (user) {
                    return user.{{ config('comment.options.Commenter Display Name Field') }}
                }
                return '{{ __('comment.Anonymous') }}'
            },

            Like(item) {
                const app = this

                const formData = new FormData()
                formData.append('id', item.id)

                axios.post(app.base_url + '/comments/like_dislike/like', formData)
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.GetAllComments(app.current_page)
                        }
                    })
            },

            DisLike(item) {
                const app = this

                const formData = new FormData()
                formData.append('id', item.id)

                axios.post(app.base_url + '/comments/like_dislike/dislike', formData)
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.GetAllComments(app.current_page)
                        }
                    })
            },

            isLiked(likes_and_dislikes) {
                if (likes_and_dislikes !== null && likes_and_dislikes !== undefined) {
                    const result = likes_and_dislikes.filter(like => like.type === 'like' && like.user_id === {{ auth()->check() ? auth()->user()->id : 'null' }});
                    if (result.length > 0) {
                        return true
                    }
                }

                return false
            },

            isDisLiked(likes_and_dislikes) {
                if (likes_and_dislikes !== null && likes_and_dislikes !== undefined) {
                    const result = likes_and_dislikes.filter(like => like.type === 'dislike' && like.user_id === {{ auth()->check() ? auth()->user()->id : 'null' }});
                    if (result.length > 0) {
                        return true
                    }
                }

                return false
            },

            GetLikesCount(likes_and_dislikes) {
                if (likes_and_dislikes !== null && likes_and_dislikes !== undefined) {
                    const result = likes_and_dislikes.filter(like => like.type === 'like');
                    return result.length
                }

                return 0
            },

            GetDisLikesCount(likes_and_dislikes) {
                if (likes_and_dislikes !== null && likes_and_dislikes !== undefined) {
                    const result = likes_and_dislikes.filter(like => like.type === 'dislike');
                    return result.length
                }

                return 0
            },

            showNotify(message) {
                Swal.fire({
                    title: "{{ __('comment.Congratulations') }} ! 🥳",
                    icon: 'success',
                    text: message,
                    type: "success",
                    cancelButtonColor: 'var(--primary)',
                    confirmButtonText: "{{ __('comment.OK') }}",
                })
            },

            showErrorToast(error) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": false,
                    "showDuration": "2000",
                    "hideDuration": "500",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.error(error);

                this.ReloadCaptcha()
            },

            SetRequirements() {
                this.ReloadCaptcha()
                this.type = 'create'
                this.commentable_id = {{ $obj->id }}
                    this.model_name = '{{ str_replace('\\' , '/' , get_class($obj)) }}'
                this.EnabledShowLoading = {{ config('comment.options.Loading') ? 'true' : 'false' }}
                    this.base_url = '{{ config('comment.Base_Url') }}'
            },

            AddStyle(item) {
                result = false

                @if(!config('comment.options.Has_Edit') && !config('comment.options.Has_Reply'))
                    result = true
                @endif

                if (result !== true && item.answer !== null) {
                    result = true
                }

                return result
            },

            isForYou(user) {

                if (user !== null && user.id === {{ auth()->check() ? auth()->user()->id : 'null' }}) {
                    return true
                }

                return false
            },

            ShowImage(user) {
                if (user !== null) {
                    if ('profile_photo' in user && user['profile_photo'] !== null) {
                        return user['profile_photo']
                    }

                    if ('image' in user && user['image'] !== null) {
                        return user['image']
                    }

                    if ('img' in user && user['img'] !== null) {
                        return user['img']
                    }
                }

                return '{{ config('comment.Default_Image') }}'
            },

            Submit() {

                if (this.type === 'create') {
                    this.Create()
                } else if (this.type === 'edit') {
                    this.Update()
                } else {
                    this.SubmitAnswer()
                }

            },

            SwitchToCreate() {
                this.title = this.content = this.captcha = ''
                this.type = 'create'
            },

            Answer(parent) {
                this.type = 'answer'
                this.parent_id = parent.id
            },

            SubmitAnswer() {
                const app = this

                this.ShowLoading()

                axios.post(app.base_url + '/comments/answer/' + app.parent_id, {
                    'title': JSON.stringify(app.title),
                    'content': JSON.stringify(app.content),
                    'captcha': JSON.stringify(app.captcha),
                    'commentable_id': JSON.stringify(app.commentable_id),
                    'model': JSON.stringify(app.model_name),

                    'parent_id': JSON.stringify(app.parent_id),
                })
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.showNotify(response.data.message)
                            app.GetAllComments(app.current_page)

                            $("#BackButton").click()
                            app.SetRequirements()

                        } else {
                            app.showErrorToast(response.data.error)
                        }
                    }).finally(function () {
                    app.HideLoading()
                })
            },

            Edit(comment) {
                this.type = 'edit'

                this.comment_id = comment.id
                this.title = comment.title
                this.content = comment.content
            },

            Update() {
                const app = this

                this.ShowLoading()

                axios.post(app.base_url + '/comments/' + app.comment_id, {
                    'title': JSON.stringify(app.title),
                    'content': JSON.stringify(app.content),
                    'captcha': JSON.stringify(app.captcha),
                    'type': JSON.stringify(app.type),

                    '_method': 'PATCH'
                })
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.showNotify(response.data.message)
                            app.GetAllComments(app.current_page)
                            app.content = app.title = app.captcha = ''

                            $("#BackButton").click()
                            app.SetRequirements()

                        } else {
                            app.showErrorToast(response.data.error)
                        }
                    }).finally(function () {
                    app.HideLoading()
                })
            },

            Delete(item) {

                Swal.fire({

                    title: '{{ __('comment.?Are you sure') }}',
                    text: '{{ __('comment.You can not revert your action') }}',
                    type: 'warning',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: '{{ __('comment.!Yes Delete it') }}',
                    cancelButtonText: '{{ __('comment.!No, Keep it') }}',
                    showCloseButton: true,
                    showLoaderOnConfirm: true

                }).then((result) => {
                    if (result.value) {

                        this.SubmitDelete(item.id)

                    }
                })
            },

            SubmitDelete(id) {
                const app = this

                if (this.current_page === this.comments['last_page'] && this.comments['length'] === 1) {
                    this.current_page = this.current_page - 1
                }

                this.ShowLoading()

                axios.delete(app.base_url + '/comments/' + id)
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.showNotify(response.data.message)
                            app.GetAllComments(app.current_page)

                            app.SetRequirements()
                        }
                    }).finally(function () {
                    app.HideLoading()
                })
            },

            Create() {

                const app = this

                this.ShowLoading()

                axios.post(app.base_url + '/comments', {
                    'title': JSON.stringify(app.title),
                    'content': JSON.stringify(app.content),
                    'captcha': JSON.stringify(app.captcha),
                    'commentable_id': JSON.stringify(app.commentable_id),
                    'parent_id': JSON.stringify(app.parent_id),

                    'model': JSON.stringify(app.model_name),
                })
                    .then(function (response) {
                        if (response.data.status === 'OK') {
                            app.showNotify(response.data.message)
                            app.GetAllComments(app.current_page)
                            app.title = app.content = app.captcha = ''

                            app.SetRequirements()
                        } else {
                            app.showErrorToast(response.data.error)
                        }
                    }).finally(function () {
                    app.HideLoading()
                })
            },

            GetAllComments(page = 1) {
                const app = this

                this.current_page = page

                if (this.search_word)
                {
                    axios.get(app.base_url + '/comments?page=' + page + '&search=' + app.search_word)
                        .then(function (response) {
                            if (response.data.status === 'OK') {
                                app.comments = response.data.comments
                                app.comments['length'] = app.comments.data.length
                            }
                        })
                }
                else
                {
                    axios.get(app.base_url + '/comments?page=' + page)
                        .then(function (response) {
                            if (response.data.status === 'OK') {
                                app.comments = response.data.comments
                                app.comments['length'] = app.comments.data.length
                            }
                        })
                }
            },

            ReloadCaptcha() {
                const app = this

                axios.get(app.base_url + '/reload_captcha')
                    .then(function (response) {
                        $(".captcha span").html(response.data.captcha);
                    })
            }
        },

        mounted() {
            this.SetRequirements()
            this.GetAllComments()
        }
    })


</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
