<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Pages/Index', [
            'pages' => Page::withCount('sections')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:pages,slug',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman baru berhasil dibuat.');
    }

    public function edit(Page $page): Response
    {
        $page->load(['sections' => fn ($q) => $q->orderBy('order')]);
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page,
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:pages,slug,' . $page->id,
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $page->update($validated);

        return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Detail halaman berhasil diperbarui.');
    }

    public function updateSection(Request $request, Page $page, Section $section): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'content' => 'required|array',
            'is_active' => 'required|boolean',
        ]);

        $section->update($validated);

        return redirect()->back()->with('success', "Komponen '{$section->title}' berhasil diperbarui.");
    }

    public function reorderSections(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:sections,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($validated['orders'] as $item) {
            Section::where('id', $item['id'])
                ->where('page_id', $page->id)
                ->update(['order' => $item['order']]);
        }

        return redirect()->back()->with('success', 'Urutan tata letak halaman berhasil diperbarui.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
