<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: auth.html');
    exit;
}

$user = [
    'id' => $_SESSION['user_id'],
    'username' => $_SESSION['username'],
    'role' => $_SESSION['role'],
    'name' => $_SESSION['name']
];

// Jika role adalah mbg, ambil data pengaduan dari database
$pengaduanList = [];
$isMBG = ($user['role'] === 'mbg');

if ($isMBG) {
    require_once __DIR__ . '/auth/config.php';

    try {
        $stmt = $pdo->query("
            SELECT 
                p.id,
                p.nama_lengkap,
                p.nama_sekolah,
                p.tanggal_kejadian,
                p.jenis_pengaduan,
                p.deskripsi,
                p.bukti_path,
                p.status,
                p.created_at
            FROM pengaduan p
            ORDER BY p.created_at DESC
        ");
        $pengaduanList = $stmt->fetchAll();
    } catch (Exception $e) {
        $pengaduanList = [];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isMBG ? 'Hasil Pengaduan - FoodEdu' : 'Form Pengaduan - FoodEdu'; ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    
    <style>
        /* Backdrop Modal */
        .evidence-modal-backdrop {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: none; /* Hidden by default */
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Saat modal aktif */
        .evidence-modal-backdrop.active {
            display: flex;
            opacity: 1;
        }

        /* Konten Modal */
        .evidence-modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            max-width: 800px; /* Lebar maksimal lebih besar */
            width: 90%;
            max-height: 90vh; /* Agar tidak melebihi tinggi layar */
            overflow-y: auto; /* Scroll jika gambar terlalu panjang */
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Gambar di dalam Modal */
        .evidence-image {
            display: block;
            margin: 10px auto;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Tombol Close (X) */
        .evidence-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.1);
            color: #333;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .evidence-close-btn:hover {
            background: #ff4757;
            color: white;
            transform: rotate(90deg);
        }

        /* Tombol Download */
        .btn-download-evidence {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 24px;
            background: #27AE60;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-download-evidence:hover {
            background: #219150;
        }
    </style>
</head>
<body>
    <header class="navbar-container">
        <div class="navbar-inner">
            <a href="indexsiswaorangtua.html" class="logo">
                <img src="asset/logo/foodedu.png" alt="FoodEdu Logo">
            </a>

            <nav class="nav-menu">
                <a href="indexsiswaorangtua.html" class="nav-item">Beranda</a>
                    <div class="dropdown">
                        <a class="nav-item dropdown-toggle">
                            Program <span class="arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="gizi.html#informasi-gizi">Informasi Gizi Seimbang</a>
                            <a href="gizi.html#kelayakan">Edukasi Kelayakan Makanan</a>
                        </div>
                    </div>
                <a href="pengaduan.php" class="nav-item pengaduan-link active">Pengaduan</a>
                <a href="saran.php" class="nav-item saran-link"><?php echo $isMBG ? 'Data Saran' : 'Saran'; ?></a>

                <div class="nav-buttons">
                    <div class="user-profile">
                        <span class="username"><?php echo htmlspecialchars($user['name']); ?></span>
                        <button class="btn-logout" id="logoutBtn">Keluar</button>
                    </div>
                </div>
            </nav>

            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <main class="pengaduan-container">
        <div class="pengaduan-card">
            <div class="pengaduan-header">
                <?php if ($isMBG): ?>
                    <h1 class="pengaduan-title">Hasil Pengaduan Pengguna</h1>
                    <p class="pengaduan-subtitle">
                        Rekap laporan pengaduan dari siswa, orang tua, dan pihak sekolah terkait program makan bergizi.
                    </p>
                <?php else: ?>
                    <h1 class="pengaduan-title">Form Pengaduan</h1>
                    <p class="pengaduan-subtitle">Sampaikan keluhan atau masukan Anda terkait program makan bergizi</p>
                <?php endif; ?>
            </div>

            <?php if ($isMBG): ?>
                <section class="admin-review-wrapper">
                    <div class="admin-review-summary">
                        <div class="admin-summary-item">
                            <span class="label">Total Pengaduan</span>
                            <span class="value"><?php echo count($pengaduanList); ?></span>
                        </div>
                    </div>

                    <?php if (empty($pengaduanList)): ?>
                        <div class="admin-empty-state">
                            <h2>Tidak ada pengaduan</h2>
                            <p>Belum ada laporan yang masuk dari pengguna. Pantau kembali secara berkala.</p>
                        </div>
                    <?php else: ?>
                        <div class="admin-review-list">
                            <?php foreach ($pengaduanList as $item): ?>
                                <article class="admin-review-card reveal">
                                    <header class="admin-review-header">
                                        <div>
                                            <h3><?php echo htmlspecialchars($item['jenis_pengaduan']); ?></h3>
                                            <p class="admin-review-meta">
                                                <span><?php echo htmlspecialchars($item['nama_lengkap']); ?></span>
                                                <span>•</span>
                                                <span><?php echo htmlspecialchars($item['nama_sekolah']); ?></span>
                                            </p>
                                        </div>
                                        <div class="admin-review-status status-<?php echo htmlspecialchars($item['status']); ?>">
                                            <?php echo ucfirst(htmlspecialchars($item['status'])); ?>
                                        </div>
                                    </header>

                                    <div class="admin-review-body">
                                        <p class="admin-review-date">
                                            Tanggal kejadian: 
                                            <strong>
                                                <?php 
                                                    $tgl = $item['tanggal_kejadian'];
                                                    echo $tgl ? date('d M Y', strtotime($tgl)) : '-';
                                                ?>
                                            </strong>
                                        </p>
                                        <p class="admin-review-text">
                                            <?php echo nl2br(htmlspecialchars($item['deskripsi'])); ?>
                                        </p>

                                        <?php if (!empty($item['bukti_path'])): ?>
                                            <button type="button" 
                                            onclick="lihatBukti('<?php echo htmlspecialchars($item['bukti_path']); ?>')" 
                                            class="admin-review-attachment"
                                            style="background:none; border:none; color:var(--primary); cursor:pointer; padding:0; font:inherit; text-decoration:underline;">
                                            📄 Lihat bukti pendukung 
                                        </button>
                                        <?php endif; ?>
                                    </div>

                                    <footer class="admin-review-footer">
                                        <span class="admin-review-created">
                                            Dikirim pada: 
                                            <?php 
                                                $created = $item['created_at'];
                                                echo $created ? date('d M Y H:i', strtotime($created)) : '-';
                                            ?>
                                        </span>
                                    </footer>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php else: ?>
                <form id="formPengaduan" class="pengaduan-form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">
                            Nama Lengkap <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_lengkap" 
                            name="nama_lengkap" 
                            class="form-input"
                            value="<?php echo htmlspecialchars($user['name']); ?>"
                            required
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label for="nama_sekolah" class="form-label">
                            Nama Sekolah <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_sekolah" 
                            name="nama_sekolah" 
                            class="form-input"
                            placeholder="Masukkan nama sekolah"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kejadian" class="form-label">
                            Tanggal Kejadian <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <input 
                                type="date" 
                                id="tanggal_kejadian" 
                                name="tanggal_kejadian" 
                                class="form-input"
                                required
                            >
                            <span class="input-icon">📅</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis_pengaduan" class="form-label">
                            Jenis Pengaduan <span class="required">*</span>
                        </label>
                        <select 
                            id="jenis_pengaduan" 
                            name="jenis_pengaduan" 
                            class="form-select"
                            required
                        >
                            <option value="">Pilih Jenis Pengaduan</option>
                            <option value="Kualitas Makanan">Kualitas Makanan</option>
                            <option value="Kebersihan Makanan">Kebersihan Makanan</option>
                            <option value="Kuantitas Makanan">Kuantitas Makanan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Pengaduan <span class="required">*</span>
                        </label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            class="form-textarea"
                            rows="5"
                            placeholder="Jelaskan secara detail keluhan atau masukan Anda..."
                            required
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="bukti" class="form-label">
                            Upload Bukti Pendukung
                        </label>
                        <div class="file-upload-wrapper">
                            <input 
                                type="file" 
                                id="bukti" 
                                name="bukti" 
                                class="file-input"
                                accept="image/*,.pdf"
                            >
                            <label for="bukti" class="file-label">
                                <span class="file-icon">📎</span>
                                <span class="file-text">Pilih File</span>
                                <span class="file-name" id="fileName">Tidak ada file dipilih</span>
                            </label>
                        </div>
                        <small class="form-hint">Format: JPG, PNG, atau PDF (Maks. 5MB)</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btnSubmit">
                            <span class="btn-text">Kirim Pengaduan</span>
                            <span class="btn-loader" style="display: none;">⏳</span>
                        </button>
                    </div>

                    <div id="formMessage" class="form-message" style="display: none;"></div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-left">
            <h3>FOODEDU</h3>
            <p>
                FoodEdu adalah platform berbasis web yang dirancang sebagai media edukasi 
                dan pengumpulan laporan terkait program makan bergizi di sekolah.
            </p>
        </div>
        <div class="footer-right">
            <p><strong>Contact</strong></p>
            <p>📧 support@foodedu.id</p>
            <p>📷 @foodedu</p>
            <p>📍 Indonesia</p>
        </div>
    </footer>

    <div id="modalBukti" class="evidence-modal-backdrop">
        <div class="evidence-modal-content">
            <button onclick="tutupModalBukti()" class="evidence-close-btn">&times;</button>
            <h3 style="margin-bottom: 15px; color: #333;">Bukti Pendukung</h3>
            
            <img id="imgTampilanBukti" src="" alt="Bukti Pengaduan" class="evidence-image">
            
            <div id="pdfContainer" style="display:none; height: 500px; margin-top:10px;">
                <iframe id="pdfFrame" src="" width="100%" height="100%" style="border:none;"></iframe>
            </div>

            <a id="linkDownloadBukti" href="#" download class="btn-download-evidence">
                ⬇️ Unduh File
            </a>
        </div>
    </div>

    <script src="main.js"></script>

    <script>
    // Debugging: Cek apakah fungsi ini jalan
    console.log("Sistem Modal Siap");

    function lihatBukti(urlPath) {
        console.log("Tombol diklik, URL:", urlPath); // Cek di Console browser
        
        const modal = document.getElementById('modalBukti');
        const img = document.getElementById('imgTampilanBukti');
        const pdfContainer = document.getElementById('pdfContainer');
        const pdfFrame = document.getElementById('pdfFrame');
        const link = document.getElementById('linkDownloadBukti');

        if (!modal) {
            alert("Error: Modal tidak ditemukan di HTML");
            return;
        }

        // Reset tampilan
        img.style.display = 'none';
        pdfContainer.style.display = 'none';

        // Deteksi tipe file
        const extension = urlPath.split('.').pop().toLowerCase();
        
        if (extension === 'pdf') {
            pdfFrame.src = urlPath;
            pdfContainer.style.display = 'block';
        } else {
            img.src = urlPath;
            img.style.display = 'block';
        }

        // Set link download
        link.href = urlPath;

        // Tampilkan modal
        modal.classList.add('active');
    }

    function tutupModalBukti() {
        const modal = document.getElementById('modalBukti');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                // Bersihkan src
                if(document.getElementById('imgTampilanBukti')) document.getElementById('imgTampilanBukti').src = '';
                if(document.getElementById('pdfFrame')) document.getElementById('pdfFrame').src = '';
            }, 300);
        }
    }

    // Event listener tutup modal saat klik luar
    const modalBuktiEl = document.getElementById('modalBukti');
    if (modalBuktiEl) {
        modalBuktiEl.addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModalBukti();
            }
        });
    }
</script>

    <?php if (!$isMBG): ?>
        <script>
            // Setup logout button
            document.addEventListener('DOMContentLoaded', function() {
                const logoutBtn = document.getElementById('logoutBtn');
                if (logoutBtn) {
                    logoutBtn.addEventListener('click', function() {
                        fetch('auth/logout.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            window.location.href = 'index.html';
                        })
                        .catch(error => {
                            console.error('Logout error:', error);
                            window.location.href = 'index.html';
                        });
                    });
                }
            });
        </script>
        <script>
            // File input handler
            const fileInput = document.getElementById('bukti');
            const fileName = document.getElementById('fileName');
            
            if (fileInput && fileName) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        fileName.textContent = e.target.files[0].name;
                        fileName.style.color = 'var(--green)';
                    } else {
                        fileName.textContent = 'Tidak ada file dipilih';
                        fileName.style.color = '#999';
                    }
                });
            }

            // Form submission
            const pengaduanForm = document.getElementById('formPengaduan');
            if (pengaduanForm) {
                pengaduanForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const btnSubmit = document.getElementById('btnSubmit');
                    const btnText = btnSubmit.querySelector('.btn-text');
                    const btnLoader = btnSubmit.querySelector('.btn-loader');
                    const formMessage = document.getElementById('formMessage');
                    
                    // Disable button and show loader
                    btnSubmit.disabled = true;
                    btnText.style.display = 'none';
                    btnLoader.style.display = 'inline-block';
                    formMessage.style.display = 'none';
                    
                    // Create FormData
                    const formData = new FormData(this);
                    
                    try {
                        const response = await fetch('pengaduan/submit.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            formMessage.className = 'form-message success';
                            formMessage.textContent = result.message || 'Pengaduan berhasil dikirim!';
                            formMessage.style.display = 'block';
                            
                            // Reset form
                            this.reset();
                            if (fileName) {
                                fileName.textContent = 'Tidak ada file dipilih';
                                fileName.style.color = '#999';
                            }
                            
                            // Scroll to message
                            formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        } else {
                            formMessage.className = 'form-message error';
                            formMessage.textContent = result.message || 'Terjadi kesalahan. Silakan coba lagi.';
                            formMessage.style.display = 'block';
                        }
                    } catch (error) {
                        formMessage.className = 'form-message error';
                        formMessage.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                        formMessage.style.display = 'block';
                    } finally {
                        // Enable button
                        btnSubmit.disabled = false;
                        btnText.style.display = 'inline-block';
                        btnLoader.style.display = 'none';
                    }
                });
            }

            // Logout function (Duplicate function handling just in case)
            // ... (Kode logout sudah ada di atas, tidak perlu double declare di block ini jika struktur PHP aman)
        </script>
    <?php endif; ?>
</body>
</html>