<!-- Page Header-->
<header class="masthead" style="background-image: url('{{asset('assets/img/home-bg.jpg')}}')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>{{$title}}</h1>
                    @isset($subTitle)
                        <span class="subheading">{{$subTitle}}</span>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</header>

@if(session()->has('notify'))
   <div class="col-12">
       <div class="alert alert-{!! session()->get('notify')['type'] !!} text-center" role="alert">
           {!! session()->get('notify')['message'] !!}
       </div>
   </div>
@endif

