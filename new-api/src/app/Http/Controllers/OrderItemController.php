<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OrderItem::all();
        if (!$data) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ]);
        }

        Log::info('Showing all order');

        return response()->json([
            'success' => true,
            'message' => 'Success Retrive Data',
            'data' => [
                'attributes' => $data
            ]
        ]);
    }

    public function showDataJoin() {
        $data = OrderItem::with(array('order' => function($query){
            $query->select();
        }))->with(array('product' => function($query){
            $query->select();
        }))->get();
        if(!$data) { // Jika tidak ada data
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
            ]);
        } 
        
        Log::info("Showing All Order Item");

        return response()->json([
            'success' => true,
            'message' => 'Success Retrive Data',
            'data' => [
                'attributes' => $data
            ]
        ]);
    }

    public function showIdJoin($id)
    {
        $findId = OrderItem::find($id);
        $data = OrderItem::where('id', $id)->with(array('order'=>function($query){
            $query->select();
        }))->get();
        if(!$findId) {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing order item with post comment by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => [
                'attributes' => $data
            ]
        ]);
    }

    public function show($id)
    {
        $data = OrderItem::find($id);
        if(!$data) {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }

        Log::info('Showing order with post comment by id');

        return response()->json([
            "success" => true,
            "message" => "Success retrieve data",
            "data" => [
                'attributes' => $data
            ]
        ]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'data.attributes.order_id' => 'required|exists:orders,id',
            'data.attributes.product_id' => 'required|exists:products,id',
            'data.attributes.quantity' => 'required',
        ]);

        $data = new OrderItem();
        $data->order_id = $request->input('data.attributes.order_id');
        $data->product_id = $request->input('data.attributes.product_id');
        $data->quantity = $request->input('data.attributes.quantity');
        $data->save();

        Log::info('Adding order item');

        return response()->json([
            "success" => true,
            "message" => "Successfully Added",
            "data" => [
                "attributes" => $data
            ]
        ]); 
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'data.attributes.order_id' => 'required|exists:orders,id',
            'data.attributes.product_id' => 'required|exists:products,id',
            'data.attributes.quantity' => 'required',
        ]);

        $data = OrderItem::find($id);

        if($data) {
            $data->order_id = $request->input('data.attributes.order_id');
            $data->product_id = $request->input('data.attributes.product_id');
            $data->quantity = $request->input('data.attributes.quantity');
            $data->save();

            Log::info('Updating order item by id');

            return response()->json([
                "success" => true,
                "message" => "Successfully Updated",
                "data" => [
                    "attributes" => $data
                ]
            ]);        
        } else {
            return response()->json([
                "message" => "Parameter Not Found"
            ]);
        }
    }

    public function delete($id)
    {
        $data = OrderItem::find($id);
        if($data) {
            $data->delete();

            Log::info('Deleting order item by id');

            return response()->json([
                "success" => true,
                "message" => "Successlly Deleted",
                "data" => [
                    "attributes" => $data
                ]
            ]);   
        } else {
            return response()->json([
                "success" => false,
                "message" => "Parameter Not Found"
            ]);
        }
    }
}