<?php

namespace App\Http\Controllers;

use App\Models\Entitie;
use Illuminate\Http\Request;

class EntitieController extends Controller
{

    public function index(Request $request)
    {
        $query = Entitie::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $entities = $query->paginate(10);
        $entities->appends($request->all());
        return view('entitie.index', compact('entities'));
    }

    public function create()
    {
        return view('entitie.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:external,internal',
        ]);

        Entitie::create($validated);

        return redirect()->route('entities.index')->with('success','تم اضافة الجهه بنجاح');
    }




    public function edit(Entitie $entity)
    {
        return view('entitie.edit', compact('entity'));
    }

    public function show(Entitie $entity)
    {
        return view('entitie.edit', compact('entity'));
    }


    public function update(Request $request,$id)
    {

            $entity = Entitie::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:internal,external',
            ]);

            $entity->update($validated);

            return redirect()->route('entities.index')->with('success', 'تم تعديل الجهه بنجاح');
    }

    public function destroy(Request $request)
    {   $entitie = Entitie::findOrFail($request->entity_id);
        $entitie->delete();
        return redirect()->route('entities.index')->with('success', 'تم حذف الجهه بنجاح');
    }
}
