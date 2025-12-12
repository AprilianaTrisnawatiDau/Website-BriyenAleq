const form = document.getElementById('formTransaksi');
let editId = null;

form.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(form);

    let url = '/transaksi';
    let method = 'POST';

    if(editId) {
        formData.append('_method', 'PUT');
        url = `/transaksi/${editId}`;
        method = 'POST';
    }

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(editId ? 'Data berhasil diupdate' : 'Data berhasil ditambahkan');
        editId = null;
        form.reset();
        loadTable();
    })
    .catch(err => console.error(err));
});

function editTransaksi(id) {
    fetch(`/transaksi/${id}`)
    .then(res => res.json())
    .then(data => {
        form.nama.value = data.nama;
        form.produk.value = data.produk;
        form.tanggal.value = data.tanggal;
        form.kategori.value = data.kategori;
        form.harga.value = data.harga;
        form.status.value = data.status;

        editId = id;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(err => console.error(err));
}

function deleteTransaksi(id) {
    if(!confirm('Yakin ingin menghapus data?')) return;

    fetch(`/transaksi/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        loadTable();
    })
    .catch(err => console.error(err));
}

// reload table tanpa reload page
function loadTable() {
    fetch('/transaksi/list')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';
        if(data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="empty">Belum ada data</td></tr>';
            return;
        }
        data.forEach(t => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${t.tanggal}</td>
                <td>${t.nama}</td>
                <td>${t.produk}</td>
                <td>${t.kategori}</td>
                <td>Rp ${t.harga.toLocaleString('id-ID')}</td>
                <td><span class="status ${t.status.toLowerCase()}">${t.status}</span></td>
                <td>${t.bukti ? `<img src="/storage/${t.bukti}" class="bukti-img">` : '-'}</td>
                <td class="aksi">
                    <button onclick="editTransaksi(${t.id})" class="btn-edit"><i class="fas fa-edit"></i> Edit</button>
                    <button onclick="deleteTransaksi(${t.id})" class="btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    });
}

// load table saat page load
loadTable();
