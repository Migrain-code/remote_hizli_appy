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
    /*public function sendSms()
    {
        Sms::send("5537021355","Bu bir test mesajıdır");
    }*/
    public function proparties()
    {
        $proparties=Propartie::latest()->get();
        return view('propartie.index', compact('proparties'));
    }

    public function propartie($slug)
    {
        $propartie=Propartie::where('slug', $slug)->firstOrFail();
        return view('propartie.detail', compact('propartie'));
    }
    public function packages()
    {

        return view('package.index');
    }
    public function getInfo(Request $request)
    {
        $request->validate([
            'fullname'=>"required|min:3",
            'business_name'=>"required|min:3",
            'phone'=>"required|min:11"
        ], [], [
            'fullname'=>"İşletme Sahibi",
            'business_name'=>"İşletme Adı",
            'phone'=>"Telefon"
        ]);
        $businessInfo=new BusinessInfo();
        $businessInfo->fullname=$request->input('fullname');
        $businessInfo->business_name=$request->input('business_name');
        $businessInfo->phone=$request->input('phone');
        if ($businessInfo->save()){
            return back()->with('response', [
                'status'=>"success",
                'message'=>"Talebiniz Gönderildi Size en kısa zamanda arayacağız"
            ]);
        }
    }

    public function categoryDetail($slug)
    {
        $category=BusinessCategory::where('slug', $slug)->firstOrFail();
        return view('business_categories.index', compact('category'));
    }
    public function page($slug)
    {
        $page=Page::where('slug', $slug)->first();
        $metin=$page->description;
        /*$vocas=[];
        $links=[];
        foreach (explode(" ", $metin) as $voca){
            if (strstr($voca, "strong")){
                dd(substr($voca, 8, 17));
                $links[]=substr($voca, 8, 17);
            }
            $vocas[]=$voca;
        }
        dd($links);*/
        return view('front.page', compact('page'));
    }
    public function blogs()
    {
        $sliders=Slider::all();
        $blogs= Blog::latest()->get();
        $categories= Category::all();
        return view('blog.index', compact('blogs', 'sliders', 'categories'));
    }
    public function blogDetail($slug)
    {
        $blog=Blog::where('slug', $slug)->firstOrFail();
        $blogs= Blog::latest()->take(4)->get();
        $categories= Category::all();
        return view('blog.detail', compact('blog', 'blogs'));
    }

    public function faq()
    {
        $faqs=BusinessFaq::all();
        return view('support.index', compact('faqs'));
    }
    public function contact()
    {
        return view('contact.index');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'fullName'=>"required|min:3",
            'email'=>"required|email",
            'phone'=>"required",
            'subject'=>"required",
            'message'=>"required",
        ],[],[
            'fullName'=>"Ad Soyad",
            'email'=>"E-posta",
            'phone'=>"Telefon",
            'subject'=>"Konu",
            'message'=>"İletişim Mesajı",
        ]);
        $businessContact=new BusinessContact();
        $businessContact->fullName=$request->fullName;
        $businessContact->email=$request->email;
        $businessContact->phone=$request->phone;
        $businessContact->subject=$request->subject;
        $businessContact->message=$request->message;
        $businessContact->ip=$request->ip();
        if ($businessContact->save()){
            return back()->with('response', [
                'status'=>"success",
                'message'=>"İletişim mesajınız başarılı bir şekilde tarafımıza iletildi. En kısa sürede dönüş yapacağız."
            ]);
        }
    }

}
