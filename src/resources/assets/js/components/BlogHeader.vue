 <template>
    <div>
        <header class="row flex-bottom">
            <div class='nav-left'>
                <a :href="route_home"></a>
            </div>
            <div class='nav-right'>
                <at-button v-if="user_loggedin" type="success" hollow @click="blogEntryModal=true">Add new entry</at-button>
                <at-button v-if="user_loggedin" type="error" hollow @click="handleLogout">Logout</at-button>
                <at-button v-else type="info" hollow @click="loginModal=true">Login</at-button>
            </div>
        </header>

        <at-modal-extended v-model="loginModal" title="Please sign in" @on-confirm="handleLogin" ref="login_box" @on-show="handleLoginboxShow">
            <at-input v-model="login.name" placeholder='username' @keyup.enter.native="loginKeypress()" ref='login_input_name'></at-input>
            <at-input v-model="login.password" type='password' placeholder='password' @keyup.enter.native="loginKeypress()"></at-input>
        </at-modal-extended>

        <at-modal-extended v-model="blogEntryModal" title="Add new post" width="800" :mask-closable="false" ref="add_blog_post_box" @on-confirm="handleAddBlogEntry">
            <at-input v-model="blog_entry.title" :max="255" placeholder='Title'></at-input>
            <!-- <wysiwyg v-model="blog_entry.content" /> -->
            <at-textarea v-model="blog_entry.content" placeholder='Lorem ipsum...' :minRows="12"></at-textarea>
            <at-checkbox v-model="blog_entry.is_published" label="published">published</at-checkbox>
        </at-modal-extended>
    </div>
</template>

<script>
    import { EventBus } from '../event-bus.js';

    export default
    {
        props: ['route_home', 'route_login', 'route_logout', 'route_add_blog_entry', 'user_loggedin', 'blog_entries'],

        data()
        {
            return {
                loginModal: null,
                blogEntryModal: null,
                login:
                {
                    name: null,
                    password: null
                },
                blog_entry:
                {
                    title: null,
                    content: null,
                    is_published: null
                }
            };
        },

        created()
        {
            this.$Loading.config({width: 3});
        },

        methods:
        {
            loginKeypress()
            {
                this.$refs.login_box.handleAction('confirm');
            },

            handleLoginboxShow(el)
            {
                this.$nextTick(() => this.$refs.login_input_name.$el.querySelector('input').focus());
            },

            validateAddBlogEntry()
            {
                if(!this.blog_entry.content)
                {
                    this.$Message.error('Blog post content must not be empty');
                    return false;
                }

                if(!this.blog_entry.title)
                {
                    this.$Message.error('Blog post title must not be empty');
                    return false;
                }

                return true;
            },

            handleAddBlogEntry()
            {
                if(!this.validateAddBlogEntry()) return;

                this.$refs.add_blog_post_box.doClose();
                this.$Loading.start();

                axios.post(this.route_add_blog_entry, this.blog_entry)
                .then((data) =>
                {
                    this.$Message.success('Blog entry added');
                    this.reset();
                    EventBus.$emit('reloadEntries');
                })
                .catch((err) =>
                {
                    this.$Message.error('Something went wrong');
                })
                .finally(() =>
                {
                    this.$Loading.finish();
                });
            },

            handleLogin()
            {
                this.$Loading.start();

                axios.post(this.route_login, this.login)
                .then((data) =>
                {
                    this.$Message.success('You are now logged in');
                    this.user_loggedin = true;
                })
                .catch((err) =>
                {
                    this.$Message.error('Wrong credentials');
                    this.user_loggedin = false;
                })
                .finally(() =>
                {
                    this.$Loading.finish();
                    this.reset();
                });

            },

            handleLogout()
            {
                this.$Loading.start();

                axios.get(this.route_logout)
                .then((token) =>
                {
                    this.$Message.success('You have been logged out');
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.data;
                    this.user_loggedin = false;
                })
                .finally(() =>
                {
                    this.$Loading.finish();
                });
            },

            reset()
            {
                this.login.name              = null;
                this.login.password          = null;
                this.blog_entry.title        = null;
                this.blog_entry.content      = null;
                this.blog_entry.is_published = null;
            }
        }
    }
</script>

