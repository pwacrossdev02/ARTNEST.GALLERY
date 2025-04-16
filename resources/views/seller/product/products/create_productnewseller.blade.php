@extends('frontend.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="page-header mb-4">
        <h2 class="text-center">Upload New Product</h2>
    </div>

    <div class="page-content mx-0 container">
        <!-- Data type -->
        <input type="hidden" id="data_type" value="physical">
        <div class="row gutters-5">
            <div class="col-lg-8">
                @csrf
                <input type="hidden" name="added_by" value="seller">

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Product Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                            </div>
                        </div>
                        <div class="form-group row" id="brand">
                            <label class="col-md-3 col-form-label">{{ translate('Artists') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" required name="brand_id" id="brand_id"
                                    data-live-search="true">
                                    <option value="">{{ translate('Select Artists') }}</option>
                                    @foreach (\App\Models\Brand::all() as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                            <label class="font-weight-bold">{{ translate('Dimensions') }}</label>
                                            <div class="row">
                                                <!-- Width Field -->
                                                <div class="col-md-4">
                                                    <label>{{ translate('Width') }}</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="width" placeholder="{{ translate('Width') }}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Height Field -->
                                                <div class="col-md-4">
                                                    <label>{{ translate('Height') }}</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="height" placeholder="{{ translate('Height') }}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Depth Field -->
                                                <div class="col-md-4">
                                                    <label>{{ translate('Depth') }}</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="depth" placeholder="{{ translate('Depth') }}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">cm</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Weight') }} <small>({{ translate('In Kg') }})</small></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="weight" step="0.01" value="0.00"
                                    placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Price') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Unit Price(in EUROS)') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="{{ translate('Unit price') }}" name="unit_price" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Description') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

             
            </div>

            <div class="col-lg-4">

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Product Category') }}</h5>
        <h6 class="float-right fs-13 mb-0">
            {{ translate('Select Main') }}
            <span class="position-relative main-category-info-icon">
                <i class="las la-question-circle fs-18 text-info"></i>
                <span class="main-category-info bg-soft-info p-2 position-absolute d-none border">{{ translate('This will be used for commission based calculations and homepage category wise product Show.') }}</span>
            </span>
        </h6>
    </div>
    <style>
    .hummingbird-treeview, .hummingbird-treeview * {
    line-height: 18px;
}

</style>
    <div class="card-body">
        <div class="h-300px overflow-auto c-scrollbar-light">
            <ul class="hummingbird-treeview-converter list-unstyled" data-checkbox-name="category_ids[]" data-radio-name="category_id" style="line-height: 18px !important;">
                @foreach ($categories as $category)
                <li id="{{ $category->id }}">{{ $category->getTranslation('name') }}</li>
                    @foreach ($category->childrenCategories as $childCategory)
                        @include('backend.product.products.child_category', ['child_category' => $childCategory])
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">
            {{ translate('Shipping Configuration') }}
        </h5>
    </div>

    <div class="card-body">
        @if (get_setting('shipping_type') == 'product_wise_shipping')
            <div class="form-group row">
                <label class="col-md-6 col-from-label">{{ translate('Free Shipping') }}</label>
                <div class="col-md-6">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="radio" name="shipping_type" value="free" checked>
                        <span></span>
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-6 col-from-label">{{ translate('Flat Rate') }}</label>
                <div class="col-md-6">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="radio" name="shipping_type" value="flat_rate">
                        <span></span>
                    </label>
                </div>
            </div>

            <div class="flat_rate_shipping_div" style="display: none">
                <div class="form-group row">
                    <label class="col-md-6 col-from-label">{{ translate('Shipping cost') }}</label>
                    <div class="col-md-6">
                        <input type="number" lang="en" min="0" value="0"
                            step="0.01" placeholder="{{ translate('Shipping cost') }}"
                            name="flat_shipping_cost" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-6 col-from-label">{{translate('Is Product Quantity Mulitiply')}}</label>
                <div class="col-md-6">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" name="is_quantity_multiplied" value="1">
                        <span></span>
                    </label>
                </div>
            </div>
        @else
            <p>
                {{ translate('Shipping configuration is maintained by Admin.') }}
            </p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Cash On Delivery') }}</h5>
    </div>
    <div class="card-body">
        @if (get_setting('cash_payment') == '1')
            <div class="form-group row">
                <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                <div class="col-md-6">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" name="cash_on_delivery" value="1" checked="">
                        <span></span>
                    </label>
                </div>
            </div>
        @else
            <p>
                {{ translate('Cash On Delivery activation is maintained by Admin.') }}
            </p>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Estimate Shipping Time') }}</h5>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label for="name">
                {{ translate('Shipping Days') }}
            </label>
            <div class="input-group">
                <input type="number" class="form-control" name="est_shipping_days" min="1"
                    step="1" placeholder="{{ translate('Shipping Days') }}">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend">{{ translate('Days') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('VAT & Tax') }}</h5>
    </div>
    <div class="card-body">
        @foreach (\App\Models\Tax::where('tax_status', 1)->get() as $tax)
            <label for="name">
                {{ $tax->name }}
                <input type="hidden" value="{{ $tax->id }}" name="tax_id[]">
            </label>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="number" lang="en" min="0" value="0" step="0.01"
                        placeholder="{{ translate('Tax') }}" name="tax[]" class="form-control"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control aiz-selectpicker" name="tax_type[]">
                        <option value="amount">{{ translate('Flat') }}</option>
                        <option value="percent">{{ translate('Percent') }}</option>
                    </select>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>

<div class="col-12 text-right">
    <a href="{{ route('shops.create') }}" class="btn btn-primary">
        {{ translate('Upload Product') }}
    </a>
</div>

        </div>

        <div class="mt-4 text-center">
            <p class="text-muted">
                For uploading images and adding more details, please click on 
                <a href="{{ route('shops.create') }}" class="text-primary">Upload</a>.
            </p>
        </div>
    </div>
</div>

@endsection

@section('modal')
	<!-- Frequently Bought Product Select Modal -->
    @include('modals.product_select_modal')
@endsection

@section('script')
<!-- Treeview js -->
<script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#treeview").hummingbird();

        $('#treeview input:checkbox').on("click", function (){
            let $this = $(this);
            if ($this.prop('checked') && ($('#treeview input:radio:checked').length == 0)) {
                let val = $this.val();
                $('#treeview input:radio[value='+val+']').prop('checked',true);
            }
        });
    });

    $("[name=shipping_type]").on("change", function() {
        $(".product_wise_shipping_div").hide();
        $(".flat_rate_shipping_div").hide();
        if ($(this).val() == 'product_wise') {
            $(".product_wise_shipping_div").show();
        }
        if ($(this).val() == 'flat_rate') {
            $(".flat_rate_shipping_div").show();
        }

    });

    function add_more_customer_choice_option(i, name) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '{{ route('seller.products.add-more-choice-option') }}',
            data: {
                attribute_id: i
            },
            success: function(data) {
                var obj = JSON.parse(data);
                $('#customer_choice_options').append('\
                    <div class="form-group row">\
                        <div class="col-md-3">\
                            <input type="hidden" name="choice_no[]" value="' + i + '">\
                            <input type="text" class="form-control" name="choice[]" value="' + name +
                    '" placeholder="{{ translate('Choice Title') }}" readonly>\
                        </div>\
                        <div class="col-md-8">\
                            <select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_' + i + '[]" multiple>\
                                ' + obj + '\
                            </select>\
                        </div>\
                    </div>');
                AIZ.plugins.bootstrapSelect('refresh');
            }
        });


    }

    $('input[name="colors_active"]').on('change', function() {
        if (!$('input[name="colors_active"]').is(':checked')) {
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        } else {
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });

    $(document).on("change", ".attribute_choice", function() {
        update_sku();
    });

    $('#colors').on('change', function() {
            update_sku();
        });

    $('input[name="unit_price"]').on('keyup', function() {
        update_sku();
    });

    // $('input[name="name"]').on('keyup', function() {
    //     update_sku();
    // });

    function delete_row(em) {
        $(em).closest('.form-group row').remove();
        update_sku();
    }

    function delete_variant(em) {
        $(em).closest('.variant').remove();
    }

    function update_sku() {
        $.ajax({
            type: "POST",
            url: '{{ route('seller.products.sku_combination') }}',
            data: $('#choice_form').serialize(),
            success: function(data) {
                $('#sku_combination').html(data);
                AIZ.uploader.previewGenerate();
                AIZ.plugins.sectionFooTable('#sku_combination');
                if (data.trim().length > 1) {
                    $('#show-hide-div').hide();
                } else {
                    $('#show-hide-div').show();
                }
            }
        });
    }

    $('#choice_attributes').on('change', function() {
        $('#customer_choice_options').html(null);
        $.each($("#choice_attributes option:selected"), function() {
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
        update_sku();
    });

    function fq_bought_product_selection_type(){
        var productSelectionType = $("input[name='frequently_bought_selection_type']:checked").val();
        if(productSelectionType == 'product'){
            $('.fq_bought_select_product_div').removeClass('d-none');
            $('.fq_bought_select_category_div').addClass('d-none');
        }
        else if(productSelectionType == 'category'){
            $('.fq_bought_select_category_div').removeClass('d-none');
            $('.fq_bought_select_product_div').addClass('d-none');
        }
    }

    function showFqBoughtProductModal() {
        $('#fq-bought-product-select-modal').modal('show', {backdrop: 'static'});
    }

    function filterFqBoughtProduct() {
        var searchKey = $('input[name=search_keyword]').val();
        var fqBroughCategory = $('select[name=fq_brough_category]').val();
        $.post('{{ route('seller.product.search') }}', { _token: AIZ.data.csrf, product_id: null, search_key:searchKey, category:fqBroughCategory, product_type:"physical" }, function(data){
            $('#product-list').html(data);
            AIZ.plugins.sectionFooTable('#product-list');
        });
    }

    function addFqBoughtProduct() {
        var selectedProducts = [];
        $("input:checkbox[name=fq_bought_product_id]:checked").each(function() {
            selectedProducts.push($(this).val());
        });

        var fqBoughtProductIds = [];
        $("input[name='fq_bought_product_ids[]']").each(function() {
            fqBoughtProductIds.push($(this).val());
        });

        var productIds = selectedProducts.concat(fqBoughtProductIds.filter((item) => selectedProducts.indexOf(item) < 0))

        $.post('{{ route('seller.get-selected-products') }}', { _token: AIZ.data.csrf, product_ids:productIds}, function(data){
            $('#fq-bought-product-select-modal').modal('hide');
            $('#selected-fq-bought-products').html(data);
            AIZ.plugins.sectionFooTable('#selected-fq-bought-products');
        });
    }

</script>

@include('partials.product.product_temp_data')

@endsection
