<?php

namespace App\Http\Controllers\Admin;
use App\ProductGallery;
use App\Product;
use App\Http\Requests\Admin\ProductGalleryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductGalleryController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = ProductGallery::with(['product']);

            return Datatables::of($query)
            ->addColumn('action', function($item){
                return '
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <form action="'.route('product-gallery.destroy', $item->id).'" method="POST">
                                    '. method_field('delete') . csrf_field() .'
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->editColumn('photos', function($item){
                return $item->photos ? '<img src="'. Storage::url($item->photos) .'" style="max-height:80px;"/>' : '';
            })
            ->rawColumns(['action','photos'])
            ->make();

        }
        return view('pages.admin.product-gallery.index');
    }

    public function create()
    {
        $products= Product::all();
        return view('pages.admin.product-gallery.create',
                    ['products' => $products]
                );
    }

    public function store(ProductGalleryRequest $request)
    {
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');
        ProductGallery::create($data);

        return redirect()->route('product-gallery.index');
    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('product-gallery.index');
    }
}
