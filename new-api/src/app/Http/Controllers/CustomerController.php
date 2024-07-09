<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::get();
        if(!$data) { // Jika tidak ada data
            return response()->json([
                'success' => False,
                'message' => 'Customers Not Found',
            ]);
        } else {
            return response()->json([
                'success' => True,
                'message' => 'Success Retrive Data',
                'data' => $data
            ]);
        };
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $timestamp = \Carbon\Carbon::now()->toDateTimeString();

        // $this->validate($request, [
        //    'full_name' => 'required | string',
        //    'username' => 'required | string',
        //    'email' => 'required | email | unique:customers,email',
        //    'phone_number' => 'required | string'
        // ]);

        $this->validate($request, [
            'data.attributes.full_name' => 'required|string',
            'data.attributes.username' => 'required|string',
            'data.attributes.email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')
            ],
            'data.attributes.phone_number' => 'required|string',
        ]);

        $data = new Customer();
        $data->full_name = $request->input('data.attributes.full_name');
        $data->username = $request->input('data.attributes.username');
        $data->email = $request->input('data.attributes.email');
        $data->phone_number = $request->input('data.attributes.phone_number');
        $data->save();

        // $request['created_at'] = $timestamp;
        // $request['updated_at'] = $timestamp;

        // $data = DB::connection('mysql')->table('customers')->insert($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data successfully stored',
            // 'data' => $data
            'data' => [
                'attributes' => $data,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        if(!$data) { // Jika tidak ada data
            return response()->json([
                'success' => False,
                'message' => 'Customers Not Found',
            ]);
        } else {
            return response()->json([
                'success' => True,
                'message' => 'Success Retrive Data',
                'data' => $data
            ]);
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'data.attributes.full_name' => 'required',
            'data.attributes.username' => 'required',
            'data.attributes.email' => 'required', 'email', Rule::unique('customers', 'email'),
            'data.attributes.phone_number' => 'required',
        ]);

        $data = Customer::find($id);

        if($data) {
            $data->full_name = $request->input('data.attributes.full_name');
            $data->username = $request->input('data.attributes.username');
            $data->email = $request->input('data.attributes.email');
            $data->phone_number = $request->input('data.attributes.phone_number');
            $data->save();

            return response()->json([
                'success' => True,
                'message' => 'Success Retrive Data',
                'data' => [
                    'attributes' => $data
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Not Found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::find($id);
        if($data) {
            $data->delete();
            $result = array(
                "data" => array('arttributes')
            );
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
                'data' => [
                    'attributes' => $data
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Not Found',
            ]);
        }
    }
}
