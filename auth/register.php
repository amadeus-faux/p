<?php
header('Content-Type: application/json; charset=utf-8');
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : 'null';
header("Access-Control-Allow-Origin: $origin");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once __DIR__ . '/config.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Helper to sanitize and validate string
function clean_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// get JSON body if sent
$inputRaw = file_get_contents('php://input');
$data = json_decode($inputRaw, true);
if (!$data) {
    // fallback to form-encoded
    $data = $_POST;
}

// 1. Basic Requirement Check
$required_fields = ['name', 'email', 'phone', 'role', 'username', 'password'];
$missing = [];
foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Harap lengkapi semua kolom wajib.', 'missing' => $missing]);
    exit;
}

// 2. T&C Validation
if (empty($data['terms']) || $data['terms'] !== true && $data['terms'] !== "on") {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Anda harus menyetujui Syarat & Ketentuan.']);
    exit;
}

// 3. Data Type & Length Validation
$name = clean_input($data['name']);
$email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$phone = trim($data['phone']);
$role = clean_input($data['role']);
$username = clean_input($data['username']);
$password = $data['password'];

// Optional
$sekolah = isset($data['sekolah']) ? clean_input($data['sekolah']) : null;
$anak = isset($data['anak']) ? clean_input($data['anak']) : null;
$nip = isset($data['nip']) ? clean_input($data['nip']) : null;
$idk = isset($data['idk']) ? clean_input($data['idk']) : null;

// Validate Email
if (!$email) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
    exit;
}

// Validate Phone (Digits only, 10-13 chars)
if (!preg_match('/^[0-9]{10,13}$/', $phone)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Nomor HP harus berupa angka 10-13 digit.']);
    exit;
}

// Validate Username (Min 3 chars, alphanumeric)
if (strlen($username) < 3 || strlen($username) > 50) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Username minimal 3 karakter, maksimal 50.']);
    exit;
}
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Username hanya boleh huruf, angka, dan underscore provided.']);
    exit;
}

// Validate Password (Min 6 chars)
if (strlen($password) < 6) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter.']);
    exit;
}

// 4. Role Validation
$allowed_roles = ['siswa', 'ortu', 'sekolah', 'mbg'];
if (!in_array($role, $allowed_roles)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Peran pengguna tidak valid.']);
    exit;
}

try {
    // 5. Unique Check (Username & Email)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode(['success' => false, 'message' => 'Username atau Email sudah terdaftar.']);
        exit;
    }

    // 6. Secure Hashing
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 7. Insert with Prepared Statement
    $sql = "INSERT INTO users (name, email, phone, role, sekolah, anak, nip, idk, username, password_hash)
            VALUES (:name, :email, :phone, :role, :sekolah, :anak, :nip, :idk, :username, :password_hash)";

    $insert = $pdo->prepare($sql);
    $insert->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'role' => $role,
        'sekolah' => $sekolah,
        'anak' => $anak,
        'nip' => $nip,
        'idk' => $idk,
        'username' => $username,
        'password_hash' => $password_hash
    ]);

    echo json_encode(['success' => true, 'message' => 'Registrasi berhasil. Silakan login.']);

} catch (PDOException $e) {
    // Log internal error here if needed
    http_response_code(500);
    // Generic message for security
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem saat mendaftar. Silakan coba lagi nanti.']);
}
