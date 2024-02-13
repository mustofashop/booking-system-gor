<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        @foreach ($label as $item)
                        @if ( $item->code == 'slogan')
                        <h3>{!!html_entity_decode($item->title)!!}</h3>
                        <p class="pb-3"><em>{!!html_entity_decode($item->desc)!!}</em></p>
                        @endif
                        @endforeach

                        <p>
                            @foreach ($label as $item)
                            @if ( $item->code == 'location')
                            <p>{!!html_entity_decode($item->desc)!!}</p>
                            @endif
                            @endforeach<br><br>

                            @foreach ($label as $item)
                            @if ( $item->code == 'phone')
                            <p>{!!html_entity_decode($item->desc)!!}</p>
                            @endif
                            @endforeach<br>
                            @foreach ($label as $item)
                            @if ( $item->code == 'email')
                            <p>{!!html_entity_decode($item->desc)!!}</p>
                            @endif
                            @endforeach<br>
                        </p>
                        <div class="social-links mt-3">
                            @foreach ($button as $item)
                            @if ( $item->code == 'instagram')
                            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="instagram"><i class="bx bxl-instagram"></i></a>
                            @endif
                            @if ( $item->code == 'youtube')
                            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="youtube">
                                <i class="bx bxl-youtube"></i>
                            </a>
                            @endif
                            @if ( $item->code == 'twitter')
                            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="twitter">
                                <i class="bx bxl-twitter"></i>
                            </a>
                            @endif
                            @if ( $item->code == 'facebook')
                            <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="facebook">
                                <i class="bx bxl-facebook"></i>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Link Website</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://www.kemenag.go.id/">Kemenag RI</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://www.kemdikbud.go.id/">Kemdikbud</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://simpatika.kemenag.go.id/madrasah">Simpatika Kemenag</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://emis.kemenag.go.id/">Emis Kemenag</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://nisn.data.kemdikbud.go.id/">NISN</a></li>
                    </ul>
                </div> -->

                <!-- <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Link Aplikasi</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://ppdb.mts-alhusnadepok.sch.id/">PPDB ONLINE</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://ahad.mts-alhusnadepok.sch.id/">AHAD Apps</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://elearning.mts-alhusnadepok.sch.id/">E-Learning</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">PTSP</a></li>
                    </ul>
                </div> -->

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    @foreach ($label as $item)
                    @if ( $item->code == 'subscribe')
                    <h4>{!!html_entity_decode($item->title)!!}</h4>
                    <p>{!!html_entity_decode($item->desc)!!}</p>
                    @endif
                    @endforeach

                    @foreach ($button as $item)
                    @if ( $item->code == 'send')
                    <form action="{!!html_entity_decode($item->url)!!}" method="post">
                        <input type="email" name="email"><input type="submit" value="{!!html_entity_decode($item->title)!!}">
                    </form>
                    @endif
                    @endforeach

                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>E-Event</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/ -->
            IT <a href="https://nhtsolution.com/">NHT Solution</a> and Digital Marketing <a href="https://marketing-ind.com/">MarketingInd</a>
        </div>
    </div>
</footer>
<!-- =======  End Footer ======= -->