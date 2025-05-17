<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view course');
        try {
            return view('dashboard.courses.index');
        } catch (\Throwable $th) {
            Log::error('Courses Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Course::select(['id', 'name', 'image', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('image', function ($row) {
                        return $row->image
                            ? '<img src="' . asset('courses/' . $row->image) . '" height="35" width="35"/>'
                            : 'No Image';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('update course')) {
                            $btn .= '<a href="' . route('dashboard.courses.edit', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Course"><i class="ti ti-edit"></i></a>';

                            $btn .= '<a href="' . route('dashboard.courses.reviews', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="View Course Reviews"><i class="ti ti-message"></i></a>';
                        }
                        if (auth()->user()->can('delete course')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.courses.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Course"><i class="ti ti-trash"></i></button>
                                    </form>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['image', 'action'])
                    ->make(true);

            } catch (\Throwable $e) {
                return response()->json(['error' => 'Something went wrong while fetching data.'], 500);
            }
        } else {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create course');
        try {
            return view('dashboard.courses.create');
        } catch (\Throwable $th) {
            Log::error('course Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->authorize('create course');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validator->fails()) {
            Log::error('course Store Validation Failed', ['error' => $validator->errors()->all()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $course = new Course();
            $course->name = $request->name;
            if ($request->hasFile('image')) {
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'courses';
                $Image->move(public_path($Image_path), $Image_name);
                $course->image = $Image_name;
            }

            $course->save();

            DB::commit();
            return redirect()->route('dashboard.courses.index')->with('success', 'Course Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Course Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
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
        $this->authorize('update course');
        try {
            $course = Course::findOrFail($id);
            return view('dashboard.courses.edit', compact('course'));
        } catch (\Throwable $th) {
            Log::error('Course Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update course');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $course = Course::findOrFail($id);
            $course->name = $request->name;
            if ($request->hasFile('image')) {
                if (isset($course->image) && File::exists(public_path('courses/'.$course->image))) {
                    File::delete(public_path('courses/'.$course->image));
                }
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'courses';
                $Image->move(public_path($Image_path), $Image_name);
                $course->image = $Image_name;
            }

            $course->save();

            return redirect()->route('dashboard.courses.index')->with('success', 'Course Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Course Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete course');
        try {
            $course = Course::findOrFail($id);
            if (isset($course->image) && File::exists(public_path('courses/'.$course->image))) {
                File::delete(public_path('courses/'.$course->image));
            }
            $course->delete();
            return redirect()->back()->with('success', 'Course Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Course Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviews($id)
    {
        $this->authorize('view course');
        try {
            $course = Course::findOrFail($id);
            $reviews = Review::with('user')->where('course_id', $id)->orderBy('id','desc')->get();
            return view('dashboard.courses.reviews.index', compact('course','reviews'));
        } catch (\Throwable $th) {
            Log::error('Course Reviews Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviewCreate($id)
    {
        $this->authorize('update course');
        try {
            $course = Course::findOrFail($id);
            return view('dashboard.courses.reviews.create', compact('course'));
        } catch (\Throwable $th) {
            Log::error('Course Reviews Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviewStore(Request $request, string $id)
    {
        $this->authorize('update course');
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|max:5|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $course = Course::findOrFail($id);
            $review = new Review();
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->course_id = $id;
            $review->user_id = auth()->user()->id;
            $review->save();
            return redirect()->route('dashboard.courses.reviews', $id)->with('success', 'Review Created Successfully');
        } catch (\Throwable $th) {
            Log::error('Course Reviews Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviewEdit($id)
    {
        $this->authorize('update course');
        try {
            $review = Review::findOrFail($id);
            return view('dashboard.courses.reviews.edit', compact('review'));
        } catch (\Throwable $th) {
            Log::error('Course Reviews Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviewUpdate(Request $request, string $id)
    {
        $this->authorize('update course');
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|max:5|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $review = Review::findOrFail($id);
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();

            return redirect()->route('dashboard.courses.reviews', $review->course_id)->with('success', 'Review Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Course Reviews Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function courseReviewDestroy(string $id)
    {
        $this->authorize('update course');
        try {
            $review = Review::findOrFail($id);
            $review->delete();
            return redirect()->back()->with('success', 'Review Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Course Reviews Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
