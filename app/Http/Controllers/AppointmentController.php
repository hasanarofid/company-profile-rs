<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function create(Request $request): Response
    {
        $departments = Department::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name', 'slug', 'location']);

        $doctors = Doctor::with(['department:id,name,slug', 'schedules' => fn ($q) => $q->where('is_active', true)])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Appointments/Create', [
            'departments' => $departments,
            'doctors' => $doctors,
            'preselectedDoctorId' => $request->integer('doctor_id') ?: null,
            'preselectedDepartmentId' => $request->integer('department_id') ?: null,
            'bookingResult' => session('bookingResult'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:50',
            'patient_name' => 'required|string|max:120',
            'patient_phone' => 'required|string|max:30',
            'patient_email' => 'nullable|email|max:120',
            'patient_dob' => 'nullable|date',
            'patient_nik' => 'nullable|string|max:30',
            'payment_type' => 'required|in:Umum,BPJS Kesehatan,Asuransi Swasta',
            'complaint' => 'nullable|string|max:1000',
        ]);

        $bookingCode = 'APT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        while (Appointment::where('booking_code', $bookingCode)->exists()) {
            $bookingCode = 'APT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        }

        $appointment = Appointment::create(array_merge($validated, [
            'booking_code' => $bookingCode,
            'status' => 'pending',
        ]));

        $appointment->load(['department:id,name', 'doctor:id,name,specialization']);

        return redirect()->route('appointments.create')->with('bookingResult', [
            'booking_code' => $appointment->booking_code,
            'patient_name' => $appointment->patient_name,
            'patient_phone' => $appointment->patient_phone,
            'department_name' => $appointment->department?->name,
            'doctor_name' => $appointment->doctor?->name,
            'appointment_date' => $appointment->appointment_date?->format('d M Y'),
            'appointment_time' => $appointment->appointment_time,
            'payment_type' => $appointment->payment_type,
        ]);
    }
}
