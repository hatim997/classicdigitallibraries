<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\Course;
use App\Models\Review;
use App\Models\Subcourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::find(auth()->user()->id);
            if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
                $totalUsers = User::count();
                $totalDeactivatedUsers = User::where('is_active', 'inactive')->count();
                $totalActiveUsers = User::where('is_active', 'active')->count();
                $totalUnverifiedUsers = User::where('email_verified_at', null)->count();
                $totalArchivedUsers = User::onlyTrashed()->count();

                $totalCourses = Course::count();
                $totalSubCourses = Subcourse::count();
                $totalReviews = Review::count();
                $totalEpisodes = Biodata::count();
                return view('dashboard.index', compact('totalUsers', 'totalDeactivatedUsers', 'totalActiveUsers', 'totalUnverifiedUsers', 'totalArchivedUsers','totalCourses','totalSubCourses','totalReviews','totalEpisodes'));
            }else{
                return redirect()->route('frontend.home');
            }
        } catch (\Throwable $th) {
            Log::error('Dashboard Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
