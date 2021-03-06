<div class="panel @if (Route::is('ad.preview')) panel-primary @else panel-default @endif">
    @if (Route::is('ad.preview'))
    <div class="panel-heading">
      <h4 class="text-center"><i class="fa fa-home"></i> {!! trans('frontend.ad.preview_mode') !!}</h4>
    </div>
    @endif
    <div class="panel-body">
        <div class="panel-title ad-title">
          <h4 id="zedx-ad-title" class="ad-title">{{ $ad->content->title }}
          @if (($price = $ad->price()) && isset($price->pivot))
          <span class="pull-right ad-price">
            <span class="label label-danger">{{ number_format($price->pivot->value, trans('frontend.format.number.decimals') , trans('frontend.format.number.dec_point'), trans('frontend.format.number.thousands_sep'))." ".getAdCurrency($ad, $price->unit) }}
            </span>
          </span>
          @endif
          </h4>
        </div>
        <hr >
        @if ($main_pic = $ad->photos()->main()->first())
        <div class="row">
            <div class="col-md-12">
                <img id="main_image" class="img-rounded img-responsive center-block" data-root-path = "{{ image_route('large', '') }}" src="{{ image_route('large', $main_pic->path) }}" alt="">
            </div>
        </div>
        @endif
        @if ($ad->photos()->count() > 1)
        <div class="row top-buffer">
        @foreach ($ad->photos()->get() as $photo)
            <div class="col-xs-3 col-sm-2">
                <img class="img-rounded img-ressponsive small-image" data-path="{{ $photo->path }}" src="{{ image_route('thumb', $photo->path) }}" alt="">
            </div>
        @endforeach
        </div>
        @endif
        <hr/>
        @if ($ad->videos()->count())
        <div id="videos" class="row top-buffer" data-videos="{{ $ad->videos }}">
          <script type="x-tmpl-mustache" id="videoTemplate">
          @{{#.}}
            <div class="col-md-3" id="video_@{{link}}">
                <div class="thumbnail">
                  <div class="js-lazyYT" data-youtube-id="@{{link}}" data-ratio="16:9"></div>
                </div>
              <input type="hidden" name="videos[][link]" value="@{{link}}">
            </div>
          @{{/.}}
          </script>
        </div>
        <hr/>
        @endif

        @if ($ad->has('fields') && $ad->fields()->count())
        <table class="table table-striped table-hover ">
          <tbody id="adFields" data-currency="{{ getAdCurrency($ad, '{currency}') }}" data-fields="{{ $fields }}" data-type = "show" data-category-api-url= "{{ route('zxajax.category.searchFields', $ad->category->id) }}">
          </tbody>
        </table>
          <script type="x-tmpl-mustache" id="adFieldsTemplate_multiple">
            <tr>
              <td><strong>@{{name}}</strong></td> :
              <td>
                @{{#select}}
                  @{{#selected}}
                  <span class="label label-primary margin-right-10">@{{name}} @{{unit}}</span>
                  @{{/selected}}
                @{{/select}}
              </td>
            </tr>
          </script>
          <script type="x-tmpl-mustache" id="adFieldsTemplate_selectbox">
            <tr>
              <td><strong>@{{name}}</strong></td> :
                @{{#select}}
                  @{{#selected}}
                  <td>@{{name}} @{{unit}}</td>
                  @{{/selected}}
                @{{/select}}
            </tr>
          </script>
          <script type="x-tmpl-mustache" id="adFieldsTemplate_input" data-format-decimals = "{{ trans('frontend.format.number.decimals') }}" data-format-dec = "{{ trans('frontend.format.number.dec_point') }}" data-format-thousands = "{{ trans('frontend.format.number.thousands_sep') }}" >
          @{{#value}}
            <tr>
              <td><strong>@{{name}}</strong></td> :
            @{{#input}}
              <td>@{{value}}</td>
            @{{/input}}

            @{{#inputGroup}}
                <td>@{{value}} @{{unit}}</td>
            @{{/inputGroup}}
            </tr>
          @{{/value}}
          </script>
        <hr/>
        @endif
        <h2>{!! trans('frontend.ad.description') !!}</h2>
        <div class="row top-buffer">
            <div class="col-md-12">
              <div id="zedx-ad-description" class="ad-description">{{ $ad->content->body }}</div>
            </div>
        </div>
    </div>
</div>
