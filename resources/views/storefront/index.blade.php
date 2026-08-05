<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AM Printing</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/am-printing.css') }}">
</head>
<body>

@php
    $cat = collect($categories)->firstWhere('id', $activeCat);
@endphp

<header class="site">
  <div class="header-inner">
    <div class="brand">
      <h1>AM Printing</h1>
      <p>Documents, IDs, laminations and printed keepsakes &mdash; done while you wait.</p>
    </div>
    <div class="stamp-badge">Quality prints, fast turnaround</div>
  </div>
  <nav class="viewswitch">
    <a href="{{ route('storefront') }}" class="active">Storefront</a>
    <a href="{{ route('admin.products.index') }}">Staff panel</a>
  </nav>
</header>

<main>
  <div class="cat-tabs">
    @foreach ($categories as $c)
      <a class="cat-tab {{ $c['id'] === $activeCat ? 'active' : '' }}"
         href="{{ route('storefront', ['cat' => $c['id']]) }}">
        {!! \App\Support\CatalogIcons::svg($c['icon'] ?? 'photo') !!}
        <span>{{ $c['label'] }}</span>
      </a>
    @endforeach
  </div>

  <div class="panel">
    @if (!empty($cat['subcategories']))
      <div class="subcat-row">
        <a class="subcat-chip {{ empty($activeSub) ? 'active' : '' }}"
           href="{{ route('storefront', ['cat' => $activeCat]) }}">All templates</a>
        @foreach ($cat['subcategories'] as $s)
          <a class="subcat-chip {{ $activeSub === $s['id'] ? 'active' : '' }}"
             href="{{ route('storefront', ['cat' => $activeCat, 'sub' => $s['id']]) }}">{{ $s['label'] }}</a>
        @endforeach
      </div>
    @endif

    <div class="cat-heading">
      <h2>{{ $cat['label'] ?? $activeCat }}</h2>
      <span>{{ $items->count() }} item{{ $items->count() === 1 ? '' : 's' }}</span>
    </div>

    @if ($items->isEmpty())
      <div class="empty-state">No items in this category yet. Check back soon, or add one from the staff panel.</div>
    @else
      <div class="grid">
        @foreach ($items as $p)
          @php
            $tag = $p->subcategory ? $p->subcategoryLabel() : $p->categoryLabel();
          @endphp
          <div class="ticket">
            <div class="thumb">
              @if (!empty($p->image_url))
                <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
              @elseif (!empty($p->video_url))
                <video src="{{ $p->video_url }}" muted playsinline preload="metadata"></video>
              @else
                {!! \App\Support\CatalogIcons::svg($c['icon'] ?? 'photo') !!}
              @endif
              <span class="punch left"></span><span class="punch right"></span>
            </div>
            <div class="body">
              <span class="tag">{{ $tag }}</span>
              <h3>{{ $p->name }}</h3>
              <p class="desc">{{ $p->description }}</p>
              <div class="price-row">
                <span class="price">{{ number_format($p->price, 2) }}</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</main>

<footer>AM Printing</footer>
</body>
</html>
