<?php

namespace App\Http\Livewire\Admin\ProductsServices;

use App\Contact;
use Livewire\Component;
use App\ProductsService;
use App\DevelopmentLevel;
use App\ProductsServicesFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProductsServicesComponent extends Component
{

    use WithFileUploads;

    public $contactId, $productId, $product=[];
    public $name, $description, $development_level_id, $beneficiaries;

    public $nameFile, $file, $fileId;

    public $developmentLevels = [];

    public $searchName;

    public function mount()
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        $this->contactId = $contact->id;
        $this->contactId;
        $this->developmentLevels = DevelopmentLevel::all();
    }

    public function render()
    {



        $products= ProductsService::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->where('contact_id','=',$this->contactId)->get();



        return view('livewire.admin.products-services.products-services-component',[
            'products'=>$products
        ]);
    }

    public function show($id){
        $product = ProductsService::find($id);
        $this->productId = $id;

        $this->name = $product->name;
        $this->description = $product->description;
        $this->development_level_id = $product->development_level_id;
        $this->beneficiaries = $product->beneficiaries;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'development_level_id' => 'required',
            'beneficiaries' => 'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'development_level_id' => 'nivel de desarrollo',
            'beneficiaries' => 'Clientes / beneficiarios actuales y proyecciones'
        ]);

        $product = new ProductsService();
        $product->name = $this->name;
        $product->description = $this->description;
        $product->development_level_id = $this->development_level_id;
        $product->beneficiaries = $this->beneficiaries;
        $product->contact_id = $this->contactId;
        $product->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Producto / Servicio creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $product = ProductsService::find($id);
        $this->productId = $id;

        $this->name = $product->name;
        $this->description = $product->description;
        $this->development_level_id = $product->development_level_id;
        $this->beneficiaries = $product->beneficiaries;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'development_level_id' => 'required',
            'beneficiaries' => 'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'development_level_id' => 'nivel de desarrollo',
            'beneficiaries' => 'Clientes / beneficiarios actuales y proyecciones'
        ]);

        $product = ProductsService::find($this->productId);
        $product->name = $this->name;
        $product->description = $this->description;
        $product->development_level_id = $this->development_level_id;
        $product->beneficiaries = $this->beneficiaries;
        $product->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Producto / Servicio modificado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->productId = $id;
    }

    public function destroy()
    {

        $product = ProductsService::find($this->productId);
        $product->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Producto / Servicio eliminado correctamente']);
        $this->cancel();
    }

    public function files($id)
    {
        $this->product = ProductsService::find($id);
        $this->productId = $this->product->id;
    }

    public function upload()
    {
        $this->validate([
            'file'=>'required',
            'nameFile'=>'required'
        ],[],[
            'file'=>'archivo',
            'nameFile'=>'nombre del archivo'
        ]);

        $extension = $this->file->getClientOriginalExtension();
        $name=str_replace(' ', '-', (strtolower($this->nameFile).    '.'.$extension));

        $path = $this->file->storeAs('public/product-services', $name);
        $file= new ProductsServicesFile();
        $file->url=$path;
        $file->name=$this->nameFile;
        $file->product_service_id=$this->productId;
        $file->save();

        $this->nameFile = '';
        $this->file = '';

        $this->product = ProductsService::find($this->productId);

        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo cargado correctamente']);
    }

    public function deleteFile($id){
        $this->fileId=$id;

        $file=ProductsServicesFile::find($this->fileId);
        $file->delete();

        $this->product = ProductsService::find($this->productId);

        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo eliminado correctamente']);
    }


    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->development_level_id = '';
        $this->beneficiaries = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
