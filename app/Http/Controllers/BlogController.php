<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            
            $query = Blog::with('user')
                ->published()
                ->orderBy('published_at', 'desc');
                
            // Filter by category if provided
            if ($request->has('category')) {
                $category = $request->category;
                $query->where(function ($q) use ($category) {
                    $q->whereJsonContains('categories', $category);
                });
            }
            
            // Filter by tag if provided
            if ($request->has('tag')) {
                $tag = $request->tag;
                $query->where(function ($q) use ($tag) {
                    $q->whereJsonContains('tags', $tag);
                });
            }
            
            $blogs = $query->paginate(9);
            
            // Get all unique categories and tags for filters
            $allCategories = Blog::published()
                ->get()
                ->pluck('categories')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
                
            $allTags = Blog::published()
                ->get()
                ->pluck('tags')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();

            return view('blog.index', compact('blogs', 'settings', 'allCategories', 'allTags'));
            
        } catch (\Exception $e) {
            Log::error('Error in BlogController@index: ' . $e->getMessage());
            
            return view('blog.index', [
                'blogs' => collect([]),
                'settings' => Settings::pluck('value', 'key')->all(),
                'allCategories' => [],
                'allTags' => [],
            ]);
        }
    }

    public function show($slug)
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            
            $blog = Blog::with('user')
                ->where('slug', $slug)
                ->firstOrFail();
                
            // Increment views
            $blog->incrementViews();
            
            // Get related posts (posts with same category or tag)
            $relatedPosts = Blog::with('user')
                ->published()
                ->where('id', '!=', $blog->id)
                ->where(function ($query) use ($blog) {
                    // Match by category
                    if (!empty($blog->categories)) {
                        foreach ($blog->categories as $category) {
                            $query->orWhereJsonContains('categories', $category);
                        }
                    }
                    
                    // Match by tag
                    if (!empty($blog->tags)) {
                        foreach ($blog->tags as $tag) {
                            $query->orWhereJsonContains('tags', $tag);
                        }
                    }
                })
                ->inRandomOrder()
                ->limit(3)
                ->get();
                
            return view('blog.show', compact('blog', 'settings', 'relatedPosts'));
            
        } catch (\Exception $e) {
            Log::error('Error in BlogController@show: ' . $e->getMessage());
            return abort(404);
        }
    }
    
    public function byCategory($category)
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            
            $blogs = Blog::with('user')
                ->published()
                ->whereJsonContains('categories', $category)
                ->orderBy('published_at', 'desc')
                ->paginate(9);
                
            $allCategories = Blog::published()
                ->get()
                ->pluck('categories')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
                
            $allTags = Blog::published()
                ->get()
                ->pluck('tags')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
                
            return view('blog.index', compact('blogs', 'settings', 'allCategories', 'allTags', 'category'));
            
        } catch (\Exception $e) {
            Log::error('Error in BlogController@byCategory: ' . $e->getMessage());
            return abort(404);
        }
    }
    
    public function byTag($tag)
    {
        try {
            $settings = Settings::pluck('value', 'key')->all();
            
            $blogs = Blog::with('user')
                ->published()
                ->whereJsonContains('tags', $tag)
                ->orderBy('published_at', 'desc')
                ->paginate(9);
                
            $allCategories = Blog::published()
                ->get()
                ->pluck('categories')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
                
            $allTags = Blog::published()
                ->get()
                ->pluck('tags')
                ->flatten()
                ->filter()
                ->unique()
                ->values()
                ->all();
                
            return view('blog.index', compact('blogs', 'settings', 'allCategories', 'allTags', 'tag'));
            
        } catch (\Exception $e) {
            Log::error('Error in BlogController@byTag: ' . $e->getMessage());
            return abort(404);
        }
    }
}
