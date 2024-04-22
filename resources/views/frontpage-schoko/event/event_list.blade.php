<div class="ec-blogs-inner">
    <div class="row">
        @foreach ($data as $row)
            <div class="col-md-12 col-sm-12 mb-6 ec-blog-block">
                <div class="ec-blog-inner">
                    <div class="ec-blog-image">
                        @php $ext = explode('.', $row->data_file) @endphp
                        @if (end($ext) == 'jpg' || end($ext) == 'jpeg' || end($ext) == 'gif' || end($ext) == 'png')
                        <a href="{{ route('event_detail', $row->slug) }}">
                            <img class="gambar-catalogue" src="{{ img_src($row->data_file, 'news') }}" alt="{{ session()->get('locale') == 'id' ? $row->title : $row->title }}" onerror="this.onerror=null;this.src='{{ img_src('default.jpg', '')}}';" style="border-radius: 16px;">
                        </a>
                        @elseif (end($ext) == 'mp4' || end($ext) == '3gp' || end($ext) == 'wmv' || end($ext) == 'mkv')
                            <video id="my-video" class="video-js" controls preload="auto" width="100%" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                                <source src="{{ img_src($row->data_file, "news") }}" type="video/mp4" />
                                <source src="{{ img_src($row->data_file, "news") }}" type="video/webm" />
                            </video>
                        @else
                            <iframe
                                width="100%"
                                height="200px"
                                src="https://www.youtube.com/embed/{{$row->data_file}}"
                                title="YouTube"
                                frameborder="0"
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        @endif
                    </div>
                    <div class="ec-blog-content">
                        <span class="badge btn-primary mb-2">{{ $row->post_category_name }}</span>
                        <h5 class="ec-blog-title m-0"><a href="{{ route('event_detail', $row->slug) }}">{{ session()->get('locale') == 'id' ? $row->title : $row->title }}</a></h5>
                        <div class="ec-blog-date">
                            {{ date('M d, Y', strtotime($row->created_at)) }}</div>
                        <div class="ec-blog-desc">
                            {!! strip_tags(substr(session()->get('locale') == 'id' ? $row->description : $row->description, 0, 190)) !!} {!!  strlen(session()->get('locale') == 'id' ? $row->description : $row->description) > 190 ? '...' : '' !!}
                        </div>
                        <div class="ec-blog-btn">
                            <a href="{{ route('event_detail', $row->slug) }}" class="btn btn-primary">{{ __('news.detail_button') }}</a>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        @endforeach

    </div>
</div>
<!-- Ec Pagination Start -->
<div class="ec-pro-pagination">
    {{ $data->links('vendor.pagination.custom')}}
</div>
<!-- Ec Pagination End -->
