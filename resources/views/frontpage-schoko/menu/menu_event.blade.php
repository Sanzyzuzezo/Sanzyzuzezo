<div class="container my-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-0" id="tag_container">
            <section class="section ec-instagram-section module">
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-6 text-left px-5">
                            <div class="section-title">
                                <h2 class="ec-bg-title p-0">Event</h2>
                                <h2 class="ec-title p-0">Event</h2>
                            </div>
                        </div>
                        <div class="col-md-6 px-5">
                            <div class="section-title">
                                <a href="{{ route('events') }}"><label class="float-right">More Event ></label></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-12 px-5">
                            <div class="swiper mySwiper swiper-show-slide px-0 pt-0">
                                <div class="swiper-wrapper">
                                    @foreach ($events as $row)
                                        <div class="swiper-slide" style="width:350px; height: 100%;"> 
                                            <div class="recipe-media">
                                            @php $ext = explode('.', $row->data_file) @endphp
                                                @if (end($ext) == 'jpg' || end($ext) == 'jpeg' || end($ext) == 'gif' || end($ext) == 'png')
                                                    <img src="{{ img_src($row->data_file, 'news') }}" alt="{{ session()->get('locale') == 'id' ? $row->title : $row->title_an }}" >
                                                @elseif (end($ext) == 'mp4' || end($ext) == '3gp' || end($ext) == 'wmv' || end($ext) == 'mkv')
                                                    <video id="my-video" class="video-js" controls preload="auto" width="100%" poster="MY_VIDEO_POSTER.jpg" data-setup="{}" style="height: 100%; width:100%; object-fit:cover;">
                                                        <source src="{{ img_src($row->data_file, "news") }}" type="video/mp4" />
                                                        <source src="{{ img_src($row->data_file, "news") }}" type="video/webm" />
                                                    </video>
                                                @else
                                                    <iframe 
                                                        src="https://www.youtube.com/embed/{{$row->data_file}}"
                                                        title="YouTube"
                                                        frameborder="0"
                                                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen>
                                                    </iframe>
                                                @endif
                                            </div>
                                            <div class="recipe-title">
                                                <a href="{{ route('news_detail', $row->slug) }}">{{ $row->title }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>