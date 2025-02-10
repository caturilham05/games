@extends('layout.index')

@php
use Hashids\Hashids;
$hash_ids = new Hashids(env('APP_KEY'), 8);
@endphp

@section('content')
  <div class="main-banner">
    <div class="row">
      <div class="col-lg-7">
        <div class="header-text">
          <h6>Welcome To Rutac Games</h6>
          <h4><em>Browse</em> Our Popular Games Here</h4>
        </div>
      </div>
    </div>
  </div>

  <div class="most-popular">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-section">
          <h4><em>All</em> Games</h4>
        </div>
        <div class="row" id="post-container">
          {{-- <div class="col-lg-12" id="post-container"> --}}
            @include('partials.all')
          {{-- </div> --}}

          <div id="loading" class="text-center my-3" style="display: none;">
            <div id="js-preloader" class="js-preloader">
              <div class="preloader-inner">
                <span class="dot"></span>
                <div class="dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>
            </div>
          </div>
          {{-- @foreach ($games as $game)
            <div class="col-lg-3 col-sm-6">
              <div class="item">
                <img src="{{$game->thumbnail}}" alt="">
                <h4>{!!$game->title!!}</h4>
                <span>{!!$game->platform!!}</span>
                <small style="color: #888 !important">{!!$game->genre!!}</small>
                <div style="color: #888 !important; font-size: 10px; margin-top: 5px">{!!$game->genre!!}</div>
                <div style="font-size: 12px; color: #888; margin-top: 5px ">{!!$game->short_description!!}</div>
                <div style="font-size: 9px; color: #888; margin-top: 10px ">{{date('d F Y', strtotime($game->release_date))}}</div>
                <center>
                  <div class="main-border-button" style="margin-top: 3rem !important;">
                    <a href="{{ route('detail', $hash_ids->encode($game->id_origin)) }}">Show Detail</a>
                  </div>
                </center>
              </div>
            </div>
          @endforeach
          @if (!$games->isEmpty())
            {!! $games->withQueryString()->links('pagination::bootstrap-5') !!}
          @endif --}}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    let page = 1;
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 10) {
          loadMorePosts();
        }
    });

    function loadMorePosts() {
      page++;
      $('#loading').show();
      $.get("{{ url('/all-load') }}?page=" + page, function (data) {
          if (data.trim() === '') {
            $(window).off("scroll");
          } else {
            $('#post-container').append(data);
            $('#loading').hide();
          }
      });
    }
</script>
@endsection