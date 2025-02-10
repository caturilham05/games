@extends('layout.index')

@php
use Hashids\Hashids;
$hash_ids = new Hashids(env('APP_KEY'), 8);
@endphp

@section('content')

  <div class="most-popular">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-section">
          <h4><em>All</em> Games</h4>
        </div>
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
          @if (!$games->isEmpty())
            {!! $games->withQueryString()->links('pagination::bootstrap-5') !!}
          @endif
        </div>
      </div>
    </div>
  </div>


@endsection