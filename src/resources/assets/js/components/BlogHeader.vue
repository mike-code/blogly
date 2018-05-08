 <template>
    <div>
        <header class="row flex-bottom">
            <div class='nav-left'>
                <a :href="route_home"></a>
            </div>
            <div class='nav-right'>
                <at-button v-if="isLoggedIn" type="success" hollow @click="blogEntryModal=true">Add new entry</at-button>
                <at-button v-if="isLoggedIn" type="error" hollow @click="handleLogout">Logout</at-button>
                <at-button v-else type="info" hollow @click="openLoginModal()">Login</at-button>
            </div>
        </header>

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
        props: ['route_home', 'route_logout', 'is_loggedin', 'login_modal', 'route_add_blog_entry', 'blog_entries'],

        data()
        {
            return {
                blogEntryModal: null,
                isLoggedIn: this.is_loggedin,
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

        watch:
        {
            is_loggedin(v)
            {
                this.isLoggedIn = v;
            }
        },

        created()
        {
            this.$Loading.config({width: 3});
        },

        methods:
        {
            openLoginModal()
            {
                this.$emit('update:login_modal', true);
            },

            handleLogout()
            {
                this.$Loading.start();

                axios.get(this.route_logout)
                .then((token) =>
                {
                    this.$Message.success('You have been logged out');
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.data;
                    this.$emit('update:is_loggedin', false);
                })
                .finally(() =>
                {
                    this.$Loading.finish();
                });
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

            reset()
            {
                this.blog_entry.title        = null;
                this.blog_entry.content      = null;
                this.blog_entry.is_published = null;
            }
        }
    }
</script>

