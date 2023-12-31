@foreach ($posts as $item)
    <a class="media align-items-center" href="article.html">
        <img loading="lazy" decoding="async" src="/storage/images/post_images/thumbnails/thumb_{{ $item->featured_image }}"
            alt="Post Thumbnail" class="w-100">
        <div class="media-body ml-3">
            <h3 style="margin-top:-5px">{{ $item->post_title }}</h3>
            <p class="mb-0 small">{!! Str::ucfirst(words($item->post_content, 20)) !!}</p>
        </div>
    </a>
@endforeach
