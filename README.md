## PreView

![Blazar](src/assets/Documention/Comment3.png?raw=true "Screenshot")


# Bilingual Comment Laravel Package
( Made with Laravel Blade(bootstrap) And VUE JS )

Free Bilingual Comment Package For having a complte comment part in your project with a FRONTED SIDE.

## Installation and  Dependencies
```bash
composer require ashkan/comment
```

Publish Package
```bash
php artisan vendor:publish --provider="Ashkan\Comment\CommentServiceProvider"
php artisan migrate
```

Set requirements

```bash
Add  'use HasComments;' to COMMENTER model like 'User'


use Ashkan\Comment\Traits\CanComment;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    # important
    use CanComment;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
```

```bash
Add  'use HasCommentable;' to COMMENTABLE model like 'Post , Article ,...'


use Ashkan\Comment\Traits\HasComments;

class Post extends Model
{
    use HasFactory;
    
    # important
    use HasComments;

    protected $fillable = [
        ...
    ];
}
```

&nbsp;
&nbsp;
&nbsp;

## Usage

To use this package, render this line in your codes and you should pass your model_object( Post , Article , Course ... ) into the parameters of this line of code
### Example : 
```bash
@include('comment.partials.Comment' , ['obj' => $article])
```
### You can use 'Comment' model in where ever you want:
```bash
use Ashkan\Comment\Models\Comment;
use Ashkan\Comment\Models\Likes_And_DisLikes;

Comment::create();
Comment::all();
Comment::paginate(10);
,...

Likes_And_DisLikes::create();
Likes_And_DisLikes::all();
Likes_And_DisLikes::paginate(10);
,...
```

### Or use methods of 'CommentFacade' and 'LikeDisLikeFacade' (see methods of facades in repository classes):
```bash
Ashkan\Comment\Repositories\CommentRepository
Ashkan\Comment\Repositories\LikeDisLikeRepository
```

&nbsp;
&nbsp;
&nbsp;

\
&nbsp;
\
&nbsp;

## Customize Package & Config ( Config and Options of Package with your own dependencies )

You can customize options and events of package in **'comment.php'** in **'config'** folder
### Example :
**to change Editor of 'textarea' you can select your favorite option :**
```bash
return [
            #  Editor Options :
                        #      1 => 'CKEDITOR' (Default)
                        #      2 => 'Tiny MCE'
                        #      3 => 'Without Editor'   ( simple textarea )
        'Editor' => 1,
        
      ]
```

**to enable or disable 'like and dislike' or 'loading' or 'pagination' you can change :**
```bash
return [
        'Has_Like_And_DisLike' => true,

        'Loading' => true,

             #  Pagination Options :
                        #      1 => 'Material Icons' (Default)
                        #      2 => 'Bootstrap'
                        #      3 => 'Without Pagination'      
        'Pagination' => 1,
        'PaginationDefaultNumber' => 8,
        
        
     ]
```

**to change timezone of datetime (Example 'Persian') :**
```bash
set 'timezone' in 'config/app.php' to 'Asia/Tehran'
```

**to customize theme (card and form and functions) , you can change them in 'resources/views/comment' files :**
```bash
           
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
                        
      ##########################################################################################################################################
                        
                        
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

                comment_id: null,
                type: 'create',

                loading: null,
                EnabledShowLoading: false,

                comments: [],

                results: [],
            }
        },

        methods: {
          
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
            
            , ...
        }
    })
       
```

## Screens UI
**Cards**

![Alt text](src/assets/Documention/Comment.png?raw=true "Screenshot")

**Forms**

![Alt text](src/assets/Documention/Comment2.png?raw=true "Screenshot")

### Contact us
- Instagram : https://www.instagram.com/ashkann_k &nbsp;  |  &nbsp; ashkann_k
- Telegram : https://t.me/ashk@n_k &nbsp;  |  &nbsp; @ashk@n_k
