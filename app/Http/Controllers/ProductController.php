<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cellar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $productsQuery = Product::query();
        
        // Obtener el ID de la bodega predeterminada
        $defaultCellarId = Cellar::where('predeterminada', 1)->value('id');
        
        // Seleccionar campos y sumar la cantidad
        $productsQuery->select(
            'products.id',
            'products.codigo',
            'products.descripcion',
            'products.precio',
            'products.iva_compra',
            'products.iva_venta',
            'products.marca',
            'products.categoria',
            'products.estado'
        );
        
        $productsQuery->selectRaw(
            'SUM(CASE WHEN cellar_product.cellar_id = ? THEN cellar_product.cantidad ELSE 0 END) AS Cantidad_Total',
            [$defaultCellarId]
        );
        
        $productsQuery->leftJoin('cellar_product', 'products.id', '=', 'cellar_product.product_id');
        
        // Incluir todas las columnas en la cláusula group by
        $productsQuery->groupBy(
            'products.id',
            'products.codigo',
            'products.descripcion',
            'products.precio',
            'products.iva_compra',
            'products.iva_venta',
            'products.marca',
            'products.categoria',
            'products.estado'
        );

        if ($search) {
            $searchableFields = ['codigo', 'descripcion', 'tipo_producto', 'precio', 'marca', 'categoria'];

            $productsQuery->where(function ($query) use ($searchableFields, $search) {
                foreach ($searchableFields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $search . '%');
                }
            });
        }

        // Paginar los resultados
        $productsQuery = $productsQuery->paginate($perPage);

        return response()->json($productsQuery);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->input('search');

        $productsQuery = Product::query();
        $productsQuery->select('products.id', 'products.codigo', 'products.descripcion', 'products.precio', 'products.iva_compra', 'products.iva_venta', 'products.marca', 'products.categoria', 'products.estado');
        $productsQuery->selectRaw('SUM(cellar_product.cantidad) AS Cantidad_Total');
        $productsQuery->leftJoin('cellar_product', 'products.id', '=', 'cellar_product.product_id');
        $productsQuery->groupBy('products.id', 'products.descripcion', 'products.precio');
        // Filtrar solo productos activos
        $productsQuery->whereNotIn('products.estado', ['en espera', 'descontinuado']);

        if ($search) {
            $searchableFields = ['codigo', 'descripcion', 'marca', 'categoria']; // Campos que se pueden buscar

            $productsQuery->where(function ($query) use ($searchableFields, $search) {
                foreach ($searchableFields as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $search . '%');
                }
            });
        }

        $productsQuery = $productsQuery->get();

        return response()->json($productsQuery);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:products',
            'descripcion' => 'required',
            'precio' => 'required',
            'iva_compra' => 'required',
            'iva_venta' => 'required',
            'marca' => 'nullable',
            'categoria' => 'nullable',
            'estado' => 'nullable|in:activo,descontinuado,en espera'
        ]);

        if (Cellar::count() === 0) {
            return response()->json(['error' => 'No tienes bódegas creadas'], 404);
        }

        $cellar = Cellar::where('predeterminada', 1)->first();
        $product = Product::create($request->all());
        $cellar->products()->attach($product->id, ['cantidad' => 0]);

        return response()->json(['message' => 'Producto creado exitosamente']);
    }

    public function show($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $request->validate([
            'codigo' => 'unique:products,codigo,' . $product->id,
            'descripcion' => 'required',
            'precio' => 'required',
            'iva_compra' => 'required',
            'iva_venta' => 'required',
            'marca' => 'nullable',
            'categoria' => 'nullable',
            'estado' => 'nullable|in:activo,descontinuado,en espera'
        ]);

        $product->update($request->all());

        return response()->json(['message' => 'Producto actualizado exitosamente']);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente']);
    }
}
