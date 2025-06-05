<div class="container py-4">
    <div class="d-flex align-items-center mb-3 flex-nowrap w-100">
        <i class="bi bi-search me-2 fs-5"></i>
        <form id="searchForm" class="d-flex w-100">
            <input type="text" name="search" id="searchInput" class="form-control border-secondary me-2"
                placeholder="Search" autofocus />
            <button type="submit" class="btn btn-dark me-2">Search</button>
            <button type="button" class="btn btn-link text-dark p-0" onclick="toggleSearch(event)">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </form>
    </div>

    <div class="row">
        {{-- Suggestions Column --}}
        <div class="col-md-2 mb-4">
            <h6 class="fw-bold mb-3">POPULAR TAGS</h6>
            <div class="d-flex flex-wrap gap-2 mb-4">
                @foreach (['Top Catch', 'Hot', 'Best Seller', 'Seasonal', 'Limited'] as $item)
                    <span class="badge px-3 py-2 tags" style="border-radius: 50px;">{{ $item }}</span>
                @endforeach
            </div>

            <h6 class="fw-bold mb-3">SUGGESTED</h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach (['Bangus', 'Tulingan', 'Paltat', 'Tahong'] as $item)
                    <span class="badge border border-dark text-dark bg-transparent px-3 py-2 tags-dark"
                        style="border-radius: 50px;">{{ $item }}</span>
                @endforeach
            </div>
        </div>

        {{-- Results Column --}}
        <div class="col-md-10">
            <h6 class="fw-bold mb-3">FEATURED PRODUCTS</h6>
            <div class="row g-3">
                @foreach ($featured as $product)
                    <div class="col-6 col-sm-4 col-md-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="img-fluid rounded">
                        <p class="text-uppercase text-muted mt-2 mb-1 small">SeaMart</p>
                        <p class="fw-semibold mb-1">{{ $product->name }}</p>
                        <p class="text-muted mb-0">₱{{ number_format($product->price, 2) }} / kg</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <hr class="my-4">
            <h6 class="fw-bold mb-3">RESULTS FOR: "{{ $query }}"</h6>
            <div class="row g-3">
                @forelse ($results as $product)
                    <div class="col-6 col-sm-4 col-md-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="img-fluid rounded">
                        <p class="text-uppercase text-muted mt-2 mb-1 small">SeaMart</p>
                        <p class="fw-semibold mb-1">{{ $product->name }}</p>
                        <p class="text-muted mb-0">₱{{ number_format($product->price, 2) }} / kg</p>
                    </div>
                @empty
                    <p class="text-muted">No products found.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
