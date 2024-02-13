<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<div class="floating-wpp"></div>

<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('assets/js/floating-wpp.min.js?v5')}}"></script>

<!-- <script type="text/javascript">
    $(function() {
        $('.floating-wpp').floatingWhatsApp({
            phone: '+62',
            popupMessage: 'Can I help you with something?',
            showPopup: true,
            position: 'left',
            //autoOpen: false,
            //autoOpenTimer: 4000,
            message: 'Hi, I would like to ask about the Push Bike Event.',
            //headerColor: 'orange',
            headerTitle: 'Event Push Bike',
            // buttonImage: '',
            size: '40px',
        });
    });
</script> -->

@foreach ($button as $item)
@if ($item->code == 'whatsapp')
<script type="text/javascript">
    $(function() {
        $('.floating-wpp').floatingWhatsApp({
            phone: '{{ html_entity_decode($item->url) }}',
            popupMessage: 'Can I help you with something?',
            showPopup: true,
            position: 'left',
            //autoOpen: false,
            //autoOpenTimer: 4000,
            message: 'Hi, I would like to ask about the Push Bike Event.',
            //headerColor: 'orange',
            headerTitle: 'Push Bike Event',
            // buttonImage: '',
            size: '40px',
        });
    });
</script>
@endif
@endforeach