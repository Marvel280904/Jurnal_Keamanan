<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Journal Security Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 11px; }
        .section-title { font-size: 14px; color: #2563eb; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { padding: 8px; border: 1px solid #cbd5e1; text-align: left; }
        table th { background-color: #f8fafc; color: #475569; width: 30%; font-weight: bold; }
        .content-box { border: 1px solid #e2e8f0; background-color: #f8fafc; padding: 10px; margin-bottom: 15px; min-height: 50px; border-radius: 4px; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .signature-table { width: 100%; border: none; margin-top: 40px; }
        .signature-table td { border: none; text-align: center; width: 33%; }
        .signature-line { margin-top: 50px; border-top: 1px solid #cbd5e1; display: inline-block; width: 150px; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Jurnal Keamanan Operasional</h1>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y H:i') }} | Status: <strong>{{ strtoupper($journal->status) }}</strong></p>
    </div>

    <div class="section-title">Informasi Dasar</div>
    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($journal->tanggal)->format('l, d F Y') }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $journal->location->nama_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Shift</th>
            <td>{{ $journal->shift->nama_shift ?? '-' }} ({{ \Carbon\Carbon::parse($journal->shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($journal->shift->end_time)->format('H:i') }})</td>
        </tr>
    </table>

    <div class="section-title">Informasi Personil</div>
    <table>
        <tr>
            <th>Disubmit Oleh</th>
            <td>{{ $journal->user->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Grup Saat Ini</th>
            <td>{{ $journal->group->nama_grup ?? '-' }} <br> <span style="font-size:10px; color:#64748b;">(Anggota: {{ $currentGroupMembers }})</span></td>
        </tr>
        <tr>
            <th>Grup Next Shift</th>
            <td>{{ $journal->nextShift->nama_grup ?? '-' }} <br> <span style="font-size:10px; color:#64748b;">(Anggota: {{ $nextShiftMembers }})</span></td>
        </tr>
    </table>

    <div class="section-title">Detail Laporan</div>
    
    <strong>Laporan Kegiatan</strong>
    <div class="content-box">
        {!! nl2br(e($journal->laporan_kegiatan)) !!}
    </div>

    <strong>Kejadian / Temuan Khusus</strong>
    <div class="content-box">
        {!! nl2br(e($journal->kejadian_temuan)) !!}
    </div>

    <strong>Informasi Lembur</strong>
    <div class="content-box">
        {{ $journal->lembur }}
    </div>

    <strong>Proyek / Vendor Masuk</strong>
    <div class="content-box">
        {!! nl2br(e($journal->proyek_vendor)) !!}
    </div>

    <strong>Status Barang Inventaris</strong>
    <div class="content-box">
        {!! nl2br(e($journal->barang_inven)) !!}
    </div>

    @if($journal->info_tambahan)
    <strong>Informasi Tambahan</strong>
    <div class="content-box">
        {!! nl2br(e($journal->info_tambahan)) !!}
    </div>
    @endif

    <div class="section-title">Riwayat Persetujuan</div>
    <table>
        <tr>
            <th>Diperbarui Oleh</th>
            <td>{{ $journal->updater?->nama ?? 'Tidak Ada' }}</td>
        </tr>
        <tr>
            <th>Diserahterimakan Oleh</th>
            <td>{{ $journal->handover?->nama ?? 'Tidak Ada' }}</td>
        </tr>
        <tr>
            <th>Disetujui Oleh (PGA)</th>
            <td>{{ $journal->approver?->nama ?? 'Tidak Ada' }}</td>
        </tr>
    </table>

    <!-- <table class="signature-table">
        <tr>
            <td>
                Pembuat Laporan,<br>
                <span class="signature-line">{{ $journal->user?->nama ?? '-' }}</span>
            </td>
            <td>
                Penerima Serah Terima,<br>
                <span class="signature-line">{{ $journal->handover?->nama ?? '-' }}</span>
            </td>
            <td>
                Mengetahui PGA,<br>
                <span class="signature-line">{{ $journal->approver?->nama ?? '-' }}</span>
            </td>
        </tr>
    </table> -->

</body>
</html>
