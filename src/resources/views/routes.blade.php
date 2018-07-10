@php
$routes = json_encode([
    'home'         => route('home'),
    'login'        => route('login'),
    'logout'       => route('logout'),
    'blog_entry'   => route('blog.entry'),
    'session_data' => route('session'),
]);
@endphp

<inject-api-routes routes="{{ $routes }}"></inject-api-routes>
