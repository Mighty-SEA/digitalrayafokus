@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($category))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Menampilkan artikel dengan kategori: <span class="font-medium">{{ $category }}</span>
                            <a href="{{ route('blog.index') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600 ml-1">
                                Reset filter
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($tag))
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Menampilkan artikel dengan tag: <span class="font-medium">{{ $tag }}</span>
                            <a href="{{ route('blog.index') }}" class="font-medium underline text-blue-700 hover:text-blue-600 ml-1">
                                Reset filter
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Blog Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($blogs as $blog)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    @if($blog->featured_image)
                        <a href="{{ route('blog.show', $blog->slug) }}" class="block aspect-w-16 aspect-h-9 overflow-hidden">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" 
                                 class="w-full h-48 object-cover transform transition-transform duration-500 hover:scale-105">
                        </a>
                    @endif
                    <div class="p-6">
                        <!-- Categories -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($blog->categories as $category)
                                <a href="{{ route('blog.category', $category) }}" 
                                   class="text-xs font-medium bg-blue-50 text-blue-600 px-2.5 py-0.5 rounded-full hover:bg-blue-100 transition-colors duration-200">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-blue-600 transition-colors duration-200">
                                {{ $blog->title }}
                            </a>
                        </h2>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm text-gray-500">
                                    <span>By {{ $blog->user->name }}</span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $blog->published_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada artikel</h3>
                    <p class="mt-1 text-sm text-gray-500">Artikel sedang dalam proses pembuatan, mohon kunjungi kembali nanti.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $blogs->links() }}
        </div>
    </div>
</div>
@endsection 