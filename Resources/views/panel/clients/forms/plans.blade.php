<br><br>
<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success nav-tabs-bold" role="tablist">
    @foreach($plan_types as $plan_type)
        @php
            $type_data_tab = match ($plan_type) {
                0 => 'month',
                1 => 'year',
                2 => 'lifetime'
            };
        @endphp
    <li class="nav-item">
        <a class="nav-link {{$loop->first ? 'active' : ''}}" data-toggle="tab" href="#tab-plan-{{$plan_type}}" role="tab" aria-selected="true">
            <i class="la la-list"></i> {{\App\Enums\PricePlanTypEnums::getText($plan_type)}}
        </a>
    </li>
    @endforeach
</ul>

<link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css"> 
<section class="price_plan_area section_padding_130_80" id="pricing">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; margin-top:5vh; animation-delay: 0.2s; animation-name: fadeInUp;">
              <h4>Pricing Plans</h4>
              <p>Let's find a way together.</p>
              <div class="line"></div>
            </div>
          </div>
        </div>
        <div class="tab-content">
            @foreach($plans as $plan_type => $plan_items)
            @php
                $type_data_tab = match ($plan_type) {
                    0 => 'month',
                    1 => 'year',
                    2 => 'lifetime'
                };
            @endphp
            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="tab-plan-{{$plan_type}}" role="tabpanel">
                <div class="row justify-content-center">
                    @php $c = 1; @endphp
                    @foreach($plan_items as $plan)
                    @php
                        $id= '';
                        $active = '';
                        $period = '';
                        if($plan_type == 0){
                            $id = 'month';
                            $active = 'show active';
                            $period = __('/mo');
                        }elseif($plan_type == 1){
                            $id = 'year';
                            $period = __('/yr');
                        }else{
                            $id = 'lifetime';
                            $period = __('/lt');
                        }
                    @endphp
                    <!-- Single Price Plan Area-->
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <!-- Side Shape-->
                        @if($c%2==0)<div class="side-shape"><img src="https://bootdey.com/img/popular-pricing.png" alt=""></div>@endif
                        <div class="title">@if($c%2==0)<span>Popular</span>@endif
                            <h3>{{$plan->title}}</h3>
                            <p>{{ $plan->package_badge }}</p>
                            <div class="line"></div>
                        </div>
                        <div class="price">
                            <h4>{{ amount_with_currency_symbol($plan->price) }}</h4>
                            <span>{{ $period }}</span>
                        </div>
                        <div class="description">
                            @if(!empty($plan->page_permission_feature))
                            <p><i class="lni lni-checkmark-circle"></i>
                                @if($plan->page_permission_feature < 0)
                                    {{__('Page Unlimited')}}
                                @else
                                     {{ __(sprintf('Page %d', $plan->page_permission_feature) )}}
                                @endif
                            </p>
                            @endif
                            @if(!empty($plan->product_permission_feature))
                            <p><i class="lni lni-checkmark-circle"></i>
                                @if($plan->product_permission_feature < 0)
                                    {{__('Product Unlimited')}}
                                @else
                                    {{ __(sprintf('Product %d',$plan->product_permission_feature) )}}
                                @endif
                            </p>
                            @endif
                            @if(!empty($plan->blog_permission_feature))
                            <p><i class="lni lni-close"></i>
                                @if($plan->blog_permission_feature < 0)
                                    {{__('Blog Unlimited')}}
                                @else
                                    {{ __(sprintf('Blog %d',$plan->blog_permission_feature) )}}
                                @endif
                            </p>
                            @endif
                            @if(!empty($plan->storage_permission_feature))
                            <p><i class="lni lni-close"></i>
                                @if($plan->storage_permission_feature < 0)
                                    {{__('Storage Unlimited')}}
                                @else
                                    {{ __(sprintf('Storage %d MB',$plan->storage_permission_feature) )}}
                                @endif
                            </p>
                            @endif
                            <p><i class="lni lni-close"></i>No Tools</p>
                        </div>
                        <div class="btn-wrapper text-center view_all_features  mt-4 mt-lg-4">
                            <a href="{{route('landlord.frontend.plan.order',$plan->id)}}" target="_blank" class="">{{__('View All Features')}}</a>
                        </div>
                        <br>
                        @if($c%2==0)
                        <div class="button" onclick="select_plan({{ $plan->id }})"><a class="btn btn-warning" href="javascript:void(0)">Get Started</a></div>
                        @else
                        <div class="button" onclick="select_plan({{ $plan->id }})"><a class="btn btn-success btn-2" href="javascript:void(0)">Get Started</a></div>
                        @endif
                        </div>
                    </div>
                    @php $c++; @endphp
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>  
    </div>
