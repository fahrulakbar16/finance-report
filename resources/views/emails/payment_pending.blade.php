<x-mail::message>
# Halo {{ $booking->guest_name }},

Terima kasih telah melakukan pemesanan di **Athara Villas**. 
Pemesanan Anda dengan nomor invoice **{{ $booking->invoice_number }}** telah kami terima dan saat ini sedang menunggu pembayaran.

<x-mail::panel>
**Detail Pesanan:**
- **Villa:** {{ $booking->villa_snapshot['name'] ?? 'Villa' }}
- **Check-in:** {{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y') }}
- **Check-out:** {{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y') }}
- **Total Pembayaran:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
</x-mail::panel>

Silakan klik tombol di bawah ini untuk menyelesaikan pembayaran Anda secara aman melalui DOKU.

<x-mail::button :url="$booking->payment_url" color="success">
Selesaikan Pembayaran
</x-mail::button>

Jika tombol di atas tidak berfungsi, Anda juga bisa menyalin dan menempelkan tautan berikut ke browser Anda:
[{{ $booking->payment_url }}]({{ $booking->payment_url }})

Harap selesaikan pembayaran agar kami dapat segera mengonfirmasi pesanan Anda.

Terima kasih,<br>
Tim {{ config('app.name') }}
</x-mail::message>
