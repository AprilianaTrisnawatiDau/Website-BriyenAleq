// 🔥 PERBAIKAN: Sesuaikan dengan ID di HTML
const form = document.getElementById("penjualanForm"); 
const tableBody = document.querySelector("#penjualanTable tbody"); // Sesuaikan dengan ID tabel
let transaksiList = [];
let editIndex = -1;
const STORAGE_KEY = 'penjualanData';

const MAX_DIMENSION = 200; // Ukuran maksimum sisi terpanjang
const COMPRESSION_QUALITY = 0.7; // Kualitas kompresi JPEG

// =========================================================
// ASYNCHRONOUS, PROMISE, & WEB STORAGE
// =========================================================
function fetchData() {
    return new Promise(resolve => {
        // Simulasi delay 300ms
        setTimeout(() => {
            const storedData = localStorage.getItem(STORAGE_KEY);
            resolve(storedData ? JSON.parse(storedData) : []);
        }, 300);
    });
}

function saveData(data) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

async function loadData() {
    try {
        transaksiList = await fetchData();
        console.log("Data dimuat:", transaksiList);
        renderTable();
    } catch (error) {
        console.error("Gagal memuat data:", error);
    }
}

// FUNGSI: Resize dan Konversi Gambar ke Base64
function resizeImage(file) {
    return new Promise(resolve => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                // Hitung dimensi baru, hanya jika melebihi batas (MAX_DIMENSION)
                if (width > MAX_DIMENSION || height > MAX_DIMENSION) {
                    if (width > height) {
                        height *= MAX_DIMENSION / width;
                        width = MAX_DIMENSION;
                    } else {
                        width *= MAX_DIMENSION / height;
                        height = MAX_DIMENSION;
                    }
                }
                
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Konversi ke Base64 (Data URL) dengan kompresi
                const resizedDataUrl = canvas.toDataURL('image/jpeg', COMPRESSION_QUALITY);
                resolve(resizedDataUrl);
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// EVENT LISTENER: Submit Form
form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const fotoFile = document.getElementById("foto").files[0];
    let fotoURL = "";
    
    // Tunggu proses resize jika ada file baru
    if (fotoFile) {
        fotoURL = await resizeImage(fotoFile); 
    } else if (editIndex !== -1 && transaksiList[editIndex] && transaksiList[editIndex].foto) {
        // Pertahankan URL foto lama saat edit
        fotoURL = transaksiList[editIndex].foto;
    }

    const data = {
        id: editIndex === -1 ? Date.now() : transaksiList[editIndex].id,
        tanggal: document.getElementById("tanggal").value,
        nama: document.getElementById("nama").value,
        produk: document.getElementById("produk").value,
        kategori: document.getElementById("kategori").value,
        harga: document.getElementById("harga").value,
        // Placeholder jika tidak ada foto
        foto: fotoURL || "https://via.placeholder.com/60?text=No+Image" 
    };

    // Logika Tambah/Edit
    if (editIndex === -1) {
        transaksiList.push(data);
    } else {
        transaksiList[editIndex] = data;
        editIndex = -1;
        form.querySelector("button").textContent = "Tambah";
    }

    saveData(transaksiList);
    form.reset();
    renderTable();
});

// FUNGSI: Render Tabel
function renderTable() {
    tableBody.innerHTML = "";
    transaksiList.forEach((t, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${t.tanggal}</td>
            <td>${t.nama}</td>
            <td>${t.produk}</td>
            <td>${t.kategori}</td>
            <td>${t.harga}</td>
            <td><img src="${t.foto}" alt="Foto Produk"></td>
            <td>
                <button class="detail-btn" onclick="detailData(${index})">Detail</button>
                <button class="edit-btn" onclick="editData(${index})">Edit</button>
                <button class="delete-btn" onclick="deleteData(${index})">Hapus</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// FUNGSI GLOBAL: Detail
window.detailData = function (index) {
    const t = transaksiList[index];
    alert(`Detail Transaksi:\nTanggal: ${t.tanggal}\nNama: ${t.nama}\nProduk: ${t.produk}\nKategori: ${t.kategori}\nHarga: ${t.harga}`);
};

// FUNGSI GLOBAL: Edit
window.editData = function (index) {
    const t = transaksiList[index];
    document.getElementById("tanggal").value = t.tanggal;
    document.getElementById("nama").value = t.nama;
    document.getElementById("produk").value = t.produk;
    document.getElementById("kategori").value = t.kategori;
    document.getElementById("harga").value = t.harga;
    editIndex = index;
    form.querySelector("button").textContent = "Update";
};

// FUNGSI GLOBAL: Hapus
window.deleteData = function (index) {
    if (confirm("Yakin ingin menghapus data ini?")) {
        transaksiList.splice(index, 1);
        saveData(transaksiList);
        renderTable();
    }
};

// Memuat data saat script dijalankan
loadData();