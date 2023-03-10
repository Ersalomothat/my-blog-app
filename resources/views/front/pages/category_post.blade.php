@extends('front.layout.pages-layout')
@section('title', isset($pageTitle) ? $pageTitle : 'Category Post')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 border-bottom border-primary d-inline-block">{{ $category->subcategory_name }}</h1>
                </div>
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="row">
                        @forelse($posts as $post)
                            <div class="col-md-6 mb-4">
                                <article class="card article-card article-card-sm h-100">
                                    <a href="{{ route('read_post', $post->post_slug) }}">
                                        <div class="card-image">
                                            <div class="post-info"> <span
                                                    class="text-uppercase">{{ date_formatter($post->created_at) }}</span>
                                                <span class="text-uppercase">3 minutes read</span>
                                            </div>
                                            <img loading="lazy" decoding="async"
                                                src="/storage/images/post_images/{{ $post->featured_image }}"
                                                alt="Post Thumbnail" class="w-100" width="420" height="280">
                                        </div>
                                    </a>
                                    <div class="card-body px-0 pb-0">
                                        <ul class="post-meta mb-2">
                                            <li> <a href="#!">travel</a>
                                                <a href="#!">news</a>
                                            </li>
                                        </ul>
                                        <h2><a class="post-title"
                                                href="{{ route('read_post', $post->post_slug) }}">{{ $post->post_title }}</a>
                                        </h2>
                                        <p class="card-text">{!! Str::ucfirst(words($post->post_title, 25, '...')) !!}</p>
                                        <div class="content"> <a class="read-more-btn"
                                                href="{{ route('read_post', $post->post_slug) }}">Read Full
                                                Article</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                {{ $posts->appends(request()->input())->links('custom_pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-blocks">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <img loading="lazy" decoding="async" src="/front/source/images/author.jpg"
                                            alt="About Me" class="w-100 author-thumb-sm d-block">
                                        <h2 class="widget-title my-3">Ersalomo S</h2>
                                        <p class="mb-3 pb-2">Hi there! It's great to meet you! I'm Ersalomo S., a passionate content writer, blogger, and developer who loves the art of programming. My goal is to craft engaging content that captivates readers and provides valuable insights on a variety of topics. Whether I'm writing about the latest trends in technology or sharing my personal experiences with programming, I always strive to make my content informative, entertaining, and thought-provoking. So, if you're looking for an experienced and creative content writer who can bring your ideas to life, look no further! Let's work together to create something amazing.</p> <a
                                            href="#" class="btn btn-sm btn-outline-primary">Know
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="widget">
                                    <h2 class="section-title mb-3">Recommended</h2>
                                    <div class="widget-body">
                                        <div class="widget-list">

                                            @component('components.item-post', ['posts' => display_latest_post()])
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-categories />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
