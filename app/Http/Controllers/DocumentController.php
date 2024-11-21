<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Entitie;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentDetails;

use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         // Fetch all entities for the dropdown or other UI elements
         $entities = Entitie::all();

         // Initialize the query builder
         $query = Document::query();

         // Apply filters based on the request
         if ($request->has('name') && !empty($request->name)) {
             $query->where('documents.name', 'like', '%' . $request->name . '%');
         }

         if ($request->has('date') && !empty($request->date)) {
             $query->whereDate('documents.date', '=', $request->date);
         }

         if ($request->has('type') && !empty($request->type) && $request->type != 'all') {
             $query->where('documents.type', $request->type);
         }

         if ($request->has('nots') && !empty($request->nots)) {
             $query->where('documents.nots', 'like', '%' . $request->nots . '%');
         }

         if ($request->has('entity_id') && !empty($request->entity_id) && $request->entity_id != 'all') {
             $query->where(function ($q) use ($request) {
                 $q->where('documents.entity_id', $request->entity_id)
                   ->orWhere('documents.branch_id', $request->entity_id);
             });
         }

         if(auth()->user()->entity_id != 10 && auth()->user()->entity_id != 16){
            $query->where(function ($q) {
                $q->where('documents.branch_id', auth()->user()->entity_id)
                  ->orWhere('documents.entity_id', auth()->user()->entity_id);
            });
         }


         // Execute the query and paginate the results
         $docs = $query->paginate(10);

         // Append filters to the pagination links
         $docs->appends($request->all());

         // Return the view with the filtered results and entities
         return view('document.index', compact('docs', 'entities'));
     }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entities = Entitie::where('id',"!=",Auth::user()->entity_id)->get();
        return view('document.create',compact('entities'));
    }



    public function store(Request $request,FlasherInterface $flasher)
    {

        $request->validate([
            'photos.*' => 'required|mimes:jpg,jpeg,png,pdf,docx',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'nots' => 'nullable|string',
            'type' => 'required',
            'entity_id'=>'required',

        ], [
            'photos.*.required' => 'يجب تحميل الصور أو الملفات.',
            'photos.*.mimes' => 'الملفات يجب أن تكون بصيغ jpg, jpeg, png, pdf, أو docx.',
            //'photos.*.max' => 'حجم كل ملف يجب ألا يتجاوز 10 ميغابايت.',
            'name.required' => 'الاسم هو حقل مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب أن يكون أقل من 255 حرفًا.',
            'date.required' => 'تاريخ الأرشفة هو حقل مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
            'nots.string' => 'الملاحظات يجب أن تكون نصًا.',
            'type.required' => 'نوع الجهه هو حقل مطلوب.',
            'entity_id.required' => ' الجهه هو حقل مطلوب.',
        ]);


        // Store the main document information
        $document = Document::create([

            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'nots' => $request->input('nots'),
            'entity_id'=>$request->entity_id,
            'type'=>$request->type,
            'created_by'=>Auth::user()->id,
            'branch_id'=>auth()->user()->entity_id,

        ]);

        // Handle multiple file uploads
        if ($request->hasFile('photos')) {

            foreach ($request->file('photos') as $file) {
                $today = now();
                $filename = time() . '_' . $file->getClientOriginalName();
                $pathForDb = "documents/".$today->year."/".$today->month."/".$today->day."/".$document->name."/".time() . '_' . $file->getClientOriginalName();
                $path = "documents/".$today->year."/".$today->month."/".$today->day."/".$document->name;
                $name = $request->name;
                $path = $file->storeAs($path,$filename,'public');
                DocumentDetails::create([
                   'document_id' => $document->id,
                   'filename' => $file->getClientOriginalName(),
                   'path' => $path,
                ]);
            }

            return redirect()->route('documents.index')->with('success', 'تم تحميل الملفات بنجاح');
        }

        // Return an error if no files were uploaded
        return back()->with('
        ', 'لا يوجد ملفات للتحميل');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doc = Document::with('documentDetails')->findOrFail($id);
        return view('document.show',compact('doc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doc = Document::with('documentDetails')->findOrFail($id);
        if($doc->type == 1 || $doc->type == 3){
            $entities = Entitie::where('id',"!=",Auth::user()->entity_id)->where('type','internal')->get();
        }else{
            $entities = Entitie::where('id',"!=",Auth::user()->entity_id)->where('type','external')->get();

        }


        return view('document.edit',compact('doc','entities'));
    }

    /**
     * Update the specified resource in storage.
     */

        public function update(Request $request, FlasherInterface $flasher, $id)
        {
            $request->validate([
                'photos.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048',
                'name' => 'required|string|max:255',
                'date' => 'required|date',
                'nots' => 'nullable|string|max:500',
                'type' => 'required',
                'entity_id' => 'required',
            ], [
                'photos.*.required' => 'يجب تحميل الصور أو الملفات.',
                'photos.*.mimes' => 'الملفات يجب أن تكون بصيغ jpg, jpeg, png, pdf, أو docx.',
                'photos.*.max' => 'الحد الأقصى لحجم الملف هو 2 ميجابايت.',
                'name.required' => 'الاسم هو حقل مطلوب.',
                'name.string' => 'الاسم يجب أن يكون نصًا.',
                'name.max' => 'الاسم يجب أن يكون أقل من 255 حرفًا.',
                'date.required' => 'تاريخ الأرشفة هو حقل مطلوب.',
                'date.date' => 'يرجى إدخال تاريخ صالح.',
                'nots.string' => 'الملاحظات يجب أن تكون نصًا.',
                'nots.max' => 'الملاحظات يجب ألا تتجاوز 500 حرف.',
                'type.required' => 'نوع الجهه هو حقل مطلوب.',
                'entity_id.required' => ' الجهه هو حقل مطلوب.',
            ]);

            $document = Document::findOrFail($id);


            $document->update([
                'name' => $request->input('name'),
                'date' => $request->input('date'),
                'nots' => $request->input('nots'),
                'type' => $request->input('type'),
                'entity_id' => $request->input('entity_id'),
            ]);


            if ($request->hasFile('photos')) {
                foreach ($document->documentDetails as $detail) {
                    Storage::disk('public')->delete($detail->path);
                    $detail->delete();
                }

                // Store new files
                foreach ($request->file('photos') as $file) {
                    $today = now();
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = "documents/" . $today->year . "/" . $today->month . "/" . $today->day . '/' . time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs($path, $filename, 'public');

                    DocumentDetails::create([
                        'document_id' => $document->id,
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                    ]);
                }

                return redirect()->route('documents.index')->with('success', 'تم التعديل بنجاح');
            }

                return redirect()->route('documents.index')->with('success', 'تم التعديل بنجاح');
        }




    public function destroy(Request $request,string $id,FlasherInterface $flasher)
    {

    $documentId = $request->document_id;
    $document = Document::findOrFail($documentId);

    $documentDetails = DocumentDetails::where('document_id', $documentId)->get();

    foreach ($documentDetails as $detail) {
        if (Storage::disk('public')->exists($detail->path)) {
            Storage::disk('public')->delete($detail->path);
        }
        $detail->delete();

    }
    $document->delete();

    return redirect()->route('documents.index')->with('success', 'تم الحذف بنجاح');

}



public function download($id)
{
    $document = Document::findOrFail($id);

    $documentDetails = DocumentDetails::where('document_id', $id)->get();
    if ($documentDetails->isEmpty()) {
        return back()->with('error', 'لا يوجد ملفات لتحميلها');
    }

    $zip = new ZipArchive;
    $zipFileName = storage_path("app/public/{$document->name}_files.zip");

    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        foreach ($documentDetails as $detail) {
            $filePath = $detail->path;
            if (Storage::disk('public')->exists($filePath)) {
                $zip->addFile(storage_path('app/public/' . $filePath), basename($filePath));
            } else {
                // If any file doesn't exist, add an error message and skip
                continue;
            }
        }
        $zip->close();
    } else {
        return back()->with('error', 'فشل في إنشاء ملف الأرشيف');
    }

    return response()->download($zipFileName)->deleteFileAfterSend(true);
}


public function getEntities($entitytype)
{
    if($entitytype == 1 || $entitytype  == 3){
        $entities = Entitie::where('id',"!=",Auth::user()->entity_id)->where('type','internal')->get();
    }else{
        $entities = Entitie::where('type','external')->get();
    }
    return response()->json($entities);
}



}





        /*    if ($request->has('entity') && $request->entity != '') {
                    $query->join('entities', 'documents.entity_id', '=', 'entities.id')
                          ->where('entities.name', 'like', '%' . $request->entity . '%')
                          ->select('entities.id'
                          ,'documents.id','documents.date','documents.nots','documents.branch_id','documents.entity_id','documents.name','documents.type');

            } */
