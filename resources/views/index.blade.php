@extends('layout.index')

@php
use Hashids\Hashids;
$hash_ids = new Hashids(env('APP_KEY'), 8);
@endphp

@section('content')
  <!-- ***** Banner Start ***** -->
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
  @if (!$search)
    <div class="most-popular">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading-section">
            <h4><em>Most Popular</em> Right Now</h4>
          </div>
          <div class="row">
            @foreach ($randoms as $random)
              <div class="col-lg-3 col-sm-6">
                <div class="item">
                  <img src="{{$random->thumbnail}}" alt="">
                  <h4>{!!$random->title!!}</h4>
                  <span>{!!$random->platform!!}</span>
                  <div style="color: #888 !important; font-size: 10px; margin-top: 5px">{!!$random->genre!!}</div>
                  <div style="font-size: 12px; color: #888; margin-top: 5px ">{!!$random->short_description!!}</div>
                  <div style="font-size: 9px; color: #888; margin-top: 10px ">{{date('d F Y', strtotime($random->release_date))}}</div>
                  <center>
                    <div class="main-border-button" style="margin-top: 3rem !important;">
                      <a href="{{ route('detail', $hash_ids->encode($random->id_origin)) }}">Show Detail</a>
                    </div>
                  </center>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="most-popular">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-section">
          @if ($search)
            <h4><em>Result for games</em> '{{$search}}' @if ($games->isEmpty()) <em>not found</em> @endif <em>({{$total}})</em></h4>
          @else          
            <h4><em>All</em> Games</h4>
          @endif
        </div>
          @if (!$games->isEmpty())
            <div class="row">
              @foreach ($games as $game)
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
              <div class="col-lg-12">
                <div class="main-button">
                  <a href="{{route('all')}}">Show All Games</a>
                </div>
              </div>
            </div>
          @endif
      </div>
    </div>
  </div>
@endsection