<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => ['required'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'address' => ['required'],
            ]);

            // Buat Institute baru
            $data = Customer::create([
                'name' => $request->name,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('customer.index')->with('msg', 'Customer ('.$request->name.') has been successfully added');
        }

        $data = Customer::all();
        return view('customer.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $id){
        $data = Customer::findOrFail($id);

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'name' => ['required'],
                'contact_name' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required'],
                'address' => ['required'],
            ]);

            $data->update([
                'name' => $request->name,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);


            return redirect()->route('customer.index')->with('msg', 'Customer '. $request->name .'updated successfully.');
        }

        return view('customer.edit', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function delete(Request $request)
    {
        $data = Customer::findOrFail($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete! Data not found'
            ]);
        }
    }

    public function data(Request $request)
    {
        $data = Customer::all();

        if (!empty($search)) {
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%");
            });
        }

        return DataTables::of($data)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
