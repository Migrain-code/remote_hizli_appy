<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Blog;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessContact;
use App\Models\BusinessFaq;
use App\Models\BusinessInfo;
use App\Models\BusinessService;
use App\Models\BussinessPackage;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Propartie;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Models\Slider;
use App\Models\SocialMedia;
use App\Models\Swiper;
use App\Services\NetgsmSMS;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
class HomeController extends Controller
{

    public function index()
    {
        $business_categories=BusinessCategory::latest()->get();
        $proparties=Propartie::latest()->take(6)->get();
        $comments=Comment::latest()->get();
        $monthlyPackages=BussinessPackage::where('type', 0)->get();
        $yearlyPackages=BussinessPackage::where('type', 1)->get();

        return view('welcome', compact('business_categories', 'comments', 'proparties', 'monthlyPackages', 'yearlyPackages'));
    }

    public function language($lang)
    {

        if (! in_array($lang, ['tr','de','en', 'es', 'fr', 'it'])) {
            abort(400);
        }

        App::setLocale($lang);
        session()->put('locale', $lang);
        $currentLocale = App::getLocale();

        return back()->with('currentLocale', $currentLocale);

    }
}
