document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("penjualanForm");
    const tbody = document.getElementById("data-penjualan");
    const submitBtn = document.getElementById("submitBtn");

    let editId = null;

    function loadData() {
        fetch("php/fetch_penjualan.php")
            .then(res => res.text())
            .then(data => tbody.innerHTML = data);
    }
    loadData();

    form.addEventListener("submit", e => {
        e.preventDefault();

        const fd = new FormData();
        fd.append("tanggal", tanggal.value);
        fd.append("nama", nama.value);
        fd.append("produk", produk.value);
        fd.append("alamat", alamat.value);
        fd.append("kategori", kategori.value);
        fd.append("harga", harga.value);
        if (foto.files[0]) fd.append("foto", foto.files[0]);
        if (editId) fd.append("id", editId);

        fetch("php/penjualan_action.php", {
            method: "POST",
            body: fd
        }).then(() => {
            form.reset();
            editId = null;
            submitBtn.textContent = "Tambah Data";
            loadData();
        });
    });

    window.editData = function(id) {
        fetch("php/get_penjualan.php?id=" + id)
            .then(r => r.json())
            .then(data => {
                editId = data.id;
                tanggal.value = data.tanggal;
                nama.value = data.nama;
                produk.value = data.produk;
                alamat.value = data.alamat;
                kategori.value = data.kategori;
                harga.value = data.harga;

                submitBtn.textContent = "Update Data";
            });
    };

    window.confirmDelete = function(id) {
        if (confirm("Hapus data ini?")) {
            fetch("php/penjualan_action.php?delete=" + id)
                .then(() => loadData());
        }
    };

    window.showDetail = function(id) {
        fetch("php/get_penjualan.php?id=" + id)
            .then(r => r.json())
            .then(data => {
                alert(
`Tanggal : ${data.tanggal}
Nama    : ${data.nama}
Produk  : ${data.produk}
Alamat  : ${data.alamat}
Kategori: ${data.kategori}
Harga   : Rp ${Number(data.harga).toLocaleString()}`
                );
            });
    };

});
