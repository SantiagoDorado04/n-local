<?php

namespace App\Http\Controllers\Admin\Mailing;

use App\CampaignContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\IndividualEmail;

class MailingMassiveController extends Controller
{
    public function updatedRead(Request $request)
    {

        $email_id = $request->query('email_id');
        $email_id=str_replace("3D", "", $email_id);
        $campaign = $request->query('campaign');
        $campaign=str_replace("3D", "", $campaign);


        $result = IndividualEmail::where('id', '=', $email_id)
            ->first();

        if ($result->opening_date == '') {
            IndividualEmail::where('id', '=', $email_id)
                ->update([
                    'opening_date' => date('Y-m-d H:i:s'),
                    'status' => 'received',
                ]);
        }

        $path = public_path('assets/img/pixel-primer.png');
        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file)->header('Content-Type', $type);
    }

    public function updatedReadMassive(Request $request)
    {

        $contact = $request->query('contact');
        $contact=str_replace("3D", "", $contact);

        $result = CampaignContact::where('id', '=', $contact)
            ->first();

        if ($result->opening_date == '') {
            CampaignContact::where('id', '=', $contact)
                ->update([
                    'opening_date' => date('Y-m-d H:i:s'),
                    'status' => 'received',
                ]);
        }

        $path = public_path('assets/img/pixel-primer.png');
        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file)->header('Content-Type', $type);
    }

    public function updatedClick(Request $request){

        
        $url = $request->query('url');
        $url=str_replace("3D", "", $url);
        $url = urldecode($url);

        $contact = $request->query('contact');
        $contact=str_replace("3D", "", $contact);

        $contact=CampaignContact::find($contact);

        
        $links = json_decode($contact->links, true);

        foreach ($links as $index => $link) {
            if ($link['url'] === $url) {
                if($links[$index]['date_click']==''){
                    $links[$index]['date_click'] = date('Y-m-d H:i:s');
                    break;
                }
                
            }
        }

        $contact->links = json_encode($links);
        $contact->save();

        return redirect()->to($url);
    }
}