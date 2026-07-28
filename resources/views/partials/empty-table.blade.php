<tr>
    <td colspan="{{ $colspan ?? 5 }}" class="text-center">
        <div class="empty-state">
            <i class="{{ $icon ?? 'bi bi-inbox' }} fs-2 d-block mb-2 text-secondary"></i>
            {{ $message ?? 'Belum ada data tersedia.' }}
        </div>
    </td>
</tr>
