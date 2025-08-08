<?php

namespace App\Http\Controllers\Admin\Proposals;

/*  Admin/Proposals/ProposalTemplatesController */

use App\ProposalTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProposalTemplatesController extends Controller
{
    public function index()
    {
        $templates = ProposalTemplate::all();
        return view('admin.proposals.templates.index',[
            'templates'=>$templates
        ]);
    }

    public function create()
    {
        return view('admin.proposals.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file' => 'required'
        ]);

        $template =  new ProposalTemplate();
        $template->name = $request->name;
        $template->description = $request->description;
        if ($request->file != '') {
            $file = $request->file('file');
            $path = $file->store('public');
            $url = Storage::url($path);
            $template->url_file = $url;
        }
        $template->save();

        return Redirect::route('proposal.templates')
            ->with('success', 'Plantilla de propuesta guardada correctamente.');
    }
}
