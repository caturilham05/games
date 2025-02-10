<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="/" class="logo">
                        {{-- <h3 style="color: #000 !important">Rutac Games</h3> --}}
                        <img src="{{asset('assets/images/logo.png')}}" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Search End ***** -->
                    {{-- <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div> --}}
                    @if (Request::is('/'))
                        <div class="search-input">
                            <form id="search" action="{{ route('dashboard') }}" method="GET">
                                <input type="text" placeholder="@if ($search) {{$search}} @else Type Something @endif" id='searchText' name="title" @if ($search) value="{{$search}}" @endif onkeypress="handle" />
                                <i class="fa fa-search"></i>
                            </form>
                        </div>
                    @endif

                    <!-- ***** Search End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        {{-- <li><a href="/" class="active">Home</a></li>
                        <li><a href="/">Browse</a></li>
                        <li><a href="/">Details</a></li>
                        <li><a href="/">Streams</a></li> --}}
                        <li><a href="/">Profile <img src="{{asset('assets/images/profile-header.jpg')}}" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
