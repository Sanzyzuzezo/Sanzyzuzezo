@php $address = json_decode($navbar['settings']['address']); @endphp
<footer class="ec-footer section-space-mt dark">
    <div class="footer-container">
        <div class="footer-top section-space-footer-p bg-dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-4 ec-footer-info">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading border-bottom-0 text-white">{{ $navbar['settings']['site_name'] }}</h4>
                            <div class="ec-footer-links text-white">
                                @php echo $address->detail @endphp
                            </div>
                            <div class="ec-footer-links text-white pt-4">
                                {{ $navbar['settings']['phone'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-3 ec-footer-account">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading text-white">Pages</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    @foreach ($navbar["pages"] as $page)
                                    <li class="ec-footer-link"><a href="{{ route('pages_detail', $page->id) }}" class="text-white">{{ $page['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom bg-black border-top-0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col text-center footer-copy">
                        <div class="footer-bottom-copy ">
                            <div class="ec-copy text-white">Copyright © 2022 All Rights Reserved by <a href="http://diantara.co.id" target="_blank" class="text-white">PT DiAntara Inter Media</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
