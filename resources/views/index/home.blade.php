@extends('layouts.app')

@section('content')
  <!-- Hero Section -->
  <div class="jumbotron homepage m-0">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 second">
          <div class="hero-badge mb-4">
            <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill">
              <i class="bi bi-lightning-charge-fill me-2"></i>
              Creator Platform for Fitness & Sports
            </span>
          </div>
          
          <h1 class="display-4 mb-4">
            Turn Your Passion<br>
            <span class="text-gradient">Into Profit</span>
          </h1>
          
          <p class="lead mb-4">
            Join thousands of fitness creators, athletes, and sports influencers who are monetizing their content and building thriving communities on FansFollowMe.
          </p>
          
          <div class="hero-stats d-flex gap-4 mb-4">
            <div class="stat-item">
              <h3 class="mb-0">10K+</h3>
              <small class="text-muted">Active Creators</small>
            </div>
            <div class="stat-item">
              <h3 class="mb-0">$2M+</h3>
              <small class="text-muted">Paid to Creators</small>
            </div>
            <div class="stat-item">
              <h3 class="mb-0">500K+</h3>
              <small class="text-muted">Subscribers</small>
            </div>
          </div>
          
          <p>
            @if (!$settings->disable_creators_section)
              <a href="{{url('creators')}}" class="btn btn-lg btn-main btn-outline-light btn-w-mb px-4 mr-2" role="button">
                <i class="bi bi-compass me-2"></i>{{__('general.explore')}}
              </a>
            @endif

            <a class="btn btn-lg btn-main btn-light btn-w px-4 toggleRegister btn-arrow" href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}">
              <i class="bi bi-rocket-takeoff me-2"></i>{{__('general.getting_started')}}
            </a>
          </p>
        </div>
        <div class="col-lg-6 first text-center">
          <div class="hero-image-wrapper">
            <img src="{{url('public/img', $settings->home_index)}}" class="img-center img-fluid" alt="FansFollowMe Creator Platform">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ./ Hero Section -->

  <!-- Features Section -->
  <div class="section py-5 py-large">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-3">
          Why Choose Us
        </span>
        <h1 class="txt-black">{{__('general.header_box_2')}}</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">
          {{__('general.desc_box_2')}}
        </p>
      </div>

      <div class="row g-4">
        <div class="col-lg-4">
          <div class="feature-card text-center p-4 rounded-4 h-100">
            <div class="feature-icon mb-4">
              <img src="{{url('public/img', $settings->img_1)}}" class="img-center img-fluid" width="120">
            </div>
            <h4 class="mt-1 txt-black">{{__('general.card_1')}}</h4>
            <p class="text-muted mt-1">{{__('general.desc_card_1')}}</p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="feature-card text-center p-4 rounded-4 h-100">
            <div class="feature-icon mb-4">
              <img src="{{url('public/img', $settings->img_2)}}" class="img-center img-fluid" width="120">
            </div>
            <h4 class="mt-1 txt-black">{{__('general.card_2')}}</h4>
            <p class="text-muted mt-1">{{__('general.desc_card_2')}}</p>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="feature-card text-center p-4 rounded-4 h-100">
            <div class="feature-icon mb-4">
              <img src="{{url('public/img', $settings->img_3)}}" class="img-center img-fluid" width="120">
            </div>
            <h4 class="mt-1 txt-black">{{__('general.card_3')}}</h4>
            <p class="text-muted mt-1">{{__('general.desc_card_3')}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Profile Section -->
  <div class="section py-5 py-large">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-lg-6 text-center mb-4 mb-lg-0">
          <img src="{{url('public/img', $settings->img_4)}}" alt="Create Your Profile" class="img-fluid" style="max-height: 400px;">
        </div>
        <div class="col-12 col-lg-6">
          <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-3">
            Get Started Today
          </span>
          <h1 class="m-0 card-profile txt-black">{{__('general.header_box_3')}}</h1>
          <p class="py-4 m-0 text-muted fs-5">{{__('general.desc_box_3')}}</p>
          <a href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}" class="btn-arrow btn btn-lg btn-main btn-primary px-5 py-3">
            <i class="bi bi-rocket-takeoff me-2"></i>{{__('general.getting_started')}}
          </a>
        </div>
      </div>
    </div>
  </div>

  @if ($settings->widget_creators_featured == 'on')
    @if ($users->count() != 0)
    <!-- Featured Creators Section -->
    <div class="section py-5 py-large">
      <div class="container">
        <div class="text-center mb-5">
          <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-3">
            Top Creators
          </span>
          <h1 class="txt-black">{{__('general.creators_featured')}}</h1>
          <p class="text-muted mx-auto" style="max-width: 600px;">
            {{__('general.desc_creators_featured')}}
          </p>
        </div>
        
        <div class="row">
          <div class="owl-carousel owl-theme">
            @foreach ($users as $response)
              @include('includes.listing-creators')
            @endforeach
          </div>

          @if (!$settings->disable_creators_section)
            @if ($usersTotal > $users->total())
            <div class="w-100 text-center mt-4 px-lg-0 px-3">
              <a href="{{url('creators')}}" class="btn-arrow btn btn-lg btn-main btn-outline-primary btn-w px-4">
                <i class="bi bi-people me-2"></i>{{__('general.view_all_creators')}}
              </a>
            </div>
            @endif
          @endif
        </div>
      </div>
    </div>
    @endif
  @endif

  @if ($settings->show_counter == 'on')
  <!-- Stats Counter Section -->
  <div class="section py-5 bg-gradient text-white">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="stat-icon me-4">
              <i class="bi bi-people display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">{!! Helper::formatNumbersStats($usersTotal) !!}</h2>
              <h5 class="mb-0 opacity-90">{{__('general.creators')}}</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="stat-icon me-4">
              <i class="bi bi-images display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">{!! Helper::formatNumbersStats(Updates::count()) !!}</h2>
              <h5 class="mb-0 opacity-90">{{__('general.content_created')}}</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex align-items-center justify-content-center p-4">
            <div class="stat-icon me-4">
              <i class="bi bi-cash-coin display-4"></i>
            </div>
            <div>
              <h2 class="mb-0 fw-bold">
                @if($settings->currency_position == 'left') {{ $settings->currency_symbol }}@endif
                {!! Helper::formatNumbersStats(Transactions::whereApproved('1')->sum('earning_net_user')) !!}
                @if($settings->currency_position == 'right'){{ $settings->currency_symbol }} @endif
              </h2>
              <h5 class="mb-0 opacity-90">{{__('general.earnings_of_creators')}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if ($settings->earnings_simulator == 'on')
  <!-- Earnings Simulator Section -->
  <div class="section py-5 py-large">
    <div class="container mb-4">
      <div class="text-center mb-5">
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-3">
          Calculate Your Earnings
        </span>
        <h1 class="txt-black">{{__('general.earnings_simulator')}}</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">
          {{__('general.earnings_simulator_subtitle')}}
        </p>
      </div>
      
      <div class="row g-4">
        <div class="col-md-6">
          <div class="simulator-card p-4 rounded-4">
            <label for="rangeNumberFollowers" class="w-100 fw-semibold">
              <i class="bi bi-people me-2"></i>{{ __('general.number_followers') }}
              <span class="float-end badge bg-primary">
                #<span id="numberFollowers">1000</span>
              </span>
            </label>
            <input type="range" class="custom-range" value="0" min="1000" max="1000000" id="rangeNumberFollowers" onInput="$('#numberFollowers').html($(this).val())">
          </div>
        </div>

        <div class="col-md-6">
          <div class="simulator-card p-4 rounded-4">
            <label for="rangeMonthlySubscription" class="w-100 fw-semibold">
              <i class="bi bi-tag me-2"></i>{{ __('general.monthly_subscription_price') }}
              <span class="float-end badge bg-primary">
                {{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }}
                <span id="monthlySubscription">{{ $settings->min_subscription_amount }}</span>
                {{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }}
              </span>
            </label>
            <input type="range" class="custom-range" value="0" onInput="$('#monthlySubscription').html($(this).val())" min="{{ $settings->min_subscription_amount }}" max="{{ $settings->max_subscription_amount }}" id="rangeMonthlySubscription">
          </div>
        </div>

        <div class="col-md-12 text-center mt-4">
          <div class="earnings-result p-4 rounded-4">
            <h3 class="fw-light mb-3">{{__('general.earnings_simulator_subtitle_2')}}</h3>
            <div class="display-4 fw-bold text-primary mb-2">
              <span id="estimatedEarn"></span>
              <small class="fs-5 opacity-75">{{$settings->currency_code}}</small>
            </div>
            <p class="text-muted mb-1">{{ __('general.per_month') }}*</p>
            <small class="d-block text-muted">* {{__('general.earnings_simulator_subtitle_3')}}</small>
            @if ($settings->fee_commission != 0)
              <small class="d-block text-muted mt-1">* {{__('general.include_platform_fee', ['percentage' => $settings->fee_commission])}}</small>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Bottom CTA Section -->
  <div class="jumbotron m-0 text-white text-center bg-gradient">
    <div class="container position-relative">
      <h1 class="display-5 fw-bold mb-3">{{__('general.head_title_bottom')}}</h1>
      <p class="fs-5 mb-4 opacity-90">{{__('general.head_title_bottom_desc')}}</p>
      <p>
        @if (!$settings->disable_creators_section)
          <a href="{{url('creators')}}" class="btn btn-lg btn-main btn-outline-light btn-w-mb px-4 mr-2" role="button">
            <i class="bi bi-compass me-2"></i>{{__('general.explore')}}
          </a>
        @endif
        <a class="btn-arrow btn btn-lg btn-main btn-light btn-w px-4 toggleRegister" href="{{ $settings->registration_active == '1' ? url('signup') : url('login')}}" role="button">
          <i class="bi bi-rocket-takeoff me-2"></i>{{__('general.getting_started')}}
        </a>
      </p>
    </div>
  </div>

@endsection

@section('javascript')

  @if ($settings->earnings_simulator == 'on')
  <script type="text/javascript">

  function decimalFormat(nStr)
  {
    @if ($settings->decimal_format == 'dot')
     var $decimalDot = '.';
     var $decimalComma = ',';
     @else
     var $decimalDot = ',';
     var $decimalComma = '.';
     @endif

     @if ($settings->currency_position == 'left')
     var currency_symbol_left = '{{$settings->currency_symbol}}';
     var currency_symbol_right = '';
     @else
     var currency_symbol_right = '{{$settings->currency_symbol}}';
     var currency_symbol_left = '';
     @endif

      nStr += '';
      var x = nStr.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? $decimalDot + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          var x1 = x1.replace(rgx, '$1' + $decimalComma + '$2');
      }
      return currency_symbol_left + x1 + x2 + currency_symbol_right;
    }

    function earnAvg() {
      var fee = {{ $settings->fee_commission }};
      @if($settings->currency_code == 'JPY')
       $decimal = 0;
      @else
       $decimal = 2;
      @endif

      var monthlySubscription = parseFloat($('#rangeMonthlySubscription').val());
      var numberFollowers = parseFloat($('#rangeNumberFollowers').val());

      var estimatedFollowers = (numberFollowers * 5 / 100)
      var followersAndPrice = (estimatedFollowers * monthlySubscription);
      var percentageAvgFollowers = (followersAndPrice * fee / 100);
      var earnAvg = followersAndPrice - percentageAvgFollowers;

      return decimalFormat(earnAvg.toFixed($decimal));
    }
   $('#estimatedEarn').html(earnAvg());

   $("#rangeNumberFollowers, #rangeMonthlySubscription").on('change', function() {

     $('#estimatedEarn').html(earnAvg());

   });
  </script>
@endif

@if (session('success_verify'))
  <script type="text/javascript">

	swal({
		title: "{{ __('general.welcome') }}",
		text: "{{ __('users.account_validated') }}",
		type: "success",
		confirmButtonText: "{{ __('users.ok') }}"
		});
    </script>
	 @endif

	 @if (session('error_verify'))
   <script type="text/javascript">
	swal({
		title: "{{ __('general.error_oops') }}",
		text: "{{ __('users.code_not_valid') }}",
		type: "error",
		confirmButtonText: "{{ __('users.ok') }}"
		});
    </script>
	 @endif

@endsection
