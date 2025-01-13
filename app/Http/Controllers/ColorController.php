<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('backend.color.index', compact('colors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors',
        ]);


        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();

        return redirect()->route('color.index');
    }

    public function edit(string $id)
    {
        $color = Color::find($id);
        return $color;
    }

    public function update(Request $request, string $id)
    {
        $color = Color::find($request->color_id);
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();

        return redirect()->route('color.index');
    }

    public function destroy(string $id)
    {
        $color = Color::find($id);
        $color->delete();

        return redirect()->route('color.index');
    }
}
