 <template>
     <at-modal-extended v-model="loginModal" title="Please sign in" @on-confirm="handleLogin" ref="login_box" @on-show="handleLoginboxShow">
        <at-input v-model="login.name" placeholder='username' @keyup.enter.native="loginKeypress()" ref='login_input_name'></at-input>
        <at-input v-model="login.password" placeholder='password' @keyup.enter.native="loginKeypress()" type='password'></at-input>
    </at-modal-extended>
</template>

<script>
export default
{
    props:
    {
        is_loggedin:
        {
            type: Boolean,
        },
        route_login:
        {
            type: String
        },
        login_modal:
        {
            type: Boolean
        }
    },

    data()
    {
        return {
            loginModal: this.login_modal,
            login:
            {
                name: null,
                password: null
            },
        };
    },

    mounted()
    {
    },

    watch:
    {
        login_modal(v)
        {
            this.loginModal = v;
        },

        loginModal(v)
        {
             this.$emit('update:login_modal', v);
        },
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

            axios.post(this.route_login, this.login)
            .then((data) =>
            {
                this.$Message.success('You are now logged in');
                this.$emit('update:is_loggedin', true);
            })
            .catch((err) =>
            {
                this.$Message.error('Wrong credentials');
                this.$emit('update:is_loggedin', false);
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
