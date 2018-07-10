<template>
    <section class="container">
        <blog-header></blog-header>

        <div class='row'>
            <div class='col-md-16'>
                <blog-entries></blog-entries>
            </div>
            <div class='col-md-8 sidebar'>
                <div style="position: relative; width: 100%">
                    <a href="http://github.com/mike-code" target="_new" >
                        <at-card class='github' style="width: 100%;" :body-style="{ padding: 0 }">
                                <img style="width: 100%" src="https://avatars3.githubusercontent.com/u/2964642?s=460&v=4">
                                <div style="padding: 1rem">
                                    <p><strong>My Github profile!</strong></p>
                                    Check out my other projects
                                </div>
                        </at-card>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <blogly-login ref="login_modal"></blogly-login>
    </section>
</template>
