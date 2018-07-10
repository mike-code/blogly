 <template>
     <at-modal-extended v-model="m_visible" title="Please sign in" @on-confirm="handleLogin" ref="login_box" @on-show="handleLoginboxShow">
        <at-input v-model="login.name" placeholder='username' @keyup.enter.native="loginKeypress()" ref='login_input_name'></at-input>
        <at-input v-model="login.password" placeholder='password' @keyup.enter.native="loginKeypress()" type='password'></at-input>
    </at-modal-extended>
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
        };
    },

    computed:
    {
        m_visible:
        {
            get() { return this.$store.state.login_modal_visible },
            set(v) { return this.$store.commit('set_login_modal', v) }
        }
    },

    methods:
    {
        loginKeypress()
        {
            this.$refs.login_box.handleAction('confirm');
        },

        handleLoginboxShow()
        {
            this.$nextTick(() => this.$refs.login_input_name.$el.querySelector('input').focus());
        },

        handleLogin()
        {
            this.$refs.login_box.doClose();
            this.$Loading.start();

            axios.post(this.$store.state.api_routes.login, this.login)
            .then((data) =>
            {
                this.$store.commit('set_user_data', data)
                this.$Message.success('You are now logged in')
            })
            .catch((err) =>
            {
                this.$Message.error('Wrong credentials')
                this.$store.commit('set_user_data', null)
            })
            .finally(() =>
            {
                this.$Loading.finish();
                this.reset();
            });

        },

        reset()
        {
            this.login.name     = null;
            this.login.password = null;
        }
    }
}
</script>
