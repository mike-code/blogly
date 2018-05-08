@extends('index')

@section('page-content')
    @include('blog.header')

    <div class='row'>
        <div class='col-md-16'>
            <blog-entries
                route_get_entries="{{ route('blog.entry.get') }}"
                route_delete_entry="{{ route('blog.entry.delete', ['id' => '']) }}"
            ></blog-entries>
        </div>
        <div class='col-md-8'>
        </div>
    </div>

@endsection
