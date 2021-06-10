<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class UserController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return Datatables::of($query)
            ->addColumn('action', function($item){
                return '
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a href="'.route('user.edit', $item->id).'" class="dropdown-item">Edit</a>
                                <form action="'.route('user.destroy', $item->id).'" method="POST">
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
        return view('pages.admin.user.index');
    }

    public function create()
    {
        return view('pages.admin.user.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        User::create($data);

        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('pages.admin.user.edit', compact('item'));
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        $item = User::findOrFail($id);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $item->update($data);

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return redirect()->route('user.index');
    }
}
