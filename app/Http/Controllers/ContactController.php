<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view contact');
        try {
            return view('dashboard.contacts.index');
        } catch (\Throwable $th) {
            Log::error('Contacts Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Contact::select(['id', 'name', 'email', 'message', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('delete contact')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.contacts.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Contact"><i class="ti ti-trash"></i></button>
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
        $this->authorize('delete contact');
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->back()->with('success', 'Contact Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Contact Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
