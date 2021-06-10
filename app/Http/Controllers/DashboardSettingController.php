<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Category;
use Illuminate\Http\Request;

class DashboardSettingController extends Controller
{
    public function store(){
        $user = Auth::user();
        $categories = Category::all();
        return view('pages.dashboard-settings', compact('user', 'categories'));
    }
    public function account(){
        $user = Auth::user();
        return view('pages.dashboard-accounts', compact('user'));

    }
    public function update(Request $request, $redirect){
        $data = $request->all();
        $item =  Auth::user();
        $item->update($data);
        return redirect()->route($redirect);
    }
}
