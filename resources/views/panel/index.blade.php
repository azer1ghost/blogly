@extends('layouts.app')

@section('content')
    <x-header title="Profile" sub-title="This is your dashboard for everything" />

    <!-- Page Content-->
    <main class="container px-4 px-lg-5">
        <div class="row my-5">
            <div class="card shadow shadow-lg col-12" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">
                        My Blogs
                        <span class="badge bg-info float-end">
                            {{auth()->user()->posts()->count()}}
                        </span>
                    </h5>
                    <p class="card-text">You can share blogs form this section</p>
                    <a href="{{route('posts.index')}}" class="btn btn-primary">Go my articles</a>
                </div>
            </div>
        </div>
    </main>
@endsection
