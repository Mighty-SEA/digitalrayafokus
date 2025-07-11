@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Blog Header -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach($blog->categories as $category)
                        <a href="{{ route('blog.category', $category) }}" 
                           class="text-xs font-medium bg-blue-50 text-blue-600 px-2.5 py-0.5 rounded-full hover:bg-blue-100 transition-colors duration-200">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    {{ $blog->title }}
                </h1>
                
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex flex-col">
                            <span class="text-gray-900 font-medium">{{ $blog->user->name }}</span>
                            <span class="text-gray-600 text-sm">{{ $blog->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-500 text-sm">
                        <span class="flex items-center mr-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $blog->views }} views
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $blog->reading_time }} min read
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="mb-10 rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" 
                         class="w-full h-auto object-cover rounded-xl shadow-md">
                </div>
            @endif
            
            <!-- Blog Content -->
            <div class="prose prose-lg lg:prose-xl max-w-none mb-10">
                {!! $blog->content !!}
            </div>
            
            <!-- Tags -->
            @if(!empty($blog->tags))
                <div class="border-t border-gray-200 pt-6 mb-10">
                    <h4 class="text-gray-600 font-medium mb-3">Tags:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags as $tag)
                            <a href="{{ route('blog.tag', $tag) }}" 
                               class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1 rounded-full transition-colors duration-200">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Related Posts -->
            @if($relatedPosts->isNotEmpty())
                <div class="border-t border-gray-200 pt-10 mt-10">
                    <h3 class="text-2xl font-bold mb-6">Artikel Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                                @if($relatedPost->featured_image)
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="block">
                                        <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" 
                                             class="w-full h-32 object-cover">
                                    </a>
                                @endif
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold mb-2 line-clamp-2">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-blue-600 transition-colors">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h4>
                                    <div class="text-xs text-gray-500">
                                        {{ $relatedPost->published_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Back Button -->
            <div class="mt-12 mb-8">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Blog
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 