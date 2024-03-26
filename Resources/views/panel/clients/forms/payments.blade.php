<br><br>

<link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css"> 
<section class="price_plan_area section_padding_130_80" id="pricing">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section-heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; margin-top:5vh; animation-delay: 0.2s; animation-name: fadeInUp;">
              <h4>Let's Checkout</h4>
              <p>We support a number of payment gateways.</p>
              <div class="line"></div>
            </div>
          </div>
        </div>
        
        <div class="row justify-content-center">
            <form action="{{ route('landlord.agent.client.order.payment.form') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="theme_slug" id="theme-slug" value="{{ $theme_slug }}">
                <input type="hidden" name="payment_gateway" value="" class="payment_gateway_passing_clicking_name">
                <input type="hidden" name="package_id" value="{{ $plan_id }}">

                @if($order_details->price != 0)
                    <div class="mt-5">
                        {!! (new \App\Helpers\PaymentGatewayRenderHelper())->renderPaymentGatewayForForm() !!}
                    </div>
                @endif

                <input type="hidden" name="subdomain" value="custom_domain__dd">
                <input type="hidden" name="custom_subdomain" value="{{ $subdomain }}">
                <input type="hidden" name="client_id" value="{{ $client_id }}">
                
                <div class="form-group single-input d-none manual_transaction_id mt-4 mpay">
                    @if(!empty($payment_gateways))
                        <p class="alert alert-info ">{{json_decode($payment_gateways->credentials)->description ?? ''}}</p>
                    @endif
                
                    <input type="text" name="trasaction_id"
                           class="form-control form--control mt-2"
                           placeholder="{{__('Transaction ID')}}">
                
                    <input type="file" name="trasaction_attachment"
                           class="form-control form--control mt-2"
                           placeholder="{{__('Transaction Attachment')}}" accept="image/*">
                </div>

                <div class="col-10">
                    <button id="client-checkout-btn" type="submit" name="button" class="btn btn-primary">{{ __('Checkout') }}</button>
                </div>
            </form>
        </div>

    </div>
</section>

<style>
body{margin-top:20px;}

.mpay{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 5vh;
}
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

<style>
.img-select > img{
    max-width: 100%;
}
.img-select > img, svg{
    vertical-align: middle;
}
.payment-gateway-wrapper ul {
            flex-wrap: wrap;
            display: flex;
        }

        .payment-gateway-wrapper ul li {
            max-width: 100px;
            cursor: pointer;
            box-sizing: border-box;
            height: 50px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .payment-gateway-wrapper ul li {
            margin: 3px;
            border: 1px solid #ddd;
        }

        @media only screen and (max-width: 375px) {
            /*.payment-gateway-wrapper ul li {*/
            /*    width: calc(100% / 3);*/
            /*}*/
        }


        .payment-gateway-wrapper ul li.selected:after, .payment-gateway-wrapper ul li.selected:before {
            visibility: visible;
            opacity: 1;
        }

        .payment-gateway-wrapper ul li:before {
            border: 2px solid #00eb14;
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            height: 100%;
            content: '';
            visibility: hidden;
            opacity: 0;
            transition: all .3s;
        }

        .payment-gateway-wrapper ul li.selected:after, .payment-gateway-wrapper ul li.selected:before {
            visibility: visible;
            opacity: 1;
        }

        .payment-gateway-wrapper ul li:after {
            position: absolute;
            right: 0;
            top: 0;
            width: 15px;
            height: 15px;
            background-color: #03c814;
            content: "\f00c";
            font-weight: 900;
            color: #fff;
            font-family: 'Line Awesome Free';
            font-weight: 900;
            font-size: 10px;
            line-height: 10px;
            text-align: center;
            padding-top: 2px;
            padding-left: 2px;
            visibility: hidden;
            opacity: 0;
            transition: all .3s;
        }
</style>

<script>
var defaulGateway = $('#site_global_payment_gateway').val();
                $('.payment-gateway-wrapper ul li[data-gateway="' + defaulGateway + '"]').addClass('selected');

                let customFormParent = $('.payment_gateway_extra_field_information_wrap');
                customFormParent.children().hide();

                $(document).on('click', '.payment-gateway-wrapper > ul > li', function (e) {
                    e.preventDefault();

                    let gateway = $(this).data('gateway');
                    let manual_transaction_div = $('.manual_transaction_id');
                    let summernot_wrap_div = $('.summernot_wrap');

                    customFormParent.children().hide();
                    if (gateway === 'manual_payment') {
                        manual_transaction_div.fadeIn();
                        summernot_wrap_div.fadeIn();
                        manual_transaction_div.removeClass('d-none');
                    } else {
                        manual_transaction_div.addClass('d-none');
                        summernot_wrap_div.fadeOut();
                        manual_transaction_div.fadeOut();

                        let wrapper = customFormParent.find('#'+gateway+'-parent-wrapper');
                        if (wrapper.length > 0)
                        {
                            wrapper.fadeIn();
                        }
                    }

                    $(this).addClass('selected').siblings().removeClass('selected');
                    $('.payment-gateway-wrapper').find(('input')).val($(this).data('gateway'));
                    $('.payment_gateway_passing_clicking_name').val($(this).data('gateway'));
                });
</script>