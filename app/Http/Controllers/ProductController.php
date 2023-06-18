<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; //php artisan storage:link = php artisan storage:link = http://127.0.0.1:8000/storage/1.jpg
 
class ProductController extends Controller
{
    public function index()
    {
       // All Product
       $products = Product::all();
      
       // Return Json Response
       return response()->json([
          'products' => $products
       ],200);
    }
  
    public function store(ProductStoreRequest $request)
    {
        try {
            $imageName = Str::random(5).".".$request->image->getClientOriginalExtension();
      
            // Create Product
            Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'image' => $imageName,
                'description' => $request->description
            ]);
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
      
            // Return Json Response
            return response()->json([
                'message' => "Product successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function show($id)
    {
       // Product Detail 
       $product = Product::find($id);
       if(!$product){
         return response()->json([
            'message'=>'Product Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'product' => $product
       ],200);
    }
  
    public function update(ProductStoreRequest $request, $id)
    {
        try {
            // Find product
            $product = Product::find($id);
            if(!$product){
              return response()->json([
                'message'=>'Product Not Found.'
              ],404);
            }
      
            //echo "request : $request->image";
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            if($request->image){
                // Public storage
                $storage = Storage::disk('public');
                // Old iamge delete
                if($storage->exists($product->image))
                    $storage->delete($product->image);
      
                // Image name
                $imageName = Str::random(5).".".$request->image->getClientOriginalExtension();
                $product->image = $imageName;
      
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }
      
            // Update Product
            $product->save();
      
            // Return Json Response
            return response()->json([
                'message' => "Product successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
  
    public function destroy($id)
    {
        // Detail 
        $product = Product::find($id);
        if(!$product){
          return response()->json([
             'message'=>'Product Not Found.'
          ],404);
        }
      
        // Public storage
        $storage = Storage::disk('public');
      
        // Iamge delete
        if($storage->exists($product->image))
            $storage->delete($product->image);
      
        // Delete Product
        $product->delete();
      
        // Return Json Response
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }
    // function addProduct(Request $req)
    // {
    //     $product = new Product;
    //     $product->name = $req->input('name');
    //     $product->price = $req->input('price');
    //     $product->description = $req->input('description');
    //     // $product->image = $req->file('image')->store('products');
    //     $product->save();
    //     return $product;
    // }
    // function list()
    // {
    //     return Product::all();
    // }
    // function delete($id)
    // {
    //     $result = Product::where('id', $id)->delete();
    //     if ($result) {
    //         return ["success" => "Product has been delete"];
    //     } else {
    //         return ["error" => "Operation faild"];
    //     }
    // }
    // function getProduct($id)
    // {
    //     $product = Product::find($id);
    //     return response()->json([
    //         'status' => 200,
    //         'Product' => $product,
    //     ]);
    // }

    // function updateProduct($id, Request $req)
    // {
    //     $product = Product::find($id);
    //     $product->name = $req->input('name');
    //     $product->price = $req->input('price');
    //     $product->description = $req->input('description');
    //     if ($req->file('file')) {
    //         $product->image = $req->file('file')->store('products');
    //     }
    //     $product->update();
    //     return response()->json([
    //         'status' => 200,
    //         'massage' => "Product Update successfully",
    //     ]);
    // }
    // function search($key)
    // {
    //     return Product::where('name', 'Like', "%$key%")->get();
    // }

}