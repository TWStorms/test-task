<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

/**
 * Class ContactUsController
 *
 * @package App\Http\Controllers
 */
class ContactUsController extends Controller
{

    #Pages
    const CONTACT_US_PAGE = 'contact-us';
    const CONTACT_US_MAIL_VIEW = 'mail.contact-us-mail';

    /**
     * @return Application|Factory|View
     */
    public function page()
    {
        return view(self::CONTACT_US_PAGE);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function send(Request $request)
    {
        $data = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'subject' => $request->subject,
            'contact_message' => $request->contact_message
        ];
        GeneralHelper::mail($data, config('app.to_name'), config('app.to_email'), self::CONTACT_US_MAIL_VIEW);
        return redirect()->back();
    }
}
