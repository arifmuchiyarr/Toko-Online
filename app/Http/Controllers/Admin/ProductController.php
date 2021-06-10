<?php

namespace App\Http\Controllers\Admin;
use App\Product;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\User;
use App\Category;
class ProductController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with(['user', 'category']);

            return Datatables::of($query)
            ->addColumn('action', function($item){
                return '
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a href="'.route('product.edit', $item->id).'" class="dropdown-item">Edit</a>
                                <form action="'.route('product.destroy', $item->id).'" method="POST">
                                    '. method_field('delete') . csrf_field() .'
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make()
            ;

        }
        return view('pages.admin.product.index');
    }

    public function create()
    {
        $users= User::all();
        $categories= Category::all();
        return view('pages.admin.product.create',
                    ['users' => $users,
                    'categories' => $categories]
                );
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        Product::create($data);

        return redirect()->route('product.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $categories= Category::all();
        $users= User::all();
        return view('pages.admin.product.edit', compact('item', 'categories', 'users'));
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $item = Product::findOrFail($id);
        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }
}
