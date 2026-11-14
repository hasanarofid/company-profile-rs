<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Post::with('category:id,name,slug')
            ->where('status', 'published');

        if ($request->filled('category')) {
            $catSlug = $request->string('category');
            $query->whereHas('category', fn ($q) => $q->where('slug', $catSlug));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->get()->map(fn ($post) => [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => str()->limit(strip_tags($post->content), 150),
            'image' => $post->image ?: '/images/hospital/articles/health-checkup.jpg',
            'category' => $post->category ? [
                'name' => $post->category->name,
                'slug' => $post->category->slug,
            ] : ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            'is_featured' => (bool) $post->is_featured,
            'published_at' => $post->created_at?->translatedFormat('d M Y'),
        ]);

        $categories = Category::orderBy('name')->get(['id', 'name', 'slug']);

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => [
                'category' => $request->input('category', ''),
                'search' => $request->input('search', ''),
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $post = Post::with('category:id,name,slug')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $related = Post::with('category:id,name,slug')
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'image' => $p->image ?: '/images/hospital/articles/health-checkup.jpg',
                'category' => $p->category?->name ?? 'Kesehatan',
                'published_at' => $p->created_at?->translatedFormat('d M Y'),
            ]);

        return Inertia::render('Articles/Show', [
            'article' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'image' => $post->image ?: '/images/hospital/articles/health-checkup.jpg',
                'category' => $post->category?->name ?? 'Kesehatan',
                'published_at' => $post->created_at?->translatedFormat('d M Y'),
            ],
            'relatedArticles' => $related,
        ]);
    }
}
