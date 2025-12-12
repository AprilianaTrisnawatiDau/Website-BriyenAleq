const form = document.getElementById('formTransaksi');
let editId = null;

form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(form);
    let url = '/transaksi';
    let method = 'POST';

    if(editId) {
        url = `/transaksi/${editId}`;
        method = 'POST';
        formData.append('_method', 'PUT');
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    submitBtn.disabled = true;

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message || 'Success!');
            form.reset();
            editId = null;
            submitBtn.innerHTML = '<i class="fa fa-plus"></i> Tambah';
            loadTable();
        } else {
            throw new Error(result.message || 'Terjadi kesalahan');
        }

    } catch (error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

function editTransaksi(id) {
    fetch(`/transaksi/${id}`)
    .then(res => res.json())
    .then(data => {
        form.tanggal.value = data.tanggal;
        form.nama.value = data.nama;
        form.produk.value = data.produk;
        form.kategori.value = data.kategori;
        form.harga.value = data.harga;
        form.status.value = data.status;
        editId = id;

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Tambah';
    });
}

function deleteTransaksi(id) {
    if(!confirm('Hapus data ini?')) return;

    fetch(`/transaksi/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        loadTable();
    });
}

function loadTable() {
    fetch('/transaksi/list')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';

        data.forEach(t => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${t.tanggal}</td>
                <td>${t.nama}</td>
                <td>${t.produk}</td>
                <td>${t.kategori}</td>
                <td>Rp ${t.harga.toLocaleString()}</td>
                <td><span class="status ${t.status.toLowerCase()}">${t.status}</span></td>
                <td>${t.bukti ? `<img src="/storage/${t.bukti}" style="width: 50px; height: 50px; object-fit: cover;">` : '-'}</td>
                <td>
                    <button onclick="editTransaksi(${t.id})" class="btn-edit">Edit</button>
                    <button onclick="deleteTransaksi(${t.id})" class="btn-delete">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    });
}

loadTable();
