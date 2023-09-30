<header>
    <!-- tp-header-area-start -->
    <div id="header-sticky" class="header-bottom__area header-sticky-bg-2 header-bottom__transparent header-bottom__bdr z-index-5" style="background-color: #600ee4;">
        <div class="container">
            <div class="row g-0 align-items-center">
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-6">
                    <div class="header-bottom__logo">
                        <a class="white-logo" href="/"><img src="{{asset(config('settings.bussiness_main_white_logo'))}}" alt=""></a>
                        <a class="black-logo" href="/"><img src="{{asset(config('settings.bussiness_main_white_logo'))}}" alt=""></a>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-7 col-lg-7 d-none d-lg-block">
                    <div class="header-bottom__main-menu header-bottom__main-menu-4 header-bottom__main-menu-inner">
                        <nav id="mobile-menu" style="display: block;margin-left: 30px;">
                            <ul>
                                <li>
                                    <a href="/">Anasayfa</a>
                                </li>
                                <li><a href="{{route('packages')}}">Paketlerimiz</a></li>

                                <li>
                                    <a href="{{route('propartie.index')}}">Özellikler</a></li>
                                <li>
                                    <a href="{{route('blog.index')}}">Blog</a>
                                </li>
                                <li><a href="{{route('contact')}}">İletişim</a></li>
                                <li><a href="{{route('faq')}}" class="pr-10">Destek <i class="fa fa-headphones "></i></a></li>

                            </ul>
                        </nav>
                    </div>
                </div>
                @if(auth('official')->check())
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-8 col-6">
                        <div class="header-bottom__right d-flex align-items-center justify-content-end">
                            <div class="header-bottom__btn d-flex align-items-center">
                                <a class="tp-btn-white tp-btn-hover alt-color-black d-none d-md-inline-block" href="{{route('business.home')}}">
                                    <span class="white-text"><i class="fa fa-user-circle me-2"></i>Hesabım</span>
                                    <b style="top: 18.75px; left: -1.375px;"></b>
                                </a>
                                <a class="header-bottom__bar tp-menu-bar d-lg-none" href="#"><i class="fal fa-bars"></i></a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-8 col-6">
                        <div class="header-bottom__right d-flex align-items-center justify-content-end">
                            <div class="header-bottom__action header-bottom__action-4 d-none d-xl-block">
                                <a class="d-none d-lg-inline-block header-bottom__action-2 border-none" href="{{route('business.login')}}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 8C8.92882 8 10.4924 6.433 10.4924 4.5C10.4924 2.567 8.92882 1 7 1C5.07118 1 3.50757 2.567 3.50757 4.5C3.50757 6.433 5.07118 8 7 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M13 15C13 12.291 10.3108 10.1 7 10.1C3.68917 10.1 1 12.291 1 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span>Giriş yap</span>
                                </a>
                            </div>
                            <div class="header-bottom__btn d-flex align-items-center">
                                <a class="tp-btn-white tp-btn-hover alt-color-black d-none d-md-inline-block" href="{{route('business.register')}}">
                                    <span class="white-text">Kayıt Ol</span>
                                    <b style="top: 18.75px; left: -1.375px;"></b>
                                </a>
                                <a class="header-bottom__bar tp-menu-bar d-lg-none" href="#"><i class="fal fa-bars"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- tp-header-area-end -->
</header>