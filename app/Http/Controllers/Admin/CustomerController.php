<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::latest();

        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('phone', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('city', 'LIKE', '%'.$request->search.'%');
            });
        }

        $customers = $query->paginate(10);

        return view('admin.customers.index',
            compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name'    => 'required|string|max:255|min:2',
        'phone'   => 'required|digits_between:10,15|unique:customers,phone',
        'email'   => 'nullable|email|max:255',
        'address' => 'nullable|string|max:500',
        'city'    => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',
        'state'   => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',
    ], [
        'name.required'        => 'Customer name is required!',
        'name.min'             => 'Name must be at least 2 characters!',
        'phone.required'       => 'Phone number is required!',
        'phone.digits_between' => 'Phone must be 10-15 digits!',
        'phone.unique'         => 'This phone already registered!',
        'email.email'          => 'Please enter a valid email!',
        'city.regex'           => 'City name should contain only letters!',
        'state.regex'          => 'State name should contain only letters!',
    ]);

        Customer::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'address'   => $request->address,
            'city'      => $request->city,
            'state'     => $request->state,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created!');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit',
            compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
        ]);

        $customer->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted!');
    }
}