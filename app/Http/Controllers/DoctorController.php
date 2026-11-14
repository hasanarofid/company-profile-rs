<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DoctorController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Doctor::with(['department:id,name,slug,location', 'schedules' => fn ($q) => $q->where('is_active', true)])
            ->where('is_active', true);

        if ($request->filled('department')) {
            $deptSlug = $request->string('department');
            $query->whereHas('department', fn ($q) => $q->where('slug', $deptSlug));
        }

        if ($request->filled('day')) {
            $day = $request->string('day');
            $query->whereHas('schedules', fn ($q) => $q->where('day_of_week', $day)->where('is_active', true));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%")
                    ->orWhere('sub_specialization', 'like', "%{$search}%");
            });
        }

        $doctors = $query->orderByDesc('is_featured')->orderBy('name')->get();

        $departments = Department::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name', 'slug', 'code', 'short_description', 'image', 'location']);

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors,
            'departments' => $departments,
            'filters' => [
                'department' => $request->input('department', ''),
                'day' => $request->input('day', ''),
                'search' => $request->input('search', ''),
            ],
        ]);
    }

    public function show(string $slug): Response
    {
        $doctor = Doctor::with(['department', 'schedules' => fn ($q) => $q->where('is_active', true)])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $otherDoctors = Doctor::with(['department:id,name,slug'])
            ->where('id', '!=', $doctor->id)
            ->where('department_id', $doctor->department_id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return Inertia::render('Doctors/Show', [
            'doctor' => $doctor,
            'otherDoctors' => $otherDoctors,
        ]);
    }
}
