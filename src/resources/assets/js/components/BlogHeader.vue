 <template>
    <div>
        <header class="row flex-bottom">
            <div class='nav-left'>
                <a :href="$store.state.api_routes.home"></a>
            </div>
            <div class='nav-right'>
                <at-button v-if="isLoggedIn" type="success" hollow @click="openBlogEntryModal()">Add new entry</at-button>
                <at-button v-if="isLoggedIn" type="error" hollow @click="handleLogout">Logout</at-button>
                <at-button v-else type="info" hollow @click="openLoginModal()">Login</at-button>
            </div>
        </header>
    </div>
</template>

<script>

    export default
    {
        data()
        {
            return {
                login:
                {
                    name: null,
                    password: null
                },
            }
        },

        created()
        {
            this.$Loading.config({width: 3})
        },

        methods:
        {
            openLoginModal()
            {
                this.$store.commit('set_login_modal', true)
            },

            openBlogEntryModal()
            {
                this.$store.commit('set_blog_entry_modal', true)
            },

            handleLogout()
            {
                this.$Loading.start();

                axios.get(this.$store.state.api_routes.logout)
                .then((token) =>
                {
                    this.$store.commit('set_user_data', null)
                    this.$Message.success('You have been logged out')
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.data
                })
                .finally(() =>
                {
                    this.$Loading.finish();
                });
            },
        }
    }
</script>

