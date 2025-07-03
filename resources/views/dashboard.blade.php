@extends('layouts.app')

@section('content')
<div class="container-xl px-3 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 text-primary fw-bold mb-1">
                <i class="bi bi-speedometer2 me-2"></i> ផ្ទាំងគ្រប់គ្រង
            </h1>
            <div class="text-muted small">សូមស្វាគមន៍មកវិញ! នេះជាស្ថានភាពស្តុកបច្ចុប្បន្នរបស់អ្នក។</div>
        </div>
    </div>
    <!-- Summary Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card summary-card border-0 shadow-sm text-center">
                <div class="card-body px-2 py-4">
                    <div class="summary-icon bg-primary mb-2 mx-auto">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="fs-4 fw-bold">{{ number_format($totalItems) }}</div>
                    <div class="text-muted small">ទំនិញសរុប</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card summary-card border-0 shadow-sm text-center">
                <div class="card-body px-2 py-4">
                    <div class="summary-icon bg-success mb-2 mx-auto">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="fs-4 fw-bold">{{ number_format($totalSuppliers) }}</div>
                    <div class="text-muted small">អ្នកផ្គត់ផ្គង់សកម្ម</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card summary-card border-0 shadow-sm text-center">
                <div class="card-body px-2 py-4">
                    <div class="summary-icon bg-warning mb-2 mx-auto">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="fs-4 fw-bold">{{ number_format($lowStockItems->count()) }}</div>
                    <div class="text-muted small">ស្តុកតិច</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card summary-card border-0 shadow-sm text-center">
                <div class="card-body px-2 py-4">
                    <div class="summary-icon bg-info mb-2 mx-auto">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="fs-4 fw-bold">{{ number_format($pendingOrders) }}</div>
                    <div class="text-muted small">កំពុងរង់ចាំ</div>
                </div>
            </div>
        </div>
    </div>
    <!-- 2 Columns: Alerts & Recent Orders -->
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-1 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    <span class="fw-semibold">ស្តុកតិច</span>
                    @if($lowStockItems->count() > 0)
                        <span class="badge bg-warning ms-auto">{{ $lowStockItems->count() }}</span>
                    @endif
                </div>
                <div class="card-body pt-2">
                    @if($lowStockItems->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($lowStockItems->take(5) as $item)
                                <li class="d-flex align-items-center py-2 border-bottom">
                                    <div class="summary-icon bg-warning me-2" style="width:2rem;height:2rem">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <div class="text-muted small">
                                            <i class="bi bi-graph-down me-1"></i>បច្ចុប្បន្ន: <b>{{ number_format($item->current_stock) }}</b>
                                            <span class="ms-2"><i class="bi bi-flag me-1"></i>អប្បបរមា: <b>{{ number_format($item->minimum_stock) }}</b></span>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-dark ms-2">
                                        {{ $item->minimum_stock > 0 ? round(($item->current_stock / $item->minimum_stock) * 100) : 0 }}%
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        @if($lowStockItems->count() > 5)
                            <div class="text-center mt-2">
                                <a href="{{ route('inventory.index', ['filter' => 'low']) }}" class="btn btn-outline-primary btn-sm">មើលបន្ថែម</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success fs-2"></i>
                            <div class="small text-muted mt-2">ទំនិញទាំងអស់មានស្តុកគ្រប់គ្រាន់</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-1 d-flex align-items-center">
                    <i class="bi bi-clock-history text-info me-2"></i>
                    <span class="fw-semibold">ការបញ្ជាទិញថ្មីៗ</span>
                </div>
                <div class="card-body pt-2">
                    @if($recentOrders->count() > 0)
                        <ul class="list-unstyled mb-0">
                        @foreach($recentOrders->take(5) as $order)
                            <li class="d-flex align-items-center py-2 border-bottom">
                                <div class="summary-icon bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'partial' ? 'warning' : 'secondary') }} me-2" style="width:2rem;height:2rem">
                                    <i class="bi bi-{{ $order->status == 'completed' ? 'check-circle' : ($order->status == 'partial' ? 'clock' : 'hourglass') }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $order->inventoryItem->name }}</div>
                                    <div class="text-muted small">
                                        <i class="bi bi-building me-1"></i>{{ $order->supplier->name }}
                                        <span class="ms-2"><i class="bi bi-box me-1"></i>បរិមាណ: {{ number_format($order->quantity_ordered) }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'partial' ? 'warning' : 'secondary') }}-subtle text-dark ms-2">
                                    @if($order->status == 'completed')
                                    បានបញ្ចប់
                                    @elseif($order->status == 'partial')
                                    មិនពេញលេញ
                                    @elseif($order->status == 'pending')
                                    កំពុងរង់ចាំ
                                    @else
                                    {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                        </ul>
                        @if($recentOrders->count() > 5)
                            <div class="text-center mt-2">
                                <a href="{{ route('restock.index') }}" class="btn btn-outline-primary btn-sm">មើលបន្ថែម</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-info fs-2"></i>
                            <div class="small text-muted mt-2">គ្មានការបញ្ជាទិញថ្មីៗ</div>
                            @if(class_exists('\App\Models\RestockOrder'))
                                <a href="{{ route('restock.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-circle me-1"></i> បង្កើតការបញ្ជាទិញថ្មី
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="row g-3 mt-0">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="row g-2">
                        <div class="col-6 col-md-3">
                            <a href="{{ route('inventory.create') }}" class="quick-action">
                                <i class="bi bi-plus-circle"></i>
                                <span>បន្ថែមទំនិញថ្មី</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('inventory.index') }}" class="quick-action">
                                <i class="bi bi-list-ul"></i>
                                <span>មើលស្តុកទំនិញ</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('suppliers.index') }}" class="quick-action">
                                <i class="bi bi-people"></i>
                                <span>គ្រប់គ្រងអ្នកផ្គត់ផ្គង់</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                        @if(class_exists('\App\Models\RestockOrder'))
                            <a href="{{ route('restock.index') }}" class="quick-action">
                                <i class="bi bi-cart-plus"></i>
                                <span>បញ្ជាទិញបន្ថែម</span>
                            </a>
                        @else
                            <div class="quick-action disabled text-muted" tabindex="-1">
                                <i class="bi bi-cart-plus"></i>
                                <span>បញ្ជាទិញបន្ថែម</span>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Analytics & Tasks -->
    <div class="row g-3 mt-0">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-1 d-flex align-items-center">
                    <i class="bi bi-graph-up text-success me-2"></i>
                    <span class="fw-semibold">ស្ថិតិស្តុក</span>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="analytics-block border-start border-primary border-3 ps-2">
                                <div class="fw-bold text-primary fs-5 mb-1">{{ $totalItems > 0 ? round((($totalItems - $lowStockItems->count()) / $totalItems) * 100) : 0 }}%</div>
                                <div class="text-muted small">ការបំពេញស្តុក</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="analytics-block border-start border-success border-3 ps-2">
                                <div class="fw-bold text-success fs-5 mb-1">{{ $totalSuppliers > 0 ? '92' : '0' }}%</div>
                                <div class="text-muted small">ភាពត្រឹមត្រូវស្តុក</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="analytics-block border-start border-info border-3 ps-2">
                                <div class="fw-bold text-info fs-5 mb-1">{{ $pendingOrders > 0 ? '7' : '0' }} ថ្ងៃ</div>
                                <div class="text-muted small">ពេលវេលាបញ្ជាទិញជាមធ្យម</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-1 d-flex align-items-center">
                    <i class="bi bi-calendar-check text-warning me-2"></i>
                    <span class="fw-semibold">ការងារថ្ងៃនេះ</span>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-3">
                            <div class="summary-icon bg-primary me-2" style="width:2rem;height:2rem"><i class="bi bi-check2-square"></i></div>
                            <div>
                                <div class="fw-semibold">ពិនិត្យស្តុកទំនិញ</div>
                                <div class="text-muted small">គ្រាន់តែបញ្ចប់</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="summary-icon bg-warning me-2" style="width:2rem;height:2rem"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="fw-semibold">អនុម័តការបញ្ជាទិញ</div>
                                <div class="text-muted small">{{ $pendingOrders > 0 ? 'កំពុងរង់ចាំ' : 'គ្មាន' }}</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="summary-icon bg-info me-2" style="width:2rem;height:2rem"><i class="bi bi-file-text"></i></div>
                            <div>
                                <div class="fw-semibold">រៀបចំរបាយការណ៍</div>
                                <div class="text-muted small">ត្រូវការបញ្ចប់</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body, .card-title, .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    font-family: 'Noto Sans Khmer', 'Khmer OS', 'Segoe UI', Arial, sans-serif;
}
.summary-card {
    transition: box-shadow .15s, transform .12s;
}
.summary-card:hover {
    box-shadow: 0 0.7rem 1.5rem rgba(0,0,0,.13)!important;
    transform: translateY(-2px) scale(1.035);
}
.summary-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    border-radius: .7rem;
    background: var(--bs-light);
}
.bg-primary { background-color: #0d6efd!important;color:#fff!important; }
.bg-success { background-color: #198754!important;color:#fff!important; }
.bg-warning { background-color: #ffc107!important;color:#fff!important; }
.bg-info { background-color: #0dcaf0!important;color:#fff!important; }
.bg-warning-subtle { background-color: #fff3cd!important; }
.bg-success-subtle { background-color: #d1e7dd!important; }
.bg-secondary-subtle { background-color: #f8f9fa!important; }
.bg-info-subtle { background-color: #cff4fc!important; }
.quick-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.4rem 0;
    border: 1px solid #e9ecef;
    border-radius: .8rem;
    transition: box-shadow .13s, background .13s;
    background: #fff;
    text-decoration: none;
    color: #212529;
    font-weight: 500;
    font-size: 1rem;
}
.quick-action i {
    font-size: 1.5rem;
    margin-bottom: .5rem;
}
.quick-action:hover, .quick-action:focus-visible {
    background: #f5f5f7;
    
    box-shadow: 0 0.4rem 1rem rgba(13,110,253,0.09);
    text-decoration: none;
    color: #0d6efd;
}
.quick-action.disabled {
    pointer-events: none;
    opacity: .55;
}
.analytics-block {
    min-height: 70px;
}
.bg-white { background: #fff; }
</style>
@endsection