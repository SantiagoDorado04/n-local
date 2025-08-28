<?php

namespace App\Http\Livewire\Admin\AlquimiaAgentConnections;

use App\Helpers\TransformerSanitizer;
use App\Models\AlquimiaAgentConnection;
use Livewire\Component;
use Livewire\WithPagination;

class AlquimiaAgentConnectionsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $type,
        $status,
        $url,
        $apikey,
        $responseTransformer,
        $requestBody,
        $alquimiaAgentConnectionId;

    public $searchName;

    public function render()
    {

        $alquimiaAgentConnections = AlquimiaAgentConnection::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })->paginate(6);

        $firstItem = $alquimiaAgentConnections->firstItem();
        $lastItem = $alquimiaAgentConnections->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$alquimiaAgentConnections->total()} registros";

        return view('livewire..admin.alquimia-agent-connections.alquimia-agent-connections-component', [
            'alquimiaAgentConnections' => $alquimiaAgentConnections,
            'paginationText' => $paginationText
        ]);
    }

    public function show($id)
    {
        $this->alquimiaAgentConnectionId = $id;

        $alquimiaAgentConnection = AlquimiaAgentConnection::find($id);
        $this->name = $alquimiaAgentConnection->name;
        $this->description = $alquimiaAgentConnection->description;
        $this->type = $alquimiaAgentConnection->type;
        $this->status = $alquimiaAgentConnection->status;
        $this->url = $alquimiaAgentConnection->url;
        $this->responseTransformer = $alquimiaAgentConnection->response_transformer;
        $this->requestBody = $alquimiaAgentConnection->request_body;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:processes,name',
            'description' => 'required',
            'type' => 'required',
            'status' => 'required',
            'url' => 'required',
            'responseTransformer' => 'required',
            'requestBody' => [
                'required',
                function ($attribute, $value, $fail) {
                    json_decode($value);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail("El $attribute debe ser un JSON válido.");
                    }
                }
            ],
            'apikey' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim($value) === '') {
                        $fail('La API Key no puede estar vacía o contener solo espacios.');
                    }
                }
            ],
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'type' => 'tipo',
            'status' => 'estado',
            'url' => 'url',
            'apikey' => 'API Key',
            'responseTransformer' => 'transformador de respuesta',
            'requestBody' => 'cuerpo de la solicitud',
        ]);

        $alquimiaAgentConnection = new AlquimiaAgentConnection();
        $alquimiaAgentConnection->name = $this->name;
        $alquimiaAgentConnection->description = $this->description;
        $alquimiaAgentConnection->type = $this->type;
        $alquimiaAgentConnection->status = $this->status;
        $alquimiaAgentConnection->url = $this->url;
        $alquimiaAgentConnection->apikey = $this->apikey;
        if (!empty($this->responseTransformer)) {
            try {
                $clean = TransformerSanitizer::sanitize($this->responseTransformer);
                $alquimiaAgentConnection->response_transformer = $clean;
            } catch (\Exception $e) {
                $this->emit('alert', ['type' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
        $alquimiaAgentConnection->request_body = $this->requestBody;
        $alquimiaAgentConnection->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Conexión creada correctamente']);
        $this->cancel();
    }


    public function edit($id)
    {
        $this->alquimiaAgentConnectionId = $id;

        $alquimiaAgentConnection = AlquimiaAgentConnection::find($id);
        $this->name = $alquimiaAgentConnection->name;
        $this->description = $alquimiaAgentConnection->description;
        $this->type = $alquimiaAgentConnection->type;
        $this->status = $alquimiaAgentConnection->status;
        $this->url = $alquimiaAgentConnection->url;
        $this->apikey = '';
        $this->responseTransformer = $alquimiaAgentConnection->response_transformer;
        $this->requestBody = $alquimiaAgentConnection->request_body;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:processes,name,' . $this->alquimiaAgentConnectionId,
            'description' => 'required',
            'type' => 'required',
            'status' => 'required',
            'url' => 'required',
            'responseTransformer' => 'required',
            'requestBody' => [
                'required',
                function ($attribute, $value, $fail) {
                    json_decode($value);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail("El $attribute debe ser un JSON válido.");
                    }
                }
            ],
            'apikey' => [
                function ($attribute, $value, $fail) {
                    if ($value !== null && trim($value) === '') {
                        $fail('La API Key no puede estar vacía o contener solo espacios.');
                    }
                }
            ],
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'type' => 'tipo',
            'status' => 'estado',
            'url' => 'url',
            'apikey' => 'API Key',
            'responseTransformer' => 'transformador de respuesta',
            'requestBody' => 'cuerpo de la solicitud',
        ]);


        $alquimiaAgentConnection = AlquimiaAgentConnection::find($this->alquimiaAgentConnectionId);
        $alquimiaAgentConnection->name = $this->name;
        $alquimiaAgentConnection->description = $this->description;
        $alquimiaAgentConnection->type = $this->type;
        $alquimiaAgentConnection->status = $this->status;
        $alquimiaAgentConnection->url = $this->url;

        if ($this->apikey !== null && trim($this->apikey) !== '') {
            $alquimiaAgentConnection->apikey = $this->apikey;
        }

        if (!empty($this->responseTransformer)) {
            try {
                $clean = TransformerSanitizer::sanitize($this->responseTransformer);
                $alquimiaAgentConnection->response_transformer = $clean;
            } catch (\Exception $e) {
                $this->emit('alert', ['type' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        }
        $alquimiaAgentConnection->request_body = $this->requestBody;
        $alquimiaAgentConnection->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Conexión actualizada correctamente']);
        $this->cancel();
    }


    public function delete($id)
    {
        $this->alquimiaAgentConnectionId = $id;
    }

    public function destroy()
    {
        $alquimiaAgentConnection = AlquimiaAgentConnection::find($this->alquimiaAgentConnectionId);

        $alquimiaAgentConnection->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Conexion eliminada correctamente']);
        $this->cancel();
    }



    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->type = '';
        $this->status = '';
        $this->url = '';
        $this->apikey = '';
        $this->responseTransformer = '';
        $this->requestBody = '';
        $this->alquimiaAgentConnectionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
