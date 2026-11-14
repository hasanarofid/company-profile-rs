<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DoctorController extends Controller
{
    private const DAY_ORDER = [
        'Senin' => 1,
        'Selasa' => 2,
        'Rabu' => 3,
        'Kamis' => 4,
        'Jumat' => 5,
        'Sabtu' => 6,
        'Minggu' => 7,
    ];

    public function index(): Response
    {
        $doctors = Doctor::with(['department:id,name', 'schedules'])
            ->orderBy('name')
            ->get();

        $departments = Department::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name']);

        return Inertia::render('Admin/Doctors/Index', [
            'doctors' => $doctors,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:150',
            'specialization' => 'required|string|max:150',
            'sub_specialization' => 'nullable|string|max:150',
            'sip_number' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'bio' => 'nullable|string',
            'consultation_fee' => 'nullable|string|max:60',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:4096',
            'schedules' => 'nullable|array',
            'schedules.*.day_of_week' => 'required|string',
            'schedules.*.start_time' => 'required|string',
            'schedules.*.end_time' => 'required|string',
            'schedules.*.room' => 'nullable|string',
            'schedules.*.quota' => 'nullable|integer|min:1',
        ]);

        $photoPath = '/images/hospital/doctors/doctor-1.jpg';
        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/doctors');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('photo');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $photoPath = '/uploads/doctors/' . $filename;
        }

        $doctor = Doctor::create([
            'department_id' => $validated['department_id'],
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
            'specialization' => $validated['specialization'],
            'sub_specialization' => $validated['sub_specialization'] ?? null,
            'sip_number' => $validated['sip_number'] ?? null,
            'photo' => $photoPath,
            'education' => $validated['education'] ?? null,
            'experience_years' => $validated['experience_years'] ?? 5,
            'bio' => $validated['bio'] ?? null,
            'consultation_fee' => $validated['consultation_fee'] ?? null,
            'is_featured' => $validated['is_featured'] ?? false,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $this->syncSchedules($doctor, $validated['schedules'] ?? []);

        return back()->with('success', 'Data dokter dan jadwal praktik berhasil ditambahkan.');
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:150',
            'specialization' => 'required|string|max:150',
            'sub_specialization' => 'nullable|string|max:150',
            'sip_number' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:60',
            'bio' => 'nullable|string',
            'consultation_fee' => 'nullable|string|max:60',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:4096',
            'schedules' => 'nullable|array',
            'schedules.*.day_of_week' => 'required|string',
            'schedules.*.start_time' => 'required|string',
            'schedules.*.end_time' => 'required|string',
            'schedules.*.room' => 'nullable|string',
            'schedules.*.quota' => 'nullable|integer|min:1',
        ]);

        $data = collect($validated)->except(['photo', 'schedules'])->toArray();

        if ($request->hasFile('photo')) {
            $dir = public_path('uploads/doctors');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('photo');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $data['photo'] = '/uploads/doctors/' . $filename;
        }

        $doctor->update($data);

        if ($request->has('schedules')) {
            $this->syncSchedules($doctor, $validated['schedules'] ?? []);
        }

        return back()->with('success', 'Profil & jadwal dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();
        return back()->with('success', 'Data dokter berhasil dihapus.');
    }

    private function syncSchedules(Doctor $doctor, array $schedules): void
    {
        $doctor->schedules()->delete();
        foreach ($schedules as $sch) {
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => $sch['day_of_week'],
                'day_order' => self::DAY_ORDER[$sch['day_of_week']] ?? 1,
                'start_time' => $sch['start_time'],
                'end_time' => $sch['end_time'],
                'room' => $sch['room'] ?? null,
                'quota' => $sch['quota'] ?? 20,
                'is_active' => true,
            ]);
        }
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 1;
        while (Doctor::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}

