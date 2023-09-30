@extends('business.layouts.master')
@section('title', 'İşletme | Anasayfa')
@section('links')

@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid mt-4">
        <div class="card mt-2" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
            <!--begin::Modal header-->
            <div class="card-header d-flex align-items-center">
                <!--begin::Modal title-->
                <h2>İşletmenizi Kurun</h2>
                <!--end::Modal title-->

            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="card-body py-lg-10 px-lg-10">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                     id="kt_modal_create_app_stepper">
                    <!--begin::Aside-->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <!--begin::Nav-->
                        <div class="stepper-nav ps-lg-10 my-3">
                            <!--begin::Step 1-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i> <span
                                                class="stepper-number">1</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            İşletme Adınız
                                        </h3>

                                        <div class="stepper-desc">
                                            İşletme Adınız ve Kategoriniz
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i> <span
                                                class="stepper-number">2</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            İşletme Bilgileri
                                        </h3>

                                        <div class="stepper-desc">
                                            İşletmeniz İçin Genel Bilgiler
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i> <span
                                                class="stepper-number">3</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Yetkili  Bilgileri
                                        </h3>

                                        <div class="stepper-desc">
                                            İşletme Yöneticisi Bilgileri
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i> <span
                                                class="stepper-number">4</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Paket İşlemleri
                                        </h3>

                                        <div class="stepper-desc">
                                            Hizmet Paketi Seçiniz
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->

                            <!--begin::Step 5-->
                            <div class="stepper-item mark-completed" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="ki-duotone ki-check stepper-check fs-2"></i> <span
                                                class="stepper-number">5</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Tamamlandı
                                        </h3>

                                        <div class="stepper-desc">
                                            İşletmeniz Kullanıma Hazır.
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 5-->
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--begin::Aside-->

                    <!--begin::Content-->
                    <div class="flex-row-fluid py-lg-5 px-lg-15">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_modal_create_app_form" method="post" action="{{route('business.setup.step2')}}">
                            @csrf
                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content" class="current">
                                <!--begin::Wrapper-->
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="pb-10 pb-lg-12">
                                        <!--begin::Title-->
                                        <h1 class="fw-bold text-dark">İşletme Genel Bilgileri</h1>
                                        <!--end::Title-->

                                        <!--begin::Description-->
                                        <div class="text-muted fw-semibold fs-4">
                                            Tüm Bilgileri Doldurduğunuzdan Emin Olunuz
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            Cinsiyet


                                            <span class="ms-1" data-bs-toggle="tooltip" title="İşletmenizin hizmet vereceği cinsiyeti seçiniz">
	<i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>            </label>
                                        <!--End::Label-->

                                        <!--begin::Row-->
                                        <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
                                            @forelse($business_types as $type)
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 @if($business->type_id == $type->id) active @endif" data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                     <input class="form-check-input" type="radio" name="business_type" value="{{$type->id}}" @checked($business->type_id == $type->id)>
                                                    </span>
                                                        <!--end::Radio-->

                                                        <!--begin::Info-->
                                                        <span class="ms-5">
                                                        <span class="fs-4 fw-bold text-gray-800 d-block">{{$type->name}}</span>
                                                    </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            @empty
                                            @endforelse


                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-10">
                                        <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                Salon Telefonu
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenize tanımlı telefon numaranızı giriniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->

                                            <!--begin::Tagify-->
                                            <input class="form-control d-flex align-items-center" value="" id="phone">
                                            <!--end::Tagify-->
                                        </div>
                                        <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                İşletme E-posta Adresi
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenize tanımlı e-posta adresinizi giriniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->

                                            <!--begin::Tagify-->
                                            <input class="form-control d-flex align-items-center" name="email" value="" id="email">
                                            <!--end::Tagify-->
                                        </div>

                                    </div>
                                    <div class="row mb-10">
                                       <div class="col-6">
                                           <!--begin::Label-->
                                           <label class="fs-6 fw-semibold mb-2">
                                               Şehir
                                               <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenizin Bulunduğu Şehri Seçiniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                           </label>
                                           <!--End::Label-->
                                           <select name="city" id="city" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Şehir Seçiniz..." data-allow-clear="true" data-hide-search="false">
                                               <option value="" selected>İl Seçiniz</option>
                                               @forelse($cities as $city)
                                                   <option value="{{$city->id}}" @selected($business->city == $city->id)>{{$city->name}}</option>
                                               @empty

                                               @endforelse
                                           </select>
                                       </div>
                                       <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                İlçe
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenizin Bulunduğu İlçeyi Seçiniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->
                                            <select name="district" id="district" class="form-select form-select-lg form-select-solid district" data-control="select2" data-placeholder="Şehir Seçiniz..." data-allow-clear="true" data-hide-search="false">
                                                <option value="">İlçe Seçiniz</option>
                                                @if($business->city != null)
                                                    @forelse($business->cities->district as $district)
                                                        <option value="{{$district->id}}" @selected($business->district == $district->id)>{{$district->name}}</option>
                                                    @empty

                                                    @endforelse
                                                @endif
                                            </select>
                                        </div>

                                    </div>
                                    <!--end::Input group-->
                                    <div class="row mb-10">
                                        <div class="col-12">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                Kapalı Olduğu Gün
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenizin Tatil Gününü Seçiniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->
                                            <select name="offDay" id="offDay" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Şehir Seçiniz..." data-allow-clear="true" data-hide-search="false">
                                                <option value="" selected>Tatil Gününü Seçiniz</option>
                                                @forelse($dayList as $list)
                                                    <option value="{{$list->id}}" @selected($business->off_day == $list->id)>{{$list->name}}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row mb-10">
                                        <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                Açılış Saati
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenizin Tatil Gününü Seçiniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->
                                            <input type="time" name="start_time" class="form-control" value="{{$business->start_time}}">

                                        </div>
                                        <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">
                                                Kapanış Saati
                                                <span class="ms-1" data-bs-toggle="tooltip" title="İşetmenizin Tatil Gününü Seçiniz">
	                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                            </span>
                                            </label>
                                            <!--End::Label-->

                                            <input type="time" name="end_time" class="form-control" value="{{$business->end_time}}">
                                        </div>

                                    </div>

                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 2-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack pt-10">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            data-kt-stepper-action="previous">
                                        <i class="ki-duotone ki-arrow-left fs-3 me-1"><span class="path1"></span><span
                                                    class="path2"></span></i> Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>

                                    <button type="submit" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                        Devam Et
                                        <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0"><span
                                                    class="path1"></span><span class="path2"></span></i></button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function (){

        });
        $('#city').on('change', function (){
            $('.district').empty();
            $.ajax({
                url: '{{route('business.city')}}',
                type:"POST",
                data:{
                    id: $(this).val(),
                    '_token':'{{csrf_token()}}',
                },
                dataType:"JSON",
                success:function (data){
                    //$('#district').css('display', 'block');
                    console.log(data);
                    $(".district").append('<option value="">İlçe Seçiniz</option>');
                    $.each(data, function (){
                        $(".district").append('<option value=' + this.id+'>' + this.name +'</option>');
                    });
                }
            });
        });
    </script>

@endsection
