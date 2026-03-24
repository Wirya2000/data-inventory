@if (isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav aria-label="breadcrumb" class="mb-0">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        @forelse ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
        @empty
        @endforelse
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>
@endif
<h6 class="font-weight-bolder text-white mb-0">{{ $title }}</h6>
