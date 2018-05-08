<blog-header
    route_home="{{ route('home') }}"
    route_login="{{ route('login') }}"
    route_logout="{{ route('logout') }}"
    user_loggedin="{{ \Auth::check() }}"
    route_add_blog_entry="{{ route('blog.entry.add') }}"
></blog-header>
