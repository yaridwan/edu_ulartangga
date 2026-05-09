<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Permainan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; color: #1e3a8a; margin: 0; }
        .subtitle { font-size: 14px; color: #475569; margin-top: 5px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px 0; }
        .info-label { font-weight: bold; width: 120px; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        table.data th { background-color: #f1f5f9; color: #1e293b; font-weight: bold; }
        table.data tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .bg-success { background-color: #dcfce7; color: #166534; }
        .bg-danger { background-color: #fee2e2; color: #991b1b; }
        .bg-warning { background-color: #fef9c3; color: #854d0e; }
        .footer { margin-top: 40px; text-align: right; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Laporan Hasil Permainan Ular Tangga Edukatif</h1>
        <p class="subtitle">{{ $permainan->mataPelajaran->nama }} - Kelas {{ $permainan->kelas->nama_kelas }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">ID Permainan</td>
            <td>: #{{ $permainan->id }}</td>
            <td class="info-label">Tanggal Selesai</td>
            <td>: {{ $permainan->selesai_pada ? $permainan->selesai_pada->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Mode</td>
            <td>: {{ ucfirst($permainan->mode) }}</td>
            <td class="info-label">Jumlah Pemain</td>
            <td>: {{ $permainan->pemain->count() }}</td>
        </tr>
    </table>

    <h3 style="margin-bottom: 10px;">Peringkat & Skor Pemain</h3>
    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Pemain</th>
                <th width="15%" class="text-center">Skor Akhir</th>
                <th width="15%" class="text-center">Posisi</th>
                <th width="20%" class="text-center">Jawaban (B/S)</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permainan->pemain as $index => $pemain)
            @php $stat = $statistikPemain[$pemain->id]; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $pemain->nama_pemain }}</td>
                <td class="text-center"><strong>{{ $pemain->skor }}</strong></td>
                <td class="text-center">{{ $pemain->posisi }}</td>
                <td class="text-center">{{ $stat['benar'] }} / {{ $stat['salah'] }}</td>
                <td class="text-center">
                    <span class="badge {{ $pemain->status === 'menang' ? 'bg-success' : 'bg-warning' }}">
                        {{ strtoupper($pemain->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-bottom: 10px; margin-top: 30px;">Detail Jawaban</h3>
    <table class="data">
        <thead>
            <tr>
                <th width="25%">Pemain</th>
                <th width="45%">Soal</th>
                <th width="15%" class="text-center">Jawaban</th>
                <th width="15%" class="text-center">Hasil</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permainan->jawaban as $jawaban)
            <tr>
                <td>{{ $jawaban->pemainPermainan->nama_pemain }}</td>
                <td>{{ \Illuminate\Support\Str::limit($jawaban->soal->pertanyaan, 80) }}</td>
                <td class="text-center">{{ $jawaban->jawaban }}</td>
                <td class="text-center">
                    @if($jawaban->is_benar)
                        <span style="color: #166534; font-weight: bold;">Benar (+{{ $jawaban->poin_diperoleh }})</span>
                    @else
                        <span style="color: #991b1b; font-weight: bold;">Salah ({{ $jawaban->poin_diperoleh }})</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data jawaban.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} oleh {{ auth()->user()->name }}
    </div>
</body>
</html>
