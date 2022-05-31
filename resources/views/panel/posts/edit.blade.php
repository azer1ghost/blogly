@extends('layouts.app')

@section('content')

    <x-header title="Article" :sub-title="$title"/>

    <!-- Page Content-->
    <main class="container px-4 px-lg-5">
        <div class="row my-5">
            <h1>
                <a href="{{route('posts.index')}}" class="btn btn-sm btn-primary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

            </h1>
            <hr>
            <div class="card col-12">
                <div class="card-body">
                    <form action="{{$action}}" id="article-form" method="POST" enctype="multipart/form-data"
                          class="row justify-content-end">
                        @csrf @method($method)
                        <div class="mb-3 col-12 col-lg-8">
                            <label for="title" class="form-label">Title</label>
                            <input type="text"
                                   @empty($action) readonly @endempty
                                   value="{{ old('title') ?? $data->getAttribute('title') }}"
                                   name="title"
                                   placeholder="Enter article title"
                                   id="title"
                                   class="form-control
                                   @error('title')
                                       is-invalid
                                   @enderror">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="publication_date" class="form-label">Publication date</label>
                            <input
                                type="date"
                                @empty($action) readonly @endempty
                                @php($public_at = $data->getAttribute('publication_date'))
                                value="{{is_null($public_at) ? old('publication_date'): $public_at->format('Y-m-d')}}"
                                name="publication_date"
                                id="publication_date"
                                class="form-control
                               @error('publication_date')
                                   is-invalid
                               @enderror">
                            @error('publication_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-lg-8">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                name="description"
                                @empty($action) readonly @endempty
                                id="description"
                                rows="10"
                                placeholder="Enter article description"
                                class="form-control
                                  @error('description')
                                      is-invalid
                                  @enderror"
                            >{{old('description') ?? $data->getAttribute('description')}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="Image" class="form-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="post-image" onchange="preview()">
                            <div class="mt-2 p-2">
                                <img id="frame" src="{{asset('storage/'. $data->getAttribute('image'))}}"
                                     style="width: 100%" alt="post-image">
                            </div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-lg-8">
                            <label for="Tags" class="form-label">Tags</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">#</span>
                                <input type="text"
                                       class="form-control @error('image') is-invalid @enderror"
                                       placeholder="Tags"
                                       data-role="tagsinput"
                                       name="tags"
                                       value="{{implode(',' , $data->getAttribute('tags') ?? [])}}">
                            </div>
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if($action)
                            <div class="col">
                                <button type="submit" class="btn btn-primary float-end mx-2">Save</button>
                                <input onclick="submitDraft()" value="Save as Draft" type="submit"
                                       class="btn btn-secondary float-end"/>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet"
    />
    <style type="text/css">
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            line-height: 30px;
            color: white !important;
            background-color: #0d6efd;
            padding: .3rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

    <script>
        function submitDraft() {
            document.getElementById('publication_date').value = ""
            document.getElementById("article-form").submit()
        }

        const fileInput = document.querySelector('#post-image');

        fileInput.addEventListener('change', (event) => {
            const frame = document.querySelector('#frame');
            frame.src = URL.createObjectURL(event.target.files[0]);
        });
    </script>
@endpush
