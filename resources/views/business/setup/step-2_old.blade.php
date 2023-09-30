@extends('business.setup.layouts.master')
@section('content')
    @include('layouts.component.error')
    <div class="col-lg-4 col-md-12">
        <div class="on-board-wizard">
            <ul>
                <li>
                    <a href="{{route('business.setup.step1')}}">
                        <div class="onboarding-progress active">
                            <span><i class="fa fa-check-circle"></i></span>
                        </div>
                        <div class="onboarding-list">
                            <h6>İşletme Türü</h6>
                            <p>İşletme Türnüzü Seçiniz. </p>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('business.setup.step2')}}">
                        <div class="onboarding-progress">
                            <span>2</span>
                        </div>
                        <div class="onboarding-list">
                            <h6>İşletme Bilgileri</h6>
                            <p>İşletme Bilgilerini Giriniz.</p>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="col-lg-8 col-md-12 my-3">
        <div class="onboarding-content-box content-wrap">
            <div class="onborad-set">
                <div class="onboarding-title">
                    <h2>İşletme Detayları?<span>*</span></h2>
                    <h6>Bu alandaki bilgileri doğru girmeniz çok önemlidir.
                    </h6>
                </div>
                <div class="onboarding-content">
                    <form class="row" method="post" action="{{route('business.setup.step2Form')}}" id="step2Form">
                        @csrf
                        <div class="form-group col-lg-12">
                            <label>İşletme Adınız</label>
                            <input type="text" class="form-control" value="{{$business->name}}" name="name" style="border-radius: 18px;height: 10px">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Salon Türü</label>
                            <select class="form-select" name="business_type" style="border-radius: 18px">
                                <option value="" selected>Salon Türünüzü Seçiniz</option>
                                @forelse($business_types as $type)
                                    <option value="{{$type->id}}" @selected($business->type_id == $type->id)>{{$type->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Salon Telefonu</label>
                            <input type="text" class="form-control" name="phone" value="{{$business->phone}}" style="border-radius: 18px;height: 10px">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>İl</label>
                            <select class="form-select" id="city" name="city" style="border-radius: 18px">
                                <option value="" selected>İl Seçiniz</option>
                                @forelse($cities as $city)
                                    <option value="{{$city->id}}" @selected($business->city == $city->id)>{{$city->name}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>

                            <div class="form-group col-lg-6" id="district">
                                <label>İlçe</label>
                                <select class="form-select district" @if($business->city != null) style="display: block;border-radius: 18px" @else style="display: block;border-radius: 18px"  @endif name="district">
                                    @if($business->city != null)
                                        @forelse($business->cities->district as $district)
                                            <option value="{{$district->id}}" @selected($business->district == $district->id)>{{$district->name}}</option>
                                        @empty

                                        @endforelse
                                    @endif
                                </select>
                            </div>


                        <div class="form-group col-lg-6">
                            <label>Kapalı Olduğu Gün</label>
                            <select class="form-select" name="offDay" style="border-radius: 18px">
                                <option value="" selected>Gün Seçiniz</option>
                                @forelse($dayList as $list)
                                    <option value="{{$list->id}}" @selected($business->off_day == $list->id)>{{$list->name}}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Açılış Saati</label>
                            <input type="time" class="form-control" name="start_time" style="border-radius: 18px;height: 10px" value="{{$business->start_time}}">

                        </div>
                        <div class="form-group col-lg-3">
                            <label>Kapanış Saati</label>
                            <input type="time" class="form-control" name="end_time" style="border-radius: 18px;height: 10px" value="{{$business->end_time}}">

                        </div>
                        <div class="form-group col-lg-12">
                            <label>İşletme Hakkında</label>
                            <textarea class="form-control" rows="6" name="business_about">{{$business->about}}</textarea>
                        </div>

                    </form>
                </div>
            </div>
            <div class="onboarding-btn">
                <a href="#" onclick="$('#step2Form').submit()">Devam Et</a>
            </div>
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
                  $('#district').css('display', 'block');
                  $(".district").append('<option value="">İlçe Seçiniz</option>');
                  $.each(data, function (){
                      $(".district").append('<option value=' + this.id+'>' + this.name +'</option>');
                  });
              }
           });
        });
    </script>
@endsection