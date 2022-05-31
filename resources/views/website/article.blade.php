@extends('layouts.app')

@section('content')
    <x-header title="{!! $post->getAttribute('title') !!}" />

    <!-- Page Content-->
    <main class="container px-4 px-lg-5">
        <!-- Post Content-->
        <article class="mb-4">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <p>{!! $post->getAttribute('description') !!}</p>
                    </div>
                </div>
            </div>
        </article>
    </main>
@endsection
