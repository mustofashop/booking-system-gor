<!-- ======= Navbar ======= -->
<nav id="navbar" class="navbar">
    <ul>
        @foreach ($navbars as $navbarItem)
        @if(count($navbarItem->navbarsub) == 0)
        <li><a href="{{ $navbarItem->route }}" class="nav-link scrollto">{{ $navbarItem->name }}</a></li>
        @else
        <li class="dropdown">
            <a href="{{ $navbarItem->route }}" class="nav-link"><span>{{ $navbarItem->name }}</span><i
                    class="bi bi-chevron-down"></i></a>
            <ul>
                @foreach ($navbarItem->navbarsub as $navbarItem1)
                @if ($navbarItem1->status == 'ACTIVE')
                <li><a href="{{ $navbarItem1->route }}" class="nav-link">{{ $navbarItem1->name}}</a></li>
                @endif
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        <div class="text-center">
            @foreach ($button as $item)
            @if ($item->code == 'login')
            @if (Auth::check()) <!-- Periksa apakah pengguna sudah login -->
            <button onclick="location.href='{{ route('dashboard') }}'" type="button" class="btn btn-warning">Dashboard
            </button>
            @else
            <button onclick="location.href='{{ $item->url }}'" type="button" class="btn btn-warning">{{ $item->title
                }}
            </button>
            @endif
            @endif
            @endforeach
        </div>

        <li>
            @foreach ($button as $item)
            @if ( $item->code == 'instagram')
            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="instagram">
                <i class="bx bxl-instagram"></i>
            </a> @endif
            @endforeach
        </li>
        <li>
            @foreach ($button as $item)
            @if ( $item->code == 'youtube')
            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="youtube">
                <i class="bx bxl-youtube"></i>
            </a> @endif
            @endforeach
        </li>
        <!-- <li><a target="_blank" href="https://twitter.com/mtsalhusnadepok" class="twitter"><i class="bx bxl-twitter"></i></a></li>
        <li><a target="_blank" href="https://web.facebook.com/mtsalhusna.depok" class="facebook"><i class="bx bxl-facebook"></i></a></li> -->
        <!-- <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
        <li><a class="nav-link scrollto" href="#about">Sejarah IDI</a></li>
        <li><a class="nav-link scrollto" href="#features">Tentang</a></li>
        <li><a class="nav-link scrollto" href="#gallery">Struktur</a></li>
        <li class="dropdown"><a href="#team"><span>Berita</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="#">Detil Berita</a></li>
                <li class="dropdown"><a href="#"><span>Sub Detil Berita</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="#">Sub Detil Berita 1</a></li>
                        <li><a href="#">Sub Detil Berita 2</a></li>
                        <li><a href="#">Sub Detil Berita 3</a></li>
                        <li><a href="#">Sub Detil Berita 4</a></li>
                        <li><a href="#">Sub Detil Berita 5</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown"><a href="#pricing"><span>Kegiatan</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="#">Detil Kegiatan</a></li>
                <li class="dropdown"><a href="#"><span>Sub Detil Kegiatan</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="#">Sub Detil Kegiatan 1</a></li>
                        <li><a href="#">Sub Detil Kegiatan 2</a></li>
                        <li><a href="#">Sub Detil Kegiatan 3</a></li>
                        <li><a href="#">Sub Detil Kegiatan 4</a></li>
                        <li><a href="#">Sub Detil Kegiatan 5</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown"><a href="#gallery"><span>Galeri</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="#">Detil Galeri</a></li>
                <li class="dropdown"><a href="#"><span>Sub Detil Galeri</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="#">Sub Detil Galeri 1</a></li>
                        <li><a href="#">Sub Detil Galeri 2</a></li>
                        <li><a href="#">Sub Detil Galeri 3</a></li>
                        <li><a href="#">Sub Detil Galeri 4</a></li>
                        <li><a href="#">Sub Detil Galeri 5</a></li>
                    </ul>
                </li> -->
        <!-- <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li> -->
        <!-- </ul>
    </li>
    <li class="dropdown"><a href="#procedure"><span>Prosedur</span> <i class="bi bi-chevron-down"></i></a>
        <ul>
            <li><a href="#">Detil Prosedur</a></li>
            <li class="dropdown"><a href="#"><span>Sub Detil Prosedur</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                    <li><a href="#">Sub Detil Prosedur 1</a></li>
                    <li><a href="#">Sub Detil Prosedur 2</a></li>
                    <li><a href="#">Sub Detil Prosedur 3</a></li>
                    <li><a href="#">Sub Detil Prosedur 4</a></li>
                    <li><a href="#">Sub Detil Prosedur 5</a></li>
                </ul>
            </li> -->
        <!-- <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li> -->
        <!-- </ul> -->
        <!-- </li> -->
        <!-- <li><a class="nav-link scrollto" href="#contact">Hubungi Kami</a></li> -->
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav>
<!-- ======= End Navbar ======= -->
