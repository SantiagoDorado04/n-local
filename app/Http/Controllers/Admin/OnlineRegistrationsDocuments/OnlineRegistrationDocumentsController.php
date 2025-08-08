<?php

namespace App\Http\Controllers\Admin\OnlineRegistrationsDocuments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use App\Models\OnlineRegistrationDocument;
use App\Contact;
use App\Models\OnlineRegistrationCertificationRegister;
use Illuminate\Support\Str;

class OnlineRegistrationDocumentsController extends Controller
{
    public function generarPDF($id, $contactId)
    {
        $document = OnlineRegistrationDocument::findOrFail($id);
        $contact = Contact::findOrFail($contactId);

        // Buscar si ya existe un registro previo de descarga
        $existingRegister = OnlineRegistrationCertificationRegister::where('contact_id', $contactId)
            ->where('or_document_id', $id)
            ->first();

        if ($existingRegister) {
            $existingPath = storage_path('app/' . $existingRegister->url);

            if (file_exists($existingPath)) {
                // Actualiza el contador de descargas y la fecha
                $existingRegister->update([
                    'last_download_date' => now(),
                    'count_downloads' => $existingRegister->count_downloads + 1,
                ]);

                return response()->download($existingPath);
            }

            // El archivo no existe, pero hay un registro en la base de datos → regenerar y actualizar
            // FALTABA dejar continuar a la generación
        }

        // Obtener la ruta completa al archivo
        $storagePath = storage_path('app/' . $document->url);

        if (!file_exists($storagePath)) {
            return response()->json(['error' => 'El archivo no existe.'], 404);
        }

        // Verificar si es un archivo PDF por su MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $storagePath);
        finfo_close($finfo);

        if ($mimeType !== 'application/pdf') {
            // Si no es PDF, simplemente descarga el archivo original
            return response()->download($storagePath);
        }



        try {
            $pdf = new Fpdi();

            $pdf->AddFont('Nunito', '', 'Nunito-Regular.php');

            $pageCount = $pdf->setSourceFile($storagePath);
            $templateId = $pdf->importPage(1);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            $pdf->SetFont('Nunito', '', 32);
            $pdf->SetTextColor(0, 0, 0);

            $nombre = strtoupper($contact->name);
            $cedula = 'CC ' . $contact->nit;

            $nombreWidth = $pdf->GetStringWidth($nombre);
            $cedulaWidth = $pdf->GetStringWidth($cedula);

            $centerXNombre = ($size['width'] - $nombreWidth) / 2;
            $centerXCedula = ($size['width'] - $cedulaWidth) / 2;

            $pdf->SetXY($centerXNombre, 118);
            $pdf->Write(10, $nombre);

            $pdf->SetXY($centerXCedula, 133);
            $pdf->Write(10, $cedula);

            $cleanName = Str::slug($contact->name . '_' . $document->name . '_' . $document->id, '_');
            $filename = $cleanName . '.pdf';
            $relativePath = 'or-documents-files/generated-documents/' . $filename;
            $fullPath = storage_path('app/' . $relativePath);

            $pdfContent = $pdf->Output('S');

            // Guardar en disco
            file_put_contents($fullPath, $pdfContent);

            if ($existingRegister) {
                $existingRegister->update([
                    'url' => $relativePath,
                    'last_download_date' => now(),
                    'count_downloads' => $existingRegister->count_downloads + 1,
                ]);
            } else {
                OnlineRegistrationCertificationRegister::create([
                    'url' => $relativePath,
                    'last_download_date' => now(),
                    'count_downloads' => 1,
                    'contact_id' => $contact->id,
                    'or_document_id' => $document->id,
                ]);
            }

            // Descargar
            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error generando PDF: ' . $e->getMessage()], 500);
        }
    }
}
