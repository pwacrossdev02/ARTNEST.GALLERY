@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-titlebar mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="fs-20 fw-700 text-dark">{{ translate('Add Your Product') }}</h1>
        </div>
      </div>
    </div>
    
    <!-- Language -->
    <ul class="nav nav-tabs nav-fill language-bar">
		@foreach (get_all_active_language() as $key => $language)
            <li class="nav-item">
                <a class="nav-link text-reset rounded-0 @if ($language->code == $lang) active @endif py-3" href="{{ route('customer_products.edit', ['id'=>$product->id, 'lang'=> $language->code] ) }}">
                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                    <span>{{ $language->name }}</span>
                </a>
            </li>
        @endforeach
	</ul>

    <form class="" action="{{route('customer_products.update', $product->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" name="lang" value="{{ $lang }}">
        @csrf
        
        <!-- General -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('General')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Product Name')}} <span class="text-danger">* <i class="las la-language" title="{{translate('Translatable')}}"></i></span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" name="name" value="{{ $product->getTranslation('name') }}" placeholder="{{ translate('Product Name')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Product Category')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select a Category')}}" id="categories" name="category_id" data-live-search="true" data-selected={{ $product->category_id }} required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @foreach ($category->childrenCategories as $childCategory)
                                    @include('categories.child_category', ['child_category' => $childCategory])
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Product Brand')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <select class="form-control selectpicker" data-placeholder="{{ translate('Select a brand')}}" data-live-search="true"  id="brands" name="brand_id">
                            <option value=""></option>
                            @foreach (get_all_brands() as $brand)
                                <option value="{{ $brand->id }}" @if($brand->id == $product->brand_id) selected @endif>{{ $brand->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
<!-- Product Unit -->
<div class="form-group row">
    <label class="col-md-2 col-from-label">{{ translate('Product Unit') }} 
        <span class="text-danger">* <i class="las la-language" title="{{ translate('Translatable') }}"></i></span>
    </label>
    <div class="col-md-10">
        <input type="text" class="form-control rounded-0" name="unit" 
            value="{{ $product->getTranslation('unit') }}" placeholder="{{ translate('Product unit') }}" required>
    </div>
</div>

<!-- Width -->
<div class="form-group row">
    <label class="col-md-2 col-from-label">{{ translate('Width') }} 
        <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i>
    </label>
    <div class="col-md-10">
        <input type="number" class="form-control rounded-0" name="width" 
            value="{{ $product->getTranslation('width') }}" placeholder="{{ translate('Width in cm') }}" required>
    </div>
</div>

<!-- Height -->
<div class="form-group row">
    <label class="col-md-2 col-from-label">{{ translate('Height') }} 
        <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i>
    </label>
    <div class="col-md-10">
        <input type="number" class="form-control rounded-0" name="height" 
            value="{{ $product->getTranslation('height') }}" placeholder="{{ translate('Height in cm') }}" required>
    </div>
</div>

<!-- Depth -->
<div class="form-group row">
    <label class="col-md-2 col-from-label">{{ translate('Depth') }} 
        <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i>
    </label>
    <div class="col-md-10">
        <input type="number" class="form-control rounded-0" name="depth" 
            value="{{ $product->getTranslation('depth') }}" placeholder="{{ translate('Depth in cm') }}" required>
    </div>
</div>

                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Condition')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <select class="form-control selectpicker" data-placeholder="{{ translate('Select a condition')}}" id="conditon" name="conditon" required>
                            <option value="new" @if ($product->conditon == 'new') selected @endif>{{ translate('New')}}</option>
                            <option value="used" @if ($product->conditon == 'used') selected @endif>{{ translate('Used')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Location')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" name="location" value="{{ $product->location }}" placeholder="{{ translate('Location')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{ translate('Product Tag')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control aiz-tag-input rounded-0" name="tags[]" value="{{ $product->tags }}" placeholder="{{ translate('Type & hit enter')}}">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Images -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('Images')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Main Images')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photos" class="selected-files" value="{{ $product->photos }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Thumbnail Image')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="thumbnail_img" class="selected-files" value="{{ $product->thumbnail_img }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Videos -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('Videos')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Video From')}}</label>
                    <div class="col-md-10">
                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" name="video_provider">
                            <option value="youtube" @if ($product->video_provider == 'youtube') selected @endif>{{ translate('Youtube')}}</option>
                            <option value="dailymotion" @if ($product->video_provider == 'dailymotion') selected @endif>{{ translate('Dailymotion')}}</option>
                            <option value="vimeo" @if ($product->video_provider == 'vimeo') selected @endif>{{ translate('Vimeo')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Video URL')}}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" name="video_link" value="{{ $product->video_link }}" placeholder="{{ translate('Video link')}}">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Meta Tags -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('Meta Tags')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Meta Title')}}</label>
                    <div class="col-md-10">
                        <input type="text" name="meta_title" value="{{ $product->meta_title }}" class="form-control rounded-0" placeholder="{{ translate('Meta Title')}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Description')}}</label>
                    <div class="col-md-10">
                        <textarea name="meta_description" rows="8" class="form-control rounded-0">{{ $product->meta_description }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{ translate('Meta Image')}}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="meta_img" class="selected-files" value="{{ $product->meta_img }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{translate('Slug')}}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" name="slug" value="{{ $product->slug }}" placeholder="{{translate('Slug')}}">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Price -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('Price')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{ translate('Unit Price')}} <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="number" lang="en" value="{{ $product->unit_price }}"  min="0" step="0.01" class="form-control rounded-0" name="unit_price" placeholder="{{ translate('Unit Price')}} ({{ translate('Base Price')}})" required>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('Description')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{ translate('Description')}} <span class="text-danger">* <i class="las la-language" title="{{translate('Translatable')}}"></i></span></label>
                    <div class="col-md-10">
                        <div class="mb-3">
                            <textarea class="aiz-text-editor rounded-0" name="description" required>{{$product->getTranslation('description')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- PDF Specification -->
        <div class="card rounded-0 shadow-none border">
            <div class="card-header border-bottom-0">
                <h5 class="mb-0 fs-18 fw-700 text-dark">{{translate('PDF Specification')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-from-label">{{ translate('PDF')}}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="document">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="pdf" class="selected-files" value="{{ $product->pdf }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Save Button -->
        <div class="mar-all text-right">
            <button type="submit" name="button" class="btn btn-primary rounded-0 px-4">{{ translate('Update Product') }}</button>
        </div>
    </form>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        AIZ.plugins.tagify();
    });
</script>
@endsection
