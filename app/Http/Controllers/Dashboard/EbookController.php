<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view ebook');
        try {
            return view('dashboard.ebooks.index');
        } catch (\Throwable $th) {
            Log::error('Ebooks Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Ebook::select(['id', 'name', 'image', 'ebook', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('image', function ($row) {
                        return $row->image
                            ? '<img src="' . asset($row->image) . '" height="35" width="35"/>'
                            : 'No Image';
                    })
                    ->addColumn('ebook', function ($row) {
                        return $row->ebook
                            ? '<a href="' . asset($row->ebook) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"><i class="ti ti-file"></i></a>'
                            : 'No Image';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('update ebook')) {
                            $btn .= '<a href="' . route('dashboard.ebooks.edit', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Ebook"><i class="ti ti-edit"></i></a>';
                        }
                        if (auth()->user()->can('delete ebook')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.ebooks.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Ebook"><i class="ti ti-trash"></i></button>
                                    </form>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['image', 'ebook', 'action'])
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
        $this->authorize('create ebook');
        try {
            return view('dashboard.ebooks.create');
        } catch (\Throwable $th) {
            Log::error('ebook Create Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('create ebook');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max_size',
            'ebook' => 'required|file|max_size',
        ]);

        if ($validator->fails()) {
            Log::error('ebook Store Validation Failed', ['error' => $validator->errors()->all()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $ebook = new Ebook();
            $ebook->name = $request->name;
            if ($request->hasFile('image')) {
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/ebook/images';
                $Image->move(public_path($Image_path), $Image_name);
                $ebook->image = $Image_path . "/" . $Image_name;
            }
            if ($request->hasFile('ebook')) {
                $Image = $request->file('ebook');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_ebook.' . $Image_ext;

                $Image_path = 'uploads/ebook';
                $Image->move(public_path($Image_path), $Image_name);
                $ebook->ebook = $Image_path . "/" . $Image_name;
            }

            $ebook->save();

            DB::commit();
            return redirect()->route('dashboard.ebooks.index')->with('success', 'Ebook Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Ebook Store Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update ebook');
        try {
            $ebook = Ebook::findOrFail($id);
            return view('dashboard.ebooks.edit', compact('ebook'));
        } catch (\Throwable $th) {
            Log::error('ebook Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update ebook');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'ebook' => 'nullable|file|max_size',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $ebook = Ebook::findOrFail($id);
            $ebook->name = $request->name;
            if ($request->hasFile('image')) {
                if (isset($ebook->image) && File::exists(public_path($ebook->image))) {
                    File::delete(public_path($ebook->image));
                }
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/ebook/images';
                $Image->move(public_path($Image_path), $Image_name);
                $ebook->image = $Image_path . "/" . $Image_name;
            }
            if ($request->hasFile('ebook')) {
                if (isset($ebook->ebook) && File::exists(public_path($ebook->ebook))) {
                    File::delete(public_path($ebook->ebook));
                }
                $Image = $request->file('ebook');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_ebook.' . $Image_ext;

                $Image_path = 'uploads/ebook';
                $Image->move(public_path($Image_path), $Image_name);
                $ebook->ebook = $Image_path . "/" . $Image_name;
            }

            $ebook->save();

            return redirect()->route('dashboard.ebooks.index')->with('success', 'Ebook Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Ebook Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete ebook');
        try {
            $ebook = Ebook::findOrFail($id);
            if (isset($ebook->image) && File::exists(public_path($ebook->image))) {
                File::delete(public_path($ebook->image));
            }
            if (isset($ebook->ebook) && File::exists(public_path($ebook->ebook))) {
                File::delete(public_path($ebook->ebook));
            }
            $ebook->delete();
            return redirect()->back()->with('success', 'Ebook Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Ebook Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
