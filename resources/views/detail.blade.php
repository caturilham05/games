@extends('layout.index')

@section('content')
  <!-- ***** Featured Start ***** -->
  <div class="row mb-3">
    <div class="col-lg-12">
      <div class="feature-banner header-text">
        <div class="row">
          <div class="col-lg-12">
            <img src="{{$game->thumbnail}}" alt="" style="border-radius: 23px;">
          </div>
          {{-- <div class="col-lg-8">
            <div class="thumb">
              <img src="{{asset('assets/images/feature-right.jpg')}}" alt="" style="border-radius: 23px;">
              <a href="https://www.youtube.com/watch?v=r1b03uKWk_M" target="_blank"><i class="fa fa-play"></i></a>
            </div>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Featured End ***** -->

  <!-- ***** Details Start ***** -->
  <div class="game-details">
    <div class="row">
      <div class="col-lg-12">
        <div class="content">
          <div class="row">
            <div class="col-lg-6">
              <div class="left-info">
                <div class="left">
                  <h4>{{$game->title}}</h4>
                  <span>{{$game_detail['status']}}</span>
                </div>
                <ul>
                  <li><i class="fa fa-star"></i> {{rand(0, 50) / 10}}</li>
                  <li><i class="fa fa-download"></i> {{rand(0, 50) / 10}}M</li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-info">
                <div style="color: white;"><i class="fa-brands fa-windows" style="color: yellow;"></i> {{$game_detail['minimum_system_requirements']['os']}}</div>
                <div style="color: white;"><i class="fa-solid fa-microchip" style="color: #ec6090"></i> {{$game_detail['minimum_system_requirements']['processor']}}</div>
                <div style="color: white;"><i class="fa-solid fa-memory" style="color: #ec6090"></i> {{$game_detail['minimum_system_requirements']['memory']}}</div>
                <div style="color: white;"><i class="fa-solid fa-desktop" style="color: #ec6090"></i> {{$game_detail['minimum_system_requirements']['graphics']}}</div>
                <div style="color: white;"><i class="fa-solid fa-server" style="color: #ec6090"></i> {{$game_detail['minimum_system_requirements']['storage']}}</div>
              </div>
            </div>
            @foreach ($game_detail['screenshots'] as $ss)            
              <div class="col-lg-4">
                <img src="{{$ss['image']}}" alt="" style="border-radius: 23px; margin-bottom: 30px;">
              </div>
            @endforeach
            <div class="col-lg-12">
              <p>{!!$game_detail['description']!!}</p>
            </div>
            <div class="col-lg-12">
              <div class="main-border-button">
                <a href="{{$game->game_url}}" target="blank">Download {{$game->title}} Now!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Details End ***** -->

  <!-- ***** Other Start ***** -->
  <div class="other-games">
    <div class="row">
      <div class="col-lg-12">
        <div class="heading-section">
          <h4><em>Other Related</em> Games</h4>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="item">
          <img src="{{asset('assets/images/game-01.jpg')}}" alt="" class="templatemo-item">
          <h4>Dota 2</h4><span>Sandbox</span>
          <ul>
            <li><i class="fa fa-star"></i> 4.8</li>
            <li><i class="fa fa-download"></i> 2.3M</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="item">
          <img src="{{asset('assets/images/game-02.jpg')}}" alt="" class="templatemo-item">
          <h4>Dota 2</h4><span>Sandbox</span>
          <ul>
            <li><i class="fa fa-star"></i> 4.8</li>
            <li><i class="fa fa-download"></i> 2.3M</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Other End ***** -->
@endsection