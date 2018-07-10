<template>
    <section>
        <div style="padding: 2rem 1rem" class="row">
            <at-timeline v-if="items.length">
                <at-timeline-item-extended v-for="item in items" :lastItem="item.placeholder" :key="item._id">
                    <div v-if="!item.placeholder">
                        <h6>{{ item.created_at }} by {{ item.author_name }}</h6>
                        <at-card style="width: 100%" :body-style="{ padding: 0 }">
                            <div slot="extra">
                                <a v-if="isLoggedIn" :class="(item.is_published ? 'danger' : '')" @click="toggleEntryPublish(item)">{{ item.is_published ? 'Unpublish' : 'Publish' }}</a>
                                <a v-if="isLoggedIn" class='danger blog-delete' @click="deleteBlogEntry(item)">Delete</a>
                            </div>
                            <div style="padding: 0.8rem;">
                                <h5>{{ item.title }}</h5>
                                <p v-html="item.content"></p>
                            </div>
                        </at-card>
                    </div>

                    <i v-if="!item.placeholder" slot="dot" class="icon icon-chevron-down"></i>
                    <i v-else slot="dot" class="icon icon-stop-circle"></i>
                </at-timeline-item-extended>
            </at-timeline>
        </div>

        <infinite-loading @infinite="infiniteHandler" ref="loader">
            <div class='row flex-center' style="margin-bottom: 4rem" slot="spinner"><div class="dizzy-gillespie"></div></div>
            <div slot="no-more"><!-- Nothing --></div>
        </infinite-loading>

        <at-modal-extended v-model="m_visible" title="Add new post" width="800" :mask-closable="false" ref="add_blog_post_box" @on-confirm="addBlogEntry">
            <at-input v-model="blog_entry.title" :max="255" placeholder='Title'></at-input>
            <at-textarea v-model="blog_entry.content" placeholder='Lorem ipsum...' :minRows="12"></at-textarea>
            <at-checkbox v-model="blog_entry.is_published" label="published">published</at-checkbox>
        </at-modal-extended>
    </section>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

    export default
    {
        data()
        {
            return {
                items: [],
                page: 1,
                all_entries_fetched: false,
                blog_entry:
                {
                    title: null,
                    content: null,
                    is_published: null,
                }
            };
        },

        computed:
        {
            m_visible:
            {
                get() { return this.$store.state.blog_entry_modal_visible },
                set(v) { return this.$store.commit('set_blog_entry_modal', v) }
            }
        },

        methods:
        {
            toggleEntryPublish(entry)
            {
                entry.is_published = !entry.is_published

                this.$Loading.start()

                axios.put(this.$store.state.api_routes.blog_entry + '/' + entry._id, entry)
                .then((response) =>
                {
                    this.$Message.success('Blog post ' + entry.title + ' has been ' + (entry.is_published ? 'published' : 'unpublished'))
                })
                .catch((err) =>
                {
                    this.$Message.error('Something went wrong')
                    entry.is_published = !entry.is_published
                })
                .finally(() =>
                {
                    this.$Loading.finish()
                })
            },

            deleteBlogEntry(entry)
            {
                this.$Modal.confirm({
                    title: 'Confirmation',
                    content: 'Are you sure you want to do delete ' + entry.title + '?'
                }).then(() =>
                {
                    this.$Loading.start()

                    axios.delete(this.$store.state.api_routes.blog_entry + '/' + entry._id)
                    .then((response) =>
                    {
                        this.$Message.success('Blog post removed')
                        this.reset()
                    })
                    .catch((err) =>
                    {
                        this.$Message.error('Something went wrong')
                    })
                    .finally(() =>
                    {
                        this.$Loading.finish()
                    })
                })
            },

            validateAddBlogEntry()
            {
                if(!this.blog_entry.content)
                {
                    this.$Message.error('Blog post content must not be empty')
                    return false;
                }

                if(!this.blog_entry.title)
                {
                    this.$Message.error('Blog post title must not be empty')
                    return false;
                }

                return true;
            },

            addBlogEntry()
            {
                if(!this.validateAddBlogEntry()) return;

                this.$refs.add_blog_post_box.doClose()
                this.$Loading.start()

                axios.post(this.$store.state.api_routes.blog_entry, this.blog_entry)
                .then((data) =>
                {
                    this.$Message.success('Blog entry added')
                    this.reset()
                })
                .catch((err) =>
                {
                    this.$Message.error('Something went wrong')
                })
                .finally(() =>
                {
                    this.$Loading.finish()
                })
            },

            reset()
            {
                this.blog_entry.title        = null
                this.blog_entry.content      = null
                this.blog_entry.is_published = null
                this.items                   = []
                this.page                    = 1
                this.all_entries_fetched     = false

                this.$nextTick(() =>
                {
                    this.$refs.loader.$emit('$InfiniteLoading:reset');
                });
            },

            fetchBlogEntries($state)
            {
                axios.get(this.$store.state.api_routes.blog_entry + '?page=' + this.page++)
                .then(({data}) =>
                {
                    this.items = this.items.concat(data.data)

                    if(data.length == 0 || data.to >= data.total)
                    {
                        this.all_entries_fetched = true
                        this.items = this.items.concat([{placeholder: true}])
                    }

                    $state.loaded()
                })
            },

            infiniteHandler($state)
            {
                if(this.all_entries_fetched)
                {
                    $state.complete()
                }
                else
                {
                    setTimeout(() =>
                    {
                        this.fetchBlogEntries($state)
                    }, 500)
                }
            },
        },

        components:
        {
            InfiniteLoading
        },
    }
</script>
