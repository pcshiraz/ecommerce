<div class="{{ isset($size) ? $size : config('platform.product-card-class') }}">
    <div class="card card-product mb-2" onclick="window.location='{{ route('product.view',['id' => $product->id]) }}'">
        @if($product->sale_price == 0)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-danger text-white shadow text-center"
                  style="position: absolute;right: 35%;"><i class="fa fa-free-code-camp"></i> رایگان</span>
        @elseif($product->off)
            <span class="h6 w-70 mx-auto px-2 py-1 rounded-bottom bg-primary text-white shadow text-center"
                  style="position: absolute;right: 35%;"><i class="fa fa-star"></i> فروش ویژه</span>
        @endif
        <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="image"
             style="width:100%">
        <div class="card-body">

            <h4 class="card-title text-center">
                {{$product->title}}
            </h4>

                    <p class="card-text">
                        @if($product->sale_price == 0)
                            <div class="card-price-free"><strong>رایگان</strong></div>
                        @else
                            @if($product->off)
                                <del class="clearfix card-price-del">{{ \App\Utils\MoneyUtil::format($product->sale_price) }}</del>
                                <strong class="clearfix card-price-off">{{ \App\Utils\MoneyUtil::format($product->off_price) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                            @else
                        <strong class="clearfix card-price">{{ \App\Utils\MoneyUtil::format($product->sale_price) }}  {{ trans('currency.'.config('platform.currency')) }}</strong>
                        @endif
                        @endif
                    </p>
                    <div class="clearfix">
                        <a href="{{ route('cart.add',['id'=>$product->id]) }}"
                           class="btn btn-warning btn-mobile btn-sm pull-left">
                            <i class="fa fa-cart-plus"></i> خرید
                        </a>
                    </div>
        </div>
    </div>
</div>