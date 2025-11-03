

const form = document.getElementById("transaksiForm");
const tableBody = document.querySelector("#transaksiTable tbody");
let transaksiList = [];
let editIndex = -1;
const STORAGE_KEY = 'transaksiPembeliData';

function fetchData() {
    return new Promise(resolve => {
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
        renderTable();
    } catch (error) {
        console.error("Gagal memuat data:", error);
    }
}


form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const buktiFile = document.getElementById("bukti").files[0];
    let buktiURL = "";

    if (buktiFile) {
        buktiURL = URL.createObjectURL(buktiFile);
    } else if (editIndex !== -1 && transaksiList[editIndex] && transaksiList[editIndex].bukti) {
        buktiURL = transaksiList[editIndex].bukti;
    }

    const data = {
        id: editIndex === -1 ? Date.now() : transaksiList[editIndex].id,
        tanggal: document.getElementById("tanggal").value,
        nama: document.getElementById("nama").value,
        produk: document.getElementById("produk").value,
        kategori: document.getElementById("kategori").value,
        harga: document.getElementById("harga").value,
        status: document.getElementById("status").value,
        bukti: buktiURL
    };

    if (editIndex === -1) {
        transaksiList.push(data);
    } else {
        transaksiList[editIndex] = data;
        editIndex = -1;
        form.querySelector("button").textContent = "Update";
    }
    
    saveData(transaksiList);
    form.reset();
    renderTable();
});

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
            <td><span class="status ${t.status.toLowerCase()}">${t.status}</span></td>
            <td>
                ${t.bukti ? `<img src="${t.bukti}" alt="Bukti" width="60" height="60" style="object-fit:cover;border-radius:6px;">` : '-'}
            </td>
            <td>
                <button class="detail-btn" onclick="detailData(${index})">Detail</button>
                <button class="edit-btn" onclick="editData(${index})">Edit</button>
                <button class="delete-btn" onclick="deleteData(${index})">Hapus</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

window.detailData = function (index) {
    const t = transaksiList[index];
    alert(
        `Detail Transaksi:\nTanggal: ${t.tanggal}\nNama: ${t.nama}\nProduk: ${t.produk}\nKategori: ${t.kategori}\nHarga: ${t.harga}\nStatus: ${t.status}`
    );
};

window.editData = function (index) {
    const t = transaksiList[index];
    document.getElementById("tanggal").value = t.tanggal;
    document.getElementById("nama").value = t.nama;
    document.getElementById("produk").value = t.produk;
    document.getElementById("kategori").value = t.kategori;
    document.getElementById("harga").value = t.harga;
    document.getElementById("status").value = t.status;
    editIndex = index;
    form.querySelector("button").textContent = "Update";
};

window.deleteData = function (index) {
    if (confirm("Yakin ingin menghapus data ini?")) {
        transaksiList.splice(index, 1);
        saveData(transaksiList);
        renderTable();
    }
};

// Panggil fungsi asinkron saat start
loadData();