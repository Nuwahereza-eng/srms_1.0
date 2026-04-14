<?php
/**
 * Global Search Endpoint
 * Returns JSON results for students, classes, subjects matching the query.
 * Called via AJAX from the header search bar.
 *
 * Self-contained: does NOT load autoload.php / WAF / session_validator
 * to keep the endpoint fast and avoid WAF false-positives on search terms.
 */

// Always return JSON
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

// Start session to check auth
session_start();

// Quick auth check – no need for full session_validator
if (empty($_SESSION['logged_account'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Determine role from session
$logged = $_SESSION['logged_account'];
$role   = $logged['role'] ?? '';

// Database connection — load .env first for DB credentials
chdir('../');
$envFile = file_get_contents(".env");
if ($envFile !== false) {
    foreach (explode("\n", $envFile) as $line) {
        if (preg_match("/([^#]+)\=(.*)/", $line, $m) && isset($m[1]) && isset($m[2])) {
            $_ENV[trim($m[1])] = trim($m[2]);
        }
    }
}
require_once 'models/database.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if (strlen($q) < 2) {
    echo json_encode(['results' => []]);
    exit();
}

$db = database::connect();
$like = '%' . $q . '%';
$results = [];

// ─── Students ───
$stmt = $db->prepare(
    "SELECT s.reg_no, s.first_name, s.last_name, s.gender, c.name as class_name
     FROM students s
     LEFT JOIN classes c ON s.class = c.id
     WHERE s.first_name LIKE ? OR s.last_name LIKE ? OR s.reg_no LIKE ?
     OR CONCAT(s.first_name, ' ', s.last_name) LIKE ?
     ORDER BY s.first_name, s.last_name
     LIMIT 6"
);
$stmt->execute([$like, $like, $like, $like]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($students as $s) {
    $results[] = [
        'type'  => 'student',
        'icon'  => $s['gender'] === 'Male' ? 'fa-user' : 'fa-user',
        'title' => $s['first_name'] . ' ' . $s['last_name'],
        'sub'   => $s['reg_no'] . ($s['class_name'] ? ' · ' . $s['class_name'] : ''),
        'url'   => '/app/view_student?reg=' . urlencode($s['reg_no']),
    ];
}

// ─── Classes ───
$stmt = $db->prepare(
    "SELECT c.id, c.name, p.name as programme
     FROM classes c
     LEFT JOIN programmes p ON c.programme = p.id
     WHERE c.name LIKE ?
     ORDER BY c.name
     LIMIT 4"
);
$stmt->execute([$like]);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($classes as $c) {
    $results[] = [
        'type'  => 'class',
        'icon'  => 'fa-chalkboard',
        'title' => $c['name'],
        'sub'   => $c['programme'] ?? 'Class',
        'url'   => '/app/manage_results?class_id=' . $c['id'],
    ];
}

// ─── Subjects ───
$stmt = $db->prepare(
    "SELECT id, name FROM subjects WHERE name LIKE ? ORDER BY name LIMIT 4"
);
$stmt->execute([$like]);
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($subjects as $s) {
    $results[] = [
        'type'  => 'subject',
        'icon'  => 'fa-book',
        'title' => $s['name'],
        'sub'   => 'Subject',
        'url'   => '/app/subjects',
    ];
}

// ─── Teachers (staff only) ───
if ($role === 'ADMIN') {
    $stmt = $db->prepare(
        "SELECT id, first_name, last_name, email FROM staff
         WHERE (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?
         OR CONCAT(first_name, ' ', last_name) LIKE ?)
         AND role != 'ADMIN'
         ORDER BY first_name, last_name
         LIMIT 4"
    );
    $stmt->execute([$like, $like, $like, $like]);
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($teachers as $t) {
        $results[] = [
            'type'  => 'teacher',
            'icon'  => 'fa-user-tie',
            'title' => $t['first_name'] . ' ' . $t['last_name'],
            'sub'   => $t['email'],
            'url'   => '/app/teachers',
        ];
    }
}

echo json_encode(['results' => $results]);
