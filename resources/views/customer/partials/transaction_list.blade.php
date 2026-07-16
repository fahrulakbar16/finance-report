@if($list->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-journal-x" style="font-size: 3rem; color: rgba(0,0,0,0.05);"></i>
        <h4 class="mt-3" style="color: var(--text-muted); font-size: 1rem;">{{ $emptyMsg }}</h4>
    </div>
@else
    <div class="row g-3">
        @foreach($list as $booking)
            @php
                $isPending = $booking->payment_status === 'pending';
                $nights = \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out));
            @endphp
            <div class="col-12">
                <div style="border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; padding: 1.25rem; background: #fff;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted);">{{ $booking->invoice_number }}</span>
                        @if($isPending)
                            <span class="badge" style="background: rgba(234,179,8,0.1); color: #ca8a04;">Menunggu Pembayaran</span>
                        @elseif(\Carbon\Carbon::parse($booking->check_out)->startOfDay()->lt(\Carbon\Carbon::today()))
                            <span class="badge" style="background: rgba(34,197,94,0.1); color: #16a34a;">Selesai</span>
                        @else
                            <span class="badge" style="background: rgba(59,130,246,0.1); color: #2563eb;">Sedang Berjalan</span>
                        @endif
                    </div>
                    
                    <h3 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $booking->villa_snapshot['name'] ?? 'Villa' }}</h3>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">
                        {{ \Carbon\Carbon::parse($booking->check_in)->isoFormat('D MMM YYYY') }} - {{ \Carbon\Carbon::parse($booking->check_out)->isoFormat('D MMM YYYY') }} ({{ $nights }} Malam)
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <div style="font-size:0.75rem; color:var(--text-muted);">Total Bayar</div>
                            <div style="font-weight:700; color:var(--primary); font-size: 1.1rem;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>
                        
                        @if($isPending && $booking->payment_url)
                            <a href="{{ $booking->payment_url }}" class="btn btn-sm" style="background:var(--accent); color:var(--primary); font-weight:600; border-radius: 8px;">Bayar Sekarang</a>
                        @else
                            <a href="{{ route('villa.show', $booking->villa_id) }}" class="btn btn-sm btn-outline-dark" style="border-radius: 8px;">Lihat Villa</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
