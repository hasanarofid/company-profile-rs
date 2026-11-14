<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    public function index(): Response
    {
        $departments = Department::withCount('doctors')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Departments/Index', [
            'departments' => $departments,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'code' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:120',
            'phone_ext' => 'nullable|string|max:30',
            'facilities' => 'nullable|array',
            'order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:4096',
        ]);

        $imagePath = '/images/hospital/departments/cardiology.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'departments', $validated['name']);
        }

        Department::create([
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
            'code' => $validated['code'] ?? strtoupper(Str::substr($validated['name'], 0, 3)),
            'icon' => $validated['icon'] ?? 'Stethoscope',
            'image' => $imagePath,
            'short_description' => $validated['short_description'] ?? '',
            'description' => $validated['description'] ?? '',
            'facilities' => $validated['facilities'] ?? [],
            'location' => $validated['location'] ?? '',
            'phone_ext' => $validated['phone_ext'] ?? '',
            'order' => $validated['order'] ?? 0,
            'is_featured' => $validated['is_featured'] ?? true,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return back()->with('success', 'Unit / Poli berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'code' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:120',
            'phone_ext' => 'nullable|string|max:30',
            'facilities' => 'nullable|array',
            'order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = collect($validated)->except('image')->toArray();
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'departments', $validated['name']);
        }

        $department->update($data);

        return back()->with('success', 'Unit / Poli berhasil diperbarui.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();
        return back()->with('success', 'Unit / Poli berhasil dihapus.');
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 1;
        while (Department::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function uploadFile($file, string $folder, string $prefix): string
    {
        $dir = public_path('uploads/' . $folder);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $filename = Str::slug($prefix) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return '/uploads/' . $folder . '/' . $filename;
    }
}

