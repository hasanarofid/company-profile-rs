<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CareerController extends Controller
{
    public function index(): Response
    {
        $careers = Career::withCount('applications')->latest()->get();
        $applications = CareerApplication::with('career:id,title,category')->latest()->get();

        return Inertia::render('Admin/Careers/Index', [
            'careers' => $careers,
            'applications' => $applications,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:60',
            'employment_type' => 'required|string|max:60',
            'location' => 'required|string|max:150',
            'department_name' => 'nullable|string|max:120',
            'description' => 'required|string',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $slug = Str::slug($validated['title']);
        $base = $slug;
        $i = 1;
        while (Career::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        Career::create(array_merge($validated, [
            'slug' => $slug,
            'is_active' => $validated['is_active'] ?? true,
        ]));

        return back()->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    public function update(Request $request, Career $career): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:60',
            'employment_type' => 'required|string|max:60',
            'location' => 'required|string|max:150',
            'department_name' => 'nullable|string|max:120',
            'description' => 'required|string',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'deadline' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $career->update($validated);

        return back()->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroy(Career $career): RedirectResponse
    {
        $career->delete();
        return back()->with('success', 'Lowongan kerja berhasil dihapus.');
    }

    public function updateApplicationStatus(Request $request, CareerApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,reviewed,interview,accepted,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->update($validated);

        return back()->with('success', 'Status pelamar ' . $application->applicant_name . ' diperbarui.');
    }
}

