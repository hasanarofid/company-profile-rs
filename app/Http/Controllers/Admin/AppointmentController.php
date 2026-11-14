<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Appointment::with(['department:id,name', 'doctor:id,name,specialization'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_phone', 'like', "%{$search}%");
            });
        }

        $appointments = $query->get();

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'filters' => [
                'status' => $request->input('status', ''),
                'search' => $request->input('search', ''),
            ],
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Status janji temu ' . $appointment->booking_code . ' diperbarui.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();
        return back()->with('success', 'Data janji temu berhasil dihapus.');
    }
}
