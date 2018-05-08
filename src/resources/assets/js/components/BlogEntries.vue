<template>
    <section>
        <div style="padding: 2rem 1rem" class="row">
            <at-timeline v-if="items.length">
                <at-timeline-item-extended v-for="item in items" :lastItem="item.placeholder" :key="item._id">
                    <div v-if="!item.placeholder">
                        <h6>{{ item.created_at }} by {{ item.author_name }}</h6>
                        <at-card style="width: 100%" :body-style="{ padding: 0 }">
                            <div slot="extra">
                                <a>Edit</a>
                                <a class='blog-delete' @click="deleteBlogEntry(item)">Delete</a>
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
    </section>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import { EventBus } from '../event-bus.js';

    export default
    {
        props: ['route_get_entries', 'route_delete_entry'],

        data()
        {
            return {
                items: [],
                page: 1,
                all_entries_fetched: false,
            };
        },

        mounted()
        {
            EventBus.$on('reloadEntries', () =>
            {
                this.items = [];
                this.all_entries_fetched = false;
                this.page = 1;
                this.$refs.loader.stateChanger.reset();
            });
        },

        methods:
        {
            deleteBlogEntry(entry)
            {
                this.$Modal.confirm({
                    title: 'Confirmation',
                    content: 'Are you sure you want to do delete ' + entry.title + '?'
                }).then(() =>
                {
                    this.$Loading.start();

                    axios.get(this.route_delete_entry + '/' + entry._id)
                    .then((response) =>
                    {
                        EventBus.$emit('reloadEntries');
                        this.$Message.success('Blog post removed');
                    })
                    .catch((err) =>
                    {
                        this.$Message.error('Something went wrong');
                    })
                    .finally(() =>
                    {
                        this.$Loading.finish();
                    });
                });
            },

            fetchBlogEntries($state)
            {
                axios.get(this.route_get_entries + '?page=' + this.page++)
                .then((response) =>
                {
                    this.items = this.items.concat(response.data.data);

                    if(response.data.length == 0 || response.data.to >= response.data.total)
                    {
                        this.all_entries_fetched = true;
                        this.items = this.items.concat([{placeholder: true}]);
                    }

                    $state.loaded();
                });
            },

            infiniteHandler($state)
            {
                if(this.all_entries_fetched)
                {
                    $state.complete();
                }
                else
                {
                    setTimeout(() =>
                    {
                        this.fetchBlogEntries($state);
                    }, 1000);
                }
            },
        },

        components:
        {
            InfiniteLoading
        },
    }
</script>
