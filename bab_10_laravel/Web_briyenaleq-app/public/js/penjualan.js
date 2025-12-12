document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("penjualanForm");
    const previewFoto = document.getElementById("previewFoto");

    document.getElementById("foto").addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewFoto.src = e.target.result;
                previewFoto.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewFoto.src = "";
            previewFoto.style.display = "none";
        }
    });

    form.addEventListener("submit", async e => {
        e.preventDefault();
        const formData = new FormData(form);
        const id = formData.get('id');
        const url = id ? `/Penjualan/${id}` : '/Penjualan/Store';
        if (id) formData.append('_method', 'PUT');

        const res = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value}
        });

        const data = await res.json();

        if (data.success) {
            const tbody = document.getElementById("data-penjualan");
            let fotoTag = data.foto_url ? `<img src="${data.foto_url}" width="50">` : '-';
            let newRow = `
                <tr id="row-${data.data.id}">
                    <td>${data.data.tanggal}</td>
                    <td>${data.data.nama}</td>
                    <td>${data.data.produk}</td>
                    <td>${data.data.alamat}</td>
                    <td>${data.data.kategori}</td>
                    <td>Rp ${Number(data.data.harga).toLocaleString('id-ID')}</td>
                    <td>${fotoTag}</td>
                    <td>
                        <button class="edit-btn" onclick="editData(${data.data.id})">Edit</button>
                        <button class="delete-btn" onclick="deleteData(${data.data.id})">Hapus</button>
                    </td>
                </tr>
            `;
            if (id) {
                document.getElementById(`row-${data.data.id}`).outerHTML = newRow;
            } else {
                tbody.insertAdjacentHTML('afterbegin', newRow);
            }
            form.reset();
            previewFoto.src = '';
            previewFoto.style.display = "none";
            document.getElementById("id").value = '';
        }
    });
});

function editData(id) {
    fetch(`/Penjualan/${id}/Edit`)
    .then(res => res.json())
    .then(data => {
        document.getElementById("id").value = data.id;
        document.querySelector('input[name="tanggal"]').value = data.tanggal;
        document.querySelector('input[name="nama"]').value = data.nama;
        document.querySelector('input[name="produk"]').value = data.produk;
        document.querySelector('input[name="alamat"]').value = data.alamat;
        document.querySelector('select[name="kategori"]').value = data.kategori;
        document.querySelector('input[name="harga"]').value = data.harga;
        if (data.foto) {
            const previewFoto = document.getElementById("previewFoto");
            previewFoto.src = `/storage/${data.foto}`;
            previewFoto.style.display = "block";
        } else {
            const previewFoto = document.getElementById("previewFoto");
            previewFoto.src = '';
            previewFoto.style.display = "none";
        }
    });
}

function deleteData(id) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        fetch(`/Penjualan/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-HTTP-Method-Override': 'DELETE'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`row-${id}`).remove();
            }
        });
    }
}
