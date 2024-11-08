<table style="border: 2px solid black;">
    <thead>
        <tr>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; width: 100px; text-align: center;background: #023e8a;">
                NPM</th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 260px;">
                NAMA
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 260px;">
                FOTO
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 260px;">
                EMAIL</th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 260px;">
                FOTO KTM
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 250px;">
                FOTO VERIFIKASI
            </th>
            <th
            style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 90px;">
            valid
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 180px;">
                TANGGAL VOTING
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 180px;">
                TANGGAL VERIFIKASI
            </th>
            <th
                style="color: white;font-size: 12px;font-weight: 800; border: 2px solid black; text-align: center;background: #023e8a;width: 150px;">
                DI VERIFIKASI OLEH
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ballots as $ballot)
            <tr>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->user->npm }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->user->name }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->user->picture }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->user->email }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->ktm_picture }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->verification_picture }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->accepted ? 'Ya' : 'Tidak' }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->created_at }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->accepted_at }}
                </td>
                <td style="color: black; border: 2px solid black;">
                    {{ $ballot->accepted_by }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="p-4 text-center">Tidak ada data hasil pemilihan</td>
            </tr>
        @endforelse
    </tbody>
</table>
