<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Page;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $homePage = Page::with(['sections' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }])->where('slug', 'home')->first();

        $sections = $homePage
            ? $homePage->sections->map(fn ($s) => [
                'id' => $s->id,
                'key' => $s->key,
                'title' => $s->title,
                'order' => $s->order,
                'content' => $s->content ?? [],
            ])->values()
            : collect([]);

        $departments = Department::where('is_active', true)
            ->orderBy('order')
            ->withCount(['doctors' => fn ($q) => $q->where('is_active', true)])
            ->take(6)
            ->get();

        $featuredDoctors = Doctor::with(['department:id,name,slug', 'schedules' => fn ($q) => $q->where('is_active', true)])
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->take(4)
            ->get();

        $latestArticles = Post::with('category:id,name,slug')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn ($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => str()->limit(strip_tags($post->content), 130),
                'image' => $post->image ?: '/images/hospital/articles/health-checkup.jpg',
                'category' => $post->category?->name ?? 'Kesehatan',
                'published_at' => $post->created_at?->translatedFormat('d M Y'),
            ]);

        return Inertia::render('Homepage', [
            'pageMeta' => [
                'title' => $homePage?->title ?? 'Beranda',
                'description' => $homePage?->meta_description ?? '',
            ],
            'sections' => $sections,
            'departments' => $departments,
            'featuredDoctors' => $featuredDoctors,
            'latestArticles' => $latestArticles,
        ]);
    }
}
