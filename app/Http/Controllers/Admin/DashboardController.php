<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Career;
use App\Models\CareerApplication;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'appointments_total' => Appointment::count(),
                'appointments_pending' => Appointment::where('status', 'pending')->count(),
                'doctors_active' => Doctor::where('is_active', true)->count(),
                'departments_active' => Department::where('is_active', true)->count(),
                'careers_active' => Career::where('is_active', true)->count(),
                'applications_total' => CareerApplication::count(),
                'articles_published' => Post::where('status', 'published')->count(),
            ],
            'recentAppointments' => Appointment::with(['department:id,name', 'doctor:id,name'])
                ->latest()
                ->take(5)
                ->get(),
            'recentApplications' => CareerApplication::with('career:id,title,category')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