</section>

<style>
        body{margin-top:20px;}
.price_plan_area {
    position: relative;
    z-index: 1;
    background-color: #f5f5ff;
}

.single_price_plan {
    position: relative;
    z-index: 1;
    border-radius: 0.5rem 0.5rem 0 0;
    -webkit-transition-duration: 500ms;
    transition-duration: 500ms;
    margin-bottom: 50px;
    background-color: #ffffff;
    padding: 3rem 4rem;
}
@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .single_price_plan {
        padding: 3rem;
    }
}
@media only screen and (max-width: 575px) {
    .single_price_plan {
        padding: 3rem;
    }
}
.single_price_plan::after {
    position: absolute;
    content: "";
    background-image: url("https://bootdey.com/img/half-circle-pricing.png");
    background-repeat: repeat;
    width: 100%;
    height: 17px;
    bottom: -17px;
    z-index: 1;
    left: 0;
}
.single_price_plan .title {
    text-transform: capitalize;
    -webkit-transition-duration: 500ms;
    transition-duration: 500ms;
    margin-bottom: 2rem;
}
.single_price_plan .title span {
    color: #ffffff;
    padding: 0.2rem 0.6rem;
    font-size: 12px;
    text-transform: uppercase;
    background-color: #2ecc71;
    display: inline-block;
    margin-bottom: 0.5rem;
    border-radius: 0.25rem;
}
.single_price_plan .title h3 {
    font-size: 1.25rem;
}
.single_price_plan .title p {
    font-weight: 300;
    line-height: 1;
    font-size: 14px;
}
.single_price_plan .title .line {
    width: 80px;
    height: 4px;
    border-radius: 10px;
    background-color: #3f43fd;
}
.single_price_plan .price {
    margin-bottom: 1.5rem;
}
.single_price_plan .price h4 {
    position: relative;
    z-index: 1;
    font-size: 2.4rem;
    line-height: 1;
    margin-bottom: 0;
    color: #3f43fd;
    display: inline-block;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-color: transparent;
    background-image: -webkit-gradient(linear, left top, right top, from(#e24997), to(#2d2ed4));
    background-image: linear-gradient(90deg, #e24997, #2d2ed4);
}
.single_price_plan .description {
    position: relative;
    margin-bottom: 1.5rem;
}
.single_price_plan .description p {
    line-height: 16px;
    margin: 0;
    padding: 10px 0;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -ms-grid-row-align: center;
    align-items: center;
}
.single_price_plan .description p i {
    color: #2ecc71;
    margin-right: 0.5rem;
}
.single_price_plan .description p .lni-close {
    color: #e74c3c;
}
.single_price_plan.active,
.single_price_plan:hover,
.single_price_plan:focus {
    -webkit-box-shadow: 0 6px 50px 8px rgba(21, 131, 233, 0.15);
    box-shadow: 0 6px 50px 8px rgba(21, 131, 233, 0.15);
}
.single_price_plan .side-shape img {
    position: absolute;
    width: auto;
    top: 0;
    right: 0;
    z-index: -2;
}

.section-heading h3 {
    margin-bottom: 1rem;
    font-size: 3.125rem;
    letter-spacing: -1px;
}

.section-heading p {
    margin-bottom: 0;
    font-size: 1.25rem;
}

.section-heading .line {
    width: 120px;
    height: 5px;
    margin: 30px auto 0;
    border-radius: 6px;
    background: #2d2ed4;
    background: -webkit-gradient(linear, left top, right top, from(#e24997), to(#2d2ed4));
    background: linear-gradient(to right, #e24997, #2d2ed4);
}
    </style>

<script>

function select_plan(plan_id){
    //ajax call for getting next form
    showLoader("Perfect Plan...moving to next step");
    callform(3, {{ $client_id }}, plan_id);
    
}

</script>