<br><br>

<link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css"> 
<section class="price_plan_area section_padding_130_80" id="pricing">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; margin-top:5vh; animation-delay: 0.2s; animation-name: fadeInUp;">
              <h4>Sub domain</h4>
              <p>Let's find out a good name for you.</p>
              <div class="line"></div>
            </div>
          </div>
        </div>
        
        <div class="row justify-content-center">
             <form action="javascript:void(0)" method="POST" enctype="multipart/form-data"
             class="contact-page-form style-01 custom--form order-form">
                @csrf
                <div class="form-group custom_subdomain_wrapper mt-3 mb-4">
                    <label for="custom-subdomain"
                           class="label-title mb-3">{{__('Add new subdomain')}}</label>

                    <div class="input-group mb-3">
                        @php
                            $base_url = str_replace(['http://','https://'], '', url('/'));
                        @endphp
                        <input type="text" class="form-control custom_subdomain" id="custom-subdomain" name="custom_subdomain" placeholder="{{__('Subdomain')}}" aria-label="Subdomain" aria-describedby="basic-addon2" autocomplete="off" value="">
                        <span class="input-group-text text-white" style="background: #000000; border: 2px solid #000000" id="basic-addon2">.{{$base_url}}</span>
                    </div>

                    <b><div id="subdomain-wrap"></div></b>
                </div>

                <button id="client-sdomain-btn" type="submit" name="button" class="btn btn-primary">{{ __('Next') }}</button>

             </form>
        </div>

    </div>
</section>

<script src="{{global_asset('assets/landlord/common/js/axios.min.js')}}"></script>
<x-custom-js.landloard-unique-subdomain-check :name="'custom_subdomain'"/>


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

$(document).on('click', '#client-sdomain-btn', function (e) {
    showLoader("Nice Name....moving for checkout");
    callform(5, {{ $client_id }}, {{ $plan_id }}, "{{ $theme_slug }}", $('input#custom-subdomain').val());
});

</script>