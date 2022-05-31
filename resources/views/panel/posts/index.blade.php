@extends('layouts.app')

@section('content')
    <x-header title="Articles" sub-title="Manage your articles" />

    <!-- Page Content-->
    <main class="container px-0 px-lg-5" x-data="deleteModal()">
        <div class="row m-0 my-5">
            @can('create', \App\Models\Post::class)
               <div class="col-12 p-0 mb-3">
                   <a class="btn btn-success float-end shadow-lg" href="{{route('posts.create')}}">
                       <i class="fas fa-plus"></i>
                       Create New Article
                   </a>
               </div>
            @endcan
            <div class="card shadow-lg col-12">
                <div class="card-header">
                    <x-filters :model="\App\Models\Post::class"/>
                </div>
                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$post->getAttribute('title')}}</td>
                                <td>{{$post->shortColumn('description', 25)}}</td>
                                <td>{{$post->getAttribute('created_at')->diffForHumans()}}</td>
                                <td>
                                    <span @class([ 'text-success' => $post->isPublished() ]) >
                                        @if($post->getAttribute('publication_date'))
                                            {{$post->getAttribute('publication_date')->format('M d Y')}}
                                        @else
                                            Draft
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group border rounded-3 shadow text-capitalize">
                                        @can('view', $post)
                                        <a class="btn btn-sm btn-outline-warning" href="{{route('posts.show', $post)}}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan
                                        @can('update', $post)
                                        <a class="btn btn-sm btn-outline-primary" href="{{route('posts.edit', $post)}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $post)
                                        <a class="btn btn-sm btn-outline-danger" @click='confirm(@json($post))' data-bs-toggle="modal" data-bs-target="#confirmModal" href="{{route('posts.destroy', $post)}}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Delete Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h2>Are you sure delete this article? </h2>
                        <p class="text-danger" x-text="post.title"></p>
                    </div>
                    <form method="POST" :action="'{{route('posts.destroy', 'post_id')}}'.replace('post_id', post.id)" class="modal-footer">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        function deleteModal(){
            return {
                post: {
                    id: null,
                    title: null
                },
                confirm(post){
                    this.post = post
                }
            }
        }
    </script>
@endpush
