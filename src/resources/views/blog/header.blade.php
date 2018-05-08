<blog-header
    route_home="{{ route('home') }}"
    route_logout="{{ route('logout') }}"
    :login_modal.sync="login_modal"
    :is_loggedin.sync="is_loggedin"
    route_add_blog_entry="{{ route('blog.entry.add') }}"
></blog-header>
