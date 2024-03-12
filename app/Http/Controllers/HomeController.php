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

    public function imsakiye()
    {
        $html = '<table class="imsakiye-table">
                    <thead>
                        <tr class="imsakiye-table__head-row">
                            <th class="imsakiye-table__head-element--date">Tarih</th>
                            <th>İmsak</th>
                            <th>Güneş</th>
                            <th>Öğle</th>
                            <th>İkindi</th>
                            <th>Akşam</th>
                            <th>Yatsı</th>
                        </tr>
                    </thead>
                    <tbody>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 1. Gün </strong>11 Mart 2024 Pazartesi</td>
                                    <td>05:58</td>
                                    <td>07:19</td>
                                    <td>13:24</td>
                                    <td>16:42</td>
                                    <td>19:19</td>
                                    <td>20:35</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 2. Gün </strong>12 Mart 2024 Salı</td>
                                    <td>05:57</td>
                                    <td>07:18</td>
                                    <td>13:24</td>
                                    <td>16:43</td>
                                    <td>19:20</td>
                                    <td>20:36</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 3. Gün </strong>13 Mart 2024 Çarşamba</td>
                                    <td>05:55</td>
                                    <td>07:16</td>
                                    <td>13:24</td>
                                    <td>16:43</td>
                                    <td>19:21</td>
                                    <td>20:37</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 4. Gün </strong>14 Mart 2024 Perşembe</td>
                                    <td>05:54</td>
                                    <td>07:15</td>
                                    <td>13:23</td>
                                    <td>16:44</td>
                                    <td>19:22</td>
                                    <td>20:38</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 5. Gün </strong>15 Mart 2024 Cuma</td>
                                    <td>05:52</td>
                                    <td>07:13</td>
                                    <td>13:23</td>
                                    <td>16:44</td>
                                    <td>19:23</td>
                                    <td>20:39</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 6. Gün </strong>16 Mart 2024 Cumartesi</td>
                                    <td>05:50</td>
                                    <td>07:12</td>
                                    <td>13:23</td>
                                    <td>16:45</td>
                                    <td>19:24</td>
                                    <td>20:40</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 7. Gün </strong>17 Mart 2024 Pazar</td>
                                    <td>05:49</td>
                                    <td>07:10</td>
                                    <td>13:22</td>
                                    <td>16:45</td>
                                    <td>19:25</td>
                                    <td>20:41</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 8. Gün </strong>18 Mart 2024 Pazartesi</td>
                                    <td>05:47</td>
                                    <td>07:09</td>
                                    <td>13:22</td>
                                    <td>16:46</td>
                                    <td>19:26</td>
                                    <td>20:42</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 9. Gün </strong>19 Mart 2024 Salı</td>
                                    <td>05:45</td>
                                    <td>07:07</td>
                                    <td>13:22</td>
                                    <td>16:46</td>
                                    <td>19:27</td>
                                    <td>20:43</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 10. Gün </strong>20 Mart 2024 Çarşamba</td>
                                    <td>05:44</td>
                                    <td>07:06</td>
                                    <td>13:22</td>
                                    <td>16:47</td>
                                    <td>19:28</td>
                                    <td>20:44</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 11. Gün </strong>21 Mart 2024 Perşembe</td>
                                    <td>05:42</td>
                                    <td>07:04</td>
                                    <td>13:21</td>
                                    <td>16:47</td>
                                    <td>19:29</td>
                                    <td>20:45</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 12. Gün </strong>22 Mart 2024 Cuma</td>
                                    <td>05:40</td>
                                    <td>07:02</td>
                                    <td>13:21</td>
                                    <td>16:48</td>
                                    <td>19:30</td>
                                    <td>20:46</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 13. Gün </strong>23 Mart 2024 Cumartesi</td>
                                    <td>05:39</td>
                                    <td>07:01</td>
                                    <td>13:21</td>
                                    <td>16:48</td>
                                    <td>19:31</td>
                                    <td>20:47</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 14. Gün </strong>24 Mart 2024 Pazar</td>
                                    <td>05:37</td>
                                    <td>06:59</td>
                                    <td>13:20</td>
                                    <td>16:48</td>
                                    <td>19:32</td>
                                    <td>20:49</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 15. Gün </strong>25 Mart 2024 Pazartesi</td>
                                    <td>05:35</td>
                                    <td>06:58</td>
                                    <td>13:20</td>
                                    <td>16:49</td>
                                    <td>19:33</td>
                                    <td>20:50</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 16. Gün </strong>26 Mart 2024 Salı</td>
                                    <td>05:34</td>
                                    <td>06:56</td>
                                    <td>13:20</td>
                                    <td>16:49</td>
                                    <td>19:34</td>
                                    <td>20:51</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 17. Gün </strong>27 Mart 2024 Çarşamba</td>
                                    <td>05:32</td>
                                    <td>06:55</td>
                                    <td>13:20</td>
                                    <td>16:50</td>
                                    <td>19:34</td>
                                    <td>20:52</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 18. Gün </strong>28 Mart 2024 Perşembe</td>
                                    <td>05:30</td>
                                    <td>06:53</td>
                                    <td>13:19</td>
                                    <td>16:50</td>
                                    <td>19:35</td>
                                    <td>20:53</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 19. Gün </strong>29 Mart 2024 Cuma</td>
                                    <td>05:28</td>
                                    <td>06:52</td>
                                    <td>13:19</td>
                                    <td>16:50</td>
                                    <td>19:36</td>
                                    <td>20:54</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 20. Gün </strong>30 Mart 2024 Cumartesi</td>
                                    <td>05:27</td>
                                    <td>06:50</td>
                                    <td>13:19</td>
                                    <td>16:51</td>
                                    <td>19:37</td>
                                    <td>20:55</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 21. Gün </strong>31 Mart 2024 Pazar</td>
                                    <td>05:25</td>
                                    <td>06:48</td>
                                    <td>13:18</td>
                                    <td>16:51</td>
                                    <td>19:38</td>
                                    <td>20:56</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 22. Gün </strong>01 Nisan 2024 Pazartesi</td>
                                    <td>05:23</td>
                                    <td>06:47</td>
                                    <td>13:18</td>
                                    <td>16:51</td>
                                    <td>19:39</td>
                                    <td>20:57</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 23. Gün </strong>02 Nisan 2024 Salı</td>
                                    <td>05:22</td>
                                    <td>06:45</td>
                                    <td>13:18</td>
                                    <td>16:52</td>
                                    <td>19:40</td>
                                    <td>20:58</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 24. Gün </strong>03 Nisan 2024 Çarşamba</td>
                                    <td>05:20</td>
                                    <td>06:44</td>
                                    <td>13:17</td>
                                    <td>16:52</td>
                                    <td>19:41</td>
                                    <td>21:00</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 25. Gün </strong>04 Nisan 2024 Perşembe</td>
                                    <td>05:18</td>
                                    <td>06:42</td>
                                    <td>13:17</td>
                                    <td>16:52</td>
                                    <td>19:42</td>
                                    <td>21:01</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 26. Gün </strong>05 Nisan 2024 Cuma</td>
                                    <td>05:16</td>
                                    <td>06:41</td>
                                    <td>13:17</td>
                                    <td>16:53</td>
                                    <td>19:43</td>
                                    <td>21:02</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 27. Gün </strong>06 Nisan 2024 Cumartesi</td>
                                    <td>05:14</td>
                                    <td>06:39</td>
                                    <td>13:17</td>
                                    <td>16:53</td>
                                    <td>19:44</td>
                                    <td>21:03</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 28. Gün </strong>07 Nisan 2024 Pazar</td>
                                    <td>05:13</td>
                                    <td>06:38</td>
                                    <td>13:16</td>
                                    <td>16:53</td>
                                    <td>19:45</td>
                                    <td>21:04</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 29. Gün </strong>08 Nisan 2024 Pazartesi</td>
                                    <td>05:11</td>
                                    <td>06:36</td>
                                    <td>13:16</td>
                                    <td>16:54</td>
                                    <td>19:46</td>
                                    <td>21:05</td>
                                </tr>
                                <tr>
                                    <td class="imsakiye-table__data-element--date"><strong> 30. Gün </strong>09 Nisan 2024 Salı</td>
                                    <td>05:09</td>
                                    <td>06:35</td>
                                    <td>13:16</td>
                                    <td>16:54</td>
                                    <td>19:47</td>
                                    <td>21:07</td>
                                </tr>

                    </tbody>
                </table>';

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $rows = $dom->getElementsByTagName('tr');

        $result = [];

        foreach ($rows as $row) {
            $rowData = [];
            $cells = $row->getElementsByTagName('td');

            if ($cells->length > 0) {
                $rowData['Gün'] = trim(str_replace('. Gün', '', $cells[0]->nodeValue));
                $rowData['Tarih'] = trim(substr($cells[0]->nodeValue, strpos($cells[0]->nodeValue, ' ') + 1));
                $rowData['İmsak'] = trim($cells[1]->nodeValue);
                $rowData['Güneş'] = trim($cells[2]->nodeValue);
                $rowData['Öğle'] = trim($cells[3]->nodeValue);
                $rowData['İkindi'] = trim($cells[4]->nodeValue);
                $rowData['Akşam'] = trim($cells[5]->nodeValue);
                $rowData['Yatsı'] = trim($cells[6]->nodeValue);

                $result[] = $rowData;
            }
        }

        dd($result);
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
