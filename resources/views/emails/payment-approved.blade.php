@php
    $member = $payment->member;
    $downloadUrl = route('member.koran.index');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Langganan Disetujui</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background: #f4f6f9; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background: #d90429; padding: 25px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 22px; }
        .body { padding: 30px; }
        .body p { line-height: 1.6; }
        .btn { display: inline-block; background: #d90429; color: #fff !important; text-decoration: none; padding: 12px 24px; border-radius: 6px; margin-top: 20px; font-weight: bold; }
        .info { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .info table { width: 100%; font-size: 14px; }
        .info td { padding: 5px 0; }
        .footer { background: #1a1a2e; color: #aaa; text-align: center; padding: 15px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Disetujui 🎉</h1>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $member->name }}</strong>,</p>
            <p>Terima kasih! Pembayaran langganan Anda telah <strong>disetujui</strong>. Akun langganan Anda kini aktif.</p>

            <div class="info">
                <table>
                    <tr>
                        <td><strong>Paket</strong></td>
                        <td>{{ $payment->plan->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Aktif sejak</strong></td>
                        <td>{{ $member->subscription_start ? $member->subscription_start->format('d M Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Berakhir</strong></td>
                        <td>{{ $member->subscription_end ? $member->subscription_end->format('d M Y') : '-' }}</td>
                    </tr>
                </table>
            </div>

            <p>Anda kini dapat mengakses dan mendownload koran digital (PDF) melalui tautan di bawah ini:</p>

            <a href="{{ $downloadUrl }}" class="btn">Download Koran Digital</a>

            <p style="margin-top: 25px; color:#777;">Salam,<br><strong>MerahPutihPers</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MerahPutihPers. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>

