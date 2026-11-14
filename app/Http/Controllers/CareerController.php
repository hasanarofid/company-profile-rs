<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CareerController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Career::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('department_name', 'like', "%{$search}%");
            });
        }

        $careers = $query->latest()->get();

        return Inertia::render('Careers/Index', [
            'careers' => $careers,
            'filters' => [
                'category' => $request->input('category', ''),
                'search' => $request->input('search', ''),
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $career = Career::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('Careers/Show', [
            'career' => $career,
        ]);
    }

    public function apply(Request $request, string $slug): RedirectResponse
    {
        $career = Career::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'education' => 'required|string|max:120',
            'experience_summary' => 'nullable|string|max:2000',
            'cover_letter' => 'nullable|string|max:2000',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('cv_file');
        $uploadDir = public_path('uploads/cv');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = Str::slug($validated['applicant_name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        CareerApplication::create([
            'career_id' => $career->id,
            'applicant_name' => $validated['applicant_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'education' => $validated['education'],
            'experience_summary' => $validated['experience_summary'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path' => '/uploads/cv/' . $filename,
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Lamaran Anda untuk posisi ' . $career->title . ' berhasil dikirim. Tim HRD kami akan menghubungi Anda.');
    }
}

