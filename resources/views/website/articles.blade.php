@extends('layouts.app')

@section('content')
    <x-header title="Blogly" sub-title="Welcome our creative blog" />

    <!-- Page Content-->
    <main class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7" x-data="articleComponent" >
                <template x-for="(post, index) in articles" :key="index">
                    <!-- Post preview-->
                    <div class="post-preview">
                        <a :href="`article/${post.slug}`">
                            <h2 class="post-title" x-text="post.title" ></h2>
                            <h3 class="post-subtitle" x-text="post.description"></h3>
                        </a>
                        <p class="post-meta">
                            Posted by <a x-text="post.author" ></a>
                            on <span x-text="post.publication_date"></span>
                        </p>
                    </div>
                    <!-- Divider-->
                    <hr class="my-4" />
                </template>
                <div class="col-12" x-intersect="loadMore('/articles')">
                    <h3 x-show="loading" x-transition class="text-center" > Loading  <i class="fas fa-spin fa-spinner"></i></h3>
                </div>
            </div>
        </div>
    </main>
@endsection

