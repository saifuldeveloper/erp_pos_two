<?php

namespace App\Http\Controllers;

use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    protected ColorService $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
        $this->middleware('check_permission:color-index|color')->only('index');
        $this->middleware('check_permission:color-add')->only(['create', 'store']);
        $this->middleware('check_permission:color-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:color-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index()
    {
        $colors = $this->colorService->getAllColors();
        return view('backend.color.index', compact('colors'));
    }

    public function store(StoreColorRequest $request)
    {
        $this->colorService->createColor($request->only('name', 'code'));

        return redirect()->route('color.index');
    }

    public function edit(string $id)
    {
        return $this->colorService->getColorById($id);
    }

    public function update(UpdateColorRequest $request, string $id)
    {
        $this->colorService->updateColor($request->color_id, $request->only('name', 'code'));

        return redirect()->route('color.index');
    }

    public function deleteBySelection(Request $request)
    {
        $color_id = $request['colorIdArray'] ?? [];
        $this->colorService->deleteMultipleColors($color_id);

        return 'Color deleted successfully!';
    }

    public function destroy(string $id)
    {
        $this->colorService->deleteColor($id);

        return redirect()->route('color.index');
    }
}
