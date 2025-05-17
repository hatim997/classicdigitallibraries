<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\Course;
use App\Models\Subcourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view episode');
        try {
            return view('dashboard.episodes.index');
        } catch (\Throwable $th) {
            Log::error('Episodes Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Biodata::select(['id', 'namaSiswa', 'episode', 'folder', 'is_new', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('episode', function ($row) {
                        if ($row->is_new == 1) {
                            return '<a href="' . $row->folder . '" target="_blank">'. $row->episode .'</a>';
                        }else{
                            return '<a href="' . $row->folder . '" target="_blank">'. $row->folder .'</a>';
                        }
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->is_new == 1) {
                            return '<span class="badge me-4 bg-label-success">New</span>';
                        }else{
                            return '<span class="badge me-4 bg-label-secondary">Old</span>';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('update episode')) {
                            $btn .= '<a href="' . route('dashboard.episodes.edit', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Episode"><i class="ti ti-edit"></i></a>';
                        }
                        if (auth()->user()->can('delete episode')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.episodes.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Episode"><i class="ti ti-trash"></i></button>
                                    </form>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['episode', 'status', 'action'])
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
        $this->authorize('create episode');
        try {
            $courses = Course::all();
            $subcourses = Subcourse::all();
            return view('dashboard.subcourses.create', compact('courses','subcourses'));
        } catch (\Throwable $th) {
            Log::error('episode Create Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('create episode');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'episode' => 'required|string|max:255',
            'folder' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'sub_course_id' => 'required|exists:subcourses,id',
            'is_new' => 'nullable|in:on',
        ]);

        if ($validator->fails()) {
            Log::error('episode Store Validation Failed', ['error' => $validator->errors()->all()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $isNew = isset($request->is_new) && $request->is_new == 'on' ? 1 : null;
            $episode = new Biodata();
            $episode->namaSiswa = $request->name;
            $episode->episode = $request->episode;
            $episode->folder = $request->folder;
            $episode->course_id = $request->course_id;
            $episode->sub_course_id = $request->sub_course_id;
            $episode->is_new = $isNew;
            $episode->save();

            DB::commit();
            return redirect()->route('dashboard.episodes.index')->with('success', 'Episode Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Episode Store Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update episode');
        try {
            $episode = Biodata::findOrFail($id);
            $courses = Course::all();
            $subcourses = Subcourse::all();
            return view('dashboard.episodes.edit', compact('courses','episode','subcourses'));
        } catch (\Throwable $th) {
            Log::error('episode Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update episode');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'episode' => 'required|string|max:255',
            'folder' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'sub_course_id' => 'required|exists:subcourses,id',
            'is_new' => 'nullable|in:on',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $isNew = isset($request->is_new) && $request->is_new == 'on' ? 1 : null;
            $episode = Biodata::findOrFail($id);
            $episode->namaSiswa = $request->name;
            $episode->episode = $request->episode;
            $episode->folder = $request->folder;
            $episode->course_id = $request->course_id;
            $episode->sub_course_id = $request->sub_course_id;
            $episode->is_new = $isNew;
            $episode->save();

            return redirect()->route('dashboard.episodes.index')->with('success', 'Episode Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('episode Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete episode');
        try {
            $episode = Biodata::findOrFail($id);
            $episode->delete();
            return redirect()->back()->with('success', 'Episode Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('episode Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
