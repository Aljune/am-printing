<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff panel &middot; AM Printing</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/am-printing.css') }}">
</head>
<body>

@php
    $allSubcats = collect($categories)->flatMap(fn ($c) => $c['subcategories'] ?? []);
@endphp

<header class="site">
  <div class="header-inner">
    <div class="brand">
      <h1>AM Printing</h1>
      <p>Staff panel &mdash; manage the catalog customers see.</p>
    </div>
    <div class="stamp-badge">Quality prints, fast turnaround</div>
  </div>
  <nav class="viewswitch">
    <a href="{{ route('storefront') }}">Storefront</a>
    <a href="{{ route('admin.products.index') }}" class="active">Staff panel</a>
  </nav>
</header>

<main>
  @if (session('status'))
    <div class="alert success">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert">
      <ul style="margin:0; padding-left:1.1rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="admin-grid">
    <div class="panel standalone">
      <h3 class="section-title">{{ $editing ? 'Edit item' : 'Add a new item' }}</h3>
      <p class="hint">Fill in the details below, then save. Items appear on the storefront right away.</p>

      <form method="post"
            action="{{ $editing ? route('admin.products.update', $editing->id) : route('admin.products.store') }}"
            enctype="multipart/form-data">
        @csrf

        <div class="field">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="e.g. A4 document printing"
                 value="{{ old('name', $editing->name ?? '') }}">
        </div>

        <div class="field">
          <label for="description">Description</label>
          <textarea id="description" name="description" placeholder="Short description customers will see">{{ old('description', $editing->description ?? '') }}</textarea>
        </div>

        <div class="field">
          <label for="price">Price (PHP)</label>
          <input type="number" id="price" name="price" min="0" step="0.01" placeholder="0.00"
                 value="{{ old('price', $editing->price ?? '') }}">
        </div>

        <div class="field">
          <label for="category">Category</label>
          <select id="category" name="category">
            @foreach ($categories as $c)
              <option value="{{ $c['id'] }}" {{ old('category', $editing->category ?? '') === $c['id'] ? 'selected' : '' }}>
                {{ $c['label'] }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="field">
          <label for="subcategory">Template subcategory</label>
          <select id="subcategory" name="subcategory">
            <option value="">Not applicable</option>
            @foreach ($allSubcats as $s)
              <option value="{{ $s['id'] }}" {{ old('subcategory', $editing->subcategory ?? '') === $s['id'] ? 'selected' : '' }}>
                {{ $s['label'] }}
              </option>
            @endforeach
          </select>
          <span class="hint" style="margin-bottom:0;">Only used when the category is Template design.</span>
        </div>

        <div class="field">
          <label for="image">Image</label>
          <div class="imgpick">
            <div class="preview">
              @if (!empty($editing->image_url))
                <img src="{{ $editing->image_url }}">
              @else
                {!! \App\Support\CatalogIcons::svg('photo') !!}
              @endif
            </div>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp, image/gif">
          </div>
        </div>

        <div class="field">
          <label for="video">Video (optional)</label>
          <div class="imgpick">
            <div class="preview">
              @if (!empty($editing->video_url))
                <video src="{{ $editing->video_url }}" muted></video>
              @else
                {!! \App\Support\CatalogIcons::svg('photo') !!}
              @endif
            </div>
            <input type="file" id="video" name="video" accept="video/mp4, video/webm, video/quicktime">
          </div>
          <span class="hint" style="margin-bottom:0;">Used instead of the image on the storefront card if no image is set.</span>
        </div>

        <div class="form-actions">
          <button class="btn" type="submit">{{ $editing ? 'Save changes' : 'Add item' }}</button>
          @if ($editing)
            <a class="btn secondary" href="{{ route('admin.products.index') }}">Cancel</a>
          @endif
        </div>
      </form>
    </div>

  <div class="panel standalone">
    <h3 class="section-title">Current catalog ({{ $products->total() }})</h3>
    <div class="admin-list">
      @if ($products->isEmpty())
        <div class="empty-state">No items yet. Add your first one on the left.</div>
      @else
        @foreach ($products as $p)
          @php
            $tag = $p->categoryLabel();
            if (!empty($p->subcategory)) { $tag .= ' · ' . $p->subcategoryLabel(); }
          @endphp
          <div class="admin-row">
            <div class="thumb-sm">
              @if (!empty($p->image_url))
                <img src="{{ $p->image_url }}">
              @elseif (!empty($p->video_url))
                <video src="{{ $p->video_url }}" muted></video>
              @else
                {!! \App\Support\CatalogIcons::svg('photo') !!}
              @endif
            </div>
            <div class="info">
              <strong>{{ $p->name }}</strong>
              <span>{{ $tag }} &middot; {{ number_format($p->price, 2) }}</span>
            </div>
            <div class="row-actions">
              <a href="{{ route('admin.products.index', ['edit' => $p->id]) }}">Edit</a>
              <form method="post" action="{{ route('admin.products.destroy', $p->id) }}"
                    onsubmit="return confirm('Delete this item?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
              </form>
            </div>
          </div>
        @endforeach
      @endif
    </div>

    @if ($products->hasPages())
      <div class="pagination">
        @if ($products->onFirstPage())
          <span class="btn secondary disabled">Prev</span>
        @else
          <a class="btn secondary" href="{{ $products->previousPageUrl() }}">Prev</a>
        @endif

        <span class="pagination-info">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>

        @if ($products->hasMorePages())
          <a class="btn secondary" href="{{ $products->nextPageUrl() }}">Next</a>
        @else
          <span class="btn secondary disabled">Next</span>
        @endif
      </div>
    @endif
  </div>
  </div>

  <p style="margin-top:2rem;">
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
  </p>
</main>

</body>
</html>
