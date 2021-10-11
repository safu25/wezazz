<!-- FOOTER -->
<div id="removeFooterLive" class="@if (Auth::check() && auth()->user()->dark_mode == 'off' || Auth::guest() ) footer_background_color footer_text_color @else bg-white @endif @if (Auth::check() && auth()->user()->dark_mode == 'off' && $settings->footer_background_color == '#ffffff' || Auth::guest() && $settings->footer_background_color == '#ffffff' ) border-top @endif">
    <footer @if (Auth::guest()) class="footer-main" @endif>
        <div class="container pb-5 pt-4">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <ul class="p-0">
                            <li>
                                <a href="{{url('/')}}">
                                    @if (Auth::check() && auth()->user()->dark_mode == 'on' )
                                    <img src="{{url('public/img', $settings->logo)}}" alt="{{$settings->title}}" class="max-w-125">
                                    @else
                                    <img src="{{url('public/img', $settings->logo_2)}}" alt="{{$settings->title}}" class="max-w-125">
                                    @endif
                                </a>
                            </li>
                            @if($settings->twitter != ''
                            || $settings->facebook != ''
                            || $settings->instagram != ''
                            || $settings->pinterest != ''
                            || $settings->youtube != ''
                            || $settings->github != ''
                            )
                            <li class="foot_letter">
                                <span>{{trans('general.keep_connect_with_us')}} {{trans('general.follow_us_social')}}</span>
                            </li>
                            <!--      <div class="w-100">
                                    <span class="w-100">{{trans('general.keep_connect_with_us')}} {{trans('general.follow_us_social')}}</span>-->
                            <li>
                                <ul class="list-inline list-social social d-flex p-0 mt-2">
                                    @if ($settings->twitter != '')
                                    <li class="list-inline-item"><a href="{{$settings->twitter}}" target="_blank" class="ico-social"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if ($settings->facebook != '')
                                    <li class="list-inline-item"><a href="{{$settings->facebook}}" target="_blank" class="ico-social"><i class="fab fa-facebook"></i></a></li>
                                    @endif

                                    @if ($settings->instagram != '')
                                    <li class="list-inline-item"><a href="{{$settings->instagram}}" target="_blank" class="ico-social"><i class="fab fa-instagram"></i></a></li>
                                    @endif

                                    @if ($settings->pinterest != '')
                                    <li class="list-inline-item"><a href="{{$settings->pinterest}}" target="_blank" class="ico-social"><i class="fab fa-pinterest"></i></a></li>
                                    @endif

                                    @if ($settings->youtube != '')
                                    <li class="list-inline-item"><a href="{{$settings->youtube}}" target="_blank" class="ico-social"><i class="fab fa-youtube"></i></a></li>
                                    @endif

                                    @if ($settings->github != '')
                                    <li class="list-inline-item"><a href="{{$settings->github}}" target="_blank" class="ico-social"><i class="fab fa-github"></i></a></li>
                                    @endif
                                </ul>
                                <!--                            </div>-->
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <ul class="p-0 foot_letter pt-4">
                            <li>
                                <h3>@lang('general.about')</h3>
                            </li>
                            <li>
                                <ul class="list-unstyled p-0 mt-2">
                                    @foreach (Pages::all() as $page)
                                    <li><a class="link-footer" href="{{ url('/p', $page->slug) }}">
                                            {{ Lang::has('pages.' . $page->slug) ? __('pages.' . $page->slug) : $page->title }}
                                        </a>
                                    </li>
                                    @endforeach
                                    
                                    <li><a class="link-footer" href="{{ url('blog') }}">{{ trans('general.blog') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @if (Categories::count() != 0)
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <ul class="p-0 foot_letter pt-4">
                            <li>
                                <h3>@lang('general.categories')</h3>
                            </li>
                            <li>
                                <ul class="list-unstyled">
                                    @foreach (Categories::where('mode','on')->orderBy('name')->take(6)->get() as $category)
                                    <li><a class="link-footer" href="{{ url('category', $category->slug) }}">{{ Lang::has('categories.' . $category->slug) ? __('categories.' . $category->slug) : $category->name }}</a></li>
                                    @endforeach

                                    @if (Categories::count() > 6)
                                    <li><a class="link-footer" href="{{ url('creators') }}">{{ trans('general.explore') }} <i class="fa fa-long-arrow-alt-right"></i></a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-sm-6">
                    <div>
                        <ul class="p-0 foot_letter pt-4">
                            <li>
                                <h3>@lang('general.links')</h3>
                            </li>

                            <li>
                                <ul class="list-unstyled p-0 mt-2">
                                    @guest
                                    <li><a class="link-footer btn btn-outline-primary bd-10 mr-3 w-122 text-white mb-3" href="{{$settings->home_style == 0 ? url('login') : url('/')}}">{{ trans('auth.login') }}</a></li><li>
                                        @if ($settings->registration_active == '1')
                                    <li><a class="link-footer btn btn-primary bd-10 w-122" href="{{$settings->home_style == 0 ? url('signup') : url('/')}}">{{ trans('auth.sign_up') }}</a></li><li>
                                        @endif
                                        @else
                                    <li><a class="link-footer url-user" href="{{ url(Auth::User()->username) }}">{{ auth()->user()->verified_id == 'yes' ? trans('general.my_page') : trans('users.my_profile') }}</a></li><li>
                                    <li><a class="link-footer" href="{{ url('settings/page') }}">{{ auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile')}}</a></li><li>
                                    <li><a class="link-footer" href="{{ url('my/subscriptions') }}">{{ trans('users.my_subscriptions') }}</a></li><li>
                                    <li><a class="link-footer" href="{{ url('logout') }}">{{ trans('users.logout') }}</a></li><li>
                                        @endguest


                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="foot_next d-flex justify-content-between align-items-center">
            <div class="container container_l">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-start justify-content-center align-items-center">
                            <div class="letter"><span> Copyright &copy; {{date('Y')}} </span><a href="#" target="_blank"> {{$settings->title}}</a></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end justify-content-center align-items-center">
                            <div>
                                <ul class="list-inline list-social social d-flex p-0 m-0">
                                    @if ($settings->twitter != '')
                                    <li class="list-inline-item"><a href="{{$settings->twitter}}" target="_blank" class="ico-social text-white"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if ($settings->facebook != '')
                                    <li class="list-inline-item"><a href="{{$settings->facebook}}" target="_blank" class="ico-social text-white"><i class="fab fa-facebook"></i></a></li>
                                    @endif

                                    @if ($settings->instagram != '')
                                    <li class="list-inline-item"><a href="{{$settings->instagram}}" target="_blank" class="ico-social text-white"><i class="fab fa-instagram"></i></a></li>
                                    @endif

                                    @if ($settings->pinterest != '')
                                    <li class="list-inline-item"><a href="{{$settings->pinterest}}" target="_blank" class="ico-social text-white"><i class="fab fa-pinterest"></i></a></li>
                                    @endif

                                    @if ($settings->youtube != '')
                                    <li class="list-inline-item"><a href="{{$settings->youtube}}" target="_blank" class="ico-social text-white"><i class="fab fa-youtube"></i></a></li>
                                    @endif

                                    @if ($settings->github != '')
                                    <li class="list-inline-item"><a href="{{$settings->github}}" target="_blank" class="ico-social text-white"><i class="fab fa-github"></i></a></li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</div>

