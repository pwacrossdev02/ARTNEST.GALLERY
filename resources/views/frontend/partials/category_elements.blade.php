<div class="">
    @foreach ($categories->childrenCategories as $key => $category)
    <div class="card shadow-none border-0 w-50 mb-0">
        <ul class="list-unstyled w-100">
            <li class="fs-14 fw-700 mb-3">
                <a class="text-reset hov-text-primary" href="{{ route('products.category', $category->slug) }}">
                    {{ $category->getTranslation('name') }}
                </a>
            </li>
            @if($category->childrenCategories->count())
            <div class="childerns_grid ">
                @foreach ($category->childrenCategories as $key => $child_category)
                <li class="fs-14 pl-2">
                    <a class="text-reset hov-text-primary animate-underline-primary child-link" href="{{ route('products.category', $child_category->slug) }}">
                   <span>{{ $child_category->getTranslation('name') }}</span>
                    </a>
                </li>
                @endforeach
            </div>
            @endif
        </ul>
    </div>
    @endforeach
</div>