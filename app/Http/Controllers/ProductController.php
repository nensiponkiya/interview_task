<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display all products in DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::all();
            return DataTables::of($products)
                ->addColumn('action', function ($row) {
                    return '<button class="edit-btn btn btn-warning" data-id="' . $row->id . '">Edit</button>
                            <button class="delete-btn btn btn-danger" data-id="' . $row->id . '">Delete</button>';
                })
                ->editColumn('product_image', function ($row) {

                  //  return asset('storage/' . $row->product_image);
                    //return 'storage/' . $row->product_image;
                    // Check if product_image is set and return the appropriate HTML
                    return $row->product_image ? '<img src="' . asset('storage/' . $row->product_image) . '" width="50">' : 'No Image';
                })
                ->rawColumns(['action','product_image'])
                ->make(true);
        }
        return view('products.index');
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        // Store product image if uploaded
        if ($request->hasFile('product_image')) {
            $imageName = $request->file('product_image')->store('product_images', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'product_image' => $imageName,
        ]);

        return response()->json(['success' => 'Product added successfully']);
    }

    // Edit a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

// Update product details
public function update(Request $request, $id)
{

    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = Product::find($id);

    $imageName = $product->product_image;
    // Handle product image update if uploaded
    if ($request->hasFile('product_image')) {
        // Delete old image if exists
        if ($imageName) {
            Storage::delete('public/' . $imageName);
        }
        $imageName = $request->file('product_image')->store('product_images', 'public');
    }

    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'product_image' => $imageName,
    ]);

    return response()->json(['success' => 'Product updated successfully']);
}

// Delete a product
public function destroy($id)
{
    $product = Product::find($id);
    if ($product->product_image) {
        Storage::delete('public/' . $product->product_image);
    }
    $product->delete();

    return response()->json(['success' => 'Product deleted successfully']);
}

}
