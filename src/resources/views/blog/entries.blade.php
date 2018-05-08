@extends('index')

@section('page-content')
    @include('blog.header')

    <div class='row'>
        <div class='col-md-16'>
            <blog-entries
                route_get_entries="{{ route('blog.entry.get') }}"
                route_delete_entry="{{ route('blog.entry.delete', ['id' => '']) }}"
                :is_loggedin.sync="is_loggedin"
            ></blog-entries>
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

@endsection
