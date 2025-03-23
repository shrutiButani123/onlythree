<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::query();

        if($request->ajax()) {
                
            if (!empty($request->date_range)) {
                $dates = explode(' to ', $request->date_range);
                if (count($dates) == 2) {
                    $startDate = \Carbon\Carbon::parse($dates[0])->startOfDay();
                    $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            $products = $query->get();

            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('product_name', function ($product) {
                    return $product->name;
                })
                ->editColumn('price', function ($product) {
                    return $product->price;
                })
                ->editColumn('category', function ($product) {
                    return $product->category->name;
                })
                ->editColumn('subcategory', function ($product) {
                    return $product->subcategory->name;
                })
                ->editColumn('created_at', function ($product) {
                    return \Carbon\Carbon::parse($product->created_at)->format('d M Y');
                })
                ->addColumn('actions', function ($product) {
                    return '
                        <a href="'.route('product.show', $product->id).'" class="btn btn-sm btn-info">View</a>
                        <a href="'.route('product.edit', $product->id).'" class="btn btn-sm btn-success d-inline">Edit</a>
                        <form action="'.route('product.destroy', $product->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        $products = $query->get();
        return view('product.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:sub_categories,id',
            'description' => 'nullable',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . rand(0, 1000) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'storage/images/' . $imageName;
        }


        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'image' => $imagePath,
            'description' => $request->description
        ]);        

        $categories = Category::all();
        return redirect()->route('products')->with('success', 'Product created successfully');
    }


    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:sub_categories,id',
            'description' => 'nullable',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = $product->image;
        if($request->hasFile('image')) {
            if(Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . rand(0, 1000) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'storage/images/' . $imageName;
        }


        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'image' => $imagePath,
            'description' => $request->description
        ]);        

        $categories = Category::all();
        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }

    public function show($id)
    {
        $product = Product::with('category', 'subcategory')->findOrFail($id);
        return view('product.show', compact('product'));
    }


    public function subCategory(Request $request) {
        $subcategories = SubCategory::where('category_id', $request->categoryId)->get();
        return response()->json($subcategories);
    }

    public function export(Request $request, $date)
    {
        $query = Product::with(['category', 'subcategory']);

        if (!empty($date)) {
            $dates = explode(' to ', $date);
    
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::parse(trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::parse(trim($dates[1]))->endOfDay();
                    
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Invalid date format.');
                }
            }
        }
    
        $products = $query->get();
    
        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'No products found.');
        }
    
        return Excel::download(new ProductsExport($products), 'products.xlsx');
    }
}
