<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subcourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SubCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view sub course');
        try {
            return view('dashboard.subcourses.index');
        } catch (\Throwable $th) {
            Log::error('SubCourses Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Subcourse::with('course')->select(['id', 'course_id', 'name', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('course', function ($row) {
                        return $row->course ? $row->course->name : 'N/A';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('update sub course')) {
                            $btn .= '<a href="' . route('dashboard.subcourses.edit', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Course"><i class="ti ti-edit"></i></a>';
                        }
                        if (auth()->user()->can('delete sub course')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.subcourses.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Course"><i class="ti ti-trash"></i></button>
                                    </form>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
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
        $this->authorize('create sub course');
        try {
            $courses = Course::all();
            return view('dashboard.subcourses.create', compact('courses'));
        } catch (\Throwable $th) {
            Log::error('sub course Create Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('create sub course');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            Log::error('course Store Validation Failed', ['error' => $validator->errors()->all()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $subcourse = new Subcourse();
            $subcourse->name = $request->name;
            $subcourse->course_id = $request->course_id;
            $subcourse->save();

            DB::commit();
            return redirect()->route('dashboard.subcourses.index')->with('success', 'Sub Course Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Sub Course Store Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update sub course');
        try {
            $subcourse = Subcourse::findOrFail($id);
            $courses = Course::all();
            return view('dashboard.subcourses.edit', compact('courses','subcourse'));
        } catch (\Throwable $th) {
            Log::error('Sub Course Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update sub course');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $subcourse = Subcourse::findOrFail($id);
            $subcourse->name = $request->name;
            $subcourse->course_id = $request->course_id;
            $subcourse->save();

            return redirect()->route('dashboard.subcourses.index')->with('success', 'Sub Course Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Sub Course Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete sub course');
        try {
            $subcourse = Subcourse::findOrFail($id);
            $subcourse->delete();
            return redirect()->back()->with('success', 'Sub Course Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Sub Course Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
