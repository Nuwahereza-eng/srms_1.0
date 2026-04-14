<?php
/**
 * Seed script: generates sample data for SRMS
 * Programmes, Subjects, Terms, CAs, Classes, Students, Subject Combinations, Exam Results
 */

require_once __DIR__ . '/models/database.php';
require_once __DIR__ . '/models/utility.php';

// Load .env
$utility = new utility;

$db = database::connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== SRMS Sample Data Seeder ===\n\n";

// ─── 1. Programmes ───
echo "[1/8] Creating programmes...\n";
$programmes = [
    ['name' => 'Sciences', 'subjects' => serialize([]), 'status' => 'ENABLED'],
    ['name' => 'Arts', 'subjects' => serialize([]), 'status' => 'ENABLED'],
];
foreach ($programmes as $p) {
    $db->prepare("INSERT INTO programmes (name, subjects, status) VALUES (?, ?, ?)")->execute([$p['name'], $p['subjects'], $p['status']]);
}
$prog_science = $db->lastInsertId() - 1;
$prog_arts = $db->lastInsertId();
// Re-fetch
$prog_rows = $db->query("SELECT id, name FROM programmes")->fetchAll(PDO::FETCH_ASSOC);
$prog_science = $prog_rows[0]['id'];
$prog_arts = $prog_rows[1]['id'];
echo "   Created: Sciences (ID=$prog_science), Arts (ID=$prog_arts)\n";

// ─── 2. Subjects ───
echo "[2/8] Creating subjects...\n";
$subject_list = [
    ['code' => 'MTH', 'name' => 'Mathematics', 'is_principal' => 'YES'],
    ['code' => 'ENG', 'name' => 'English Language', 'is_principal' => 'YES'],
    ['code' => 'PHY', 'name' => 'Physics', 'is_principal' => 'YES'],
    ['code' => 'CHM', 'name' => 'Chemistry', 'is_principal' => 'YES'],
    ['code' => 'BIO', 'name' => 'Biology', 'is_principal' => 'YES'],
    ['code' => 'GEO', 'name' => 'Geography', 'is_principal' => 'NO'],
    ['code' => 'HIS', 'name' => 'History', 'is_principal' => 'NO'],
    ['code' => 'CRE', 'name' => 'Christian Religious Education', 'is_principal' => 'NO'],
    ['code' => 'AGR', 'name' => 'Agriculture', 'is_principal' => 'NO'],
    ['code' => 'CSC', 'name' => 'Computer Studies', 'is_principal' => 'NO'],
];
foreach ($subject_list as $s) {
    $db->prepare("INSERT INTO subjects (code, name, is_principal, status) VALUES (?, ?, ?, 'ENABLED')")
       ->execute([$s['code'], $s['name'], $s['is_principal']]);
}
$subjects = $db->query("SELECT id, code, name FROM subjects ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$subject_ids = array_column($subjects, 'id');
echo "   Created " . count($subjects) . " subjects\n";

// Update programme subjects
$science_subs = serialize(array_slice($subject_ids, 0, 6)); // MTH,ENG,PHY,CHM,BIO,GEO
$arts_subs = serialize(array_merge([$subject_ids[0], $subject_ids[1]], array_slice($subject_ids, 5))); // MTH,ENG,GEO,HIS,CRE,AGR,CSC
$db->prepare("UPDATE programmes SET subjects = ? WHERE id = ?")->execute([$science_subs, $prog_science]);
$db->prepare("UPDATE programmes SET subjects = ? WHERE id = ?")->execute([$arts_subs, $prog_arts]);

// ─── 3. Academic Terms ───
echo "[3/8] Creating academic terms...\n";
$terms = [
    'Term I - 2024', 'Term II - 2024', 'Term III - 2024',
    'Term I - 2025', 'Term II - 2025', 'Term III - 2025',
];
foreach ($terms as $t) {
    $db->prepare("INSERT INTO academic_terms (name, ca, status, show_results) VALUES (?, '', 'ENABLED', 'YES')")->execute([$t]);
}
$term_rows = $db->query("SELECT id, name FROM academic_terms ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$term_ids = array_column($term_rows, 'id');
echo "   Created " . count($term_ids) . " terms\n";

// ─── 4. Continuous Assessments ───
echo "[4/8] Creating continuous assessments...\n";
$cas = [
    ['name' => 'Mid-Term Exam', 'weight' => 30],
    ['name' => 'End of Term Exam', 'weight' => 70],
];
foreach ($cas as $c) {
    $db->prepare("INSERT INTO continuous_assessments (name, weight, status) VALUES (?, ?, 'ENABLED')")->execute([$c['name'], $c['weight']]);
}
$ca_rows = $db->query("SELECT id, name FROM continuous_assessments ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$ca_ids = array_column($ca_rows, 'id');
echo "   Created " . count($ca_ids) . " assessments\n";

// Update terms with CA reference
$ca_serial = serialize($ca_ids);
foreach ($term_ids as $tid) {
    $db->prepare("UPDATE academic_terms SET ca = ? WHERE id = ?")->execute([$ca_serial, $tid]);
}

// ─── 5. Classes ───
echo "[5/8] Creating classes...\n";
$classes = [
    ['id' => 1, 'name' => 'Senior 1', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
    ['id' => 2, 'name' => 'Senior 2', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
    ['id' => 3, 'name' => 'Senior 3', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
    ['id' => 4, 'name' => 'Senior 4', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
    ['id' => 5, 'name' => 'Senior 5 Arts', 'programme' => $prog_arts, 'gs' => 1, 'ds' => 1],
    ['id' => 6, 'name' => 'Senior 6 Arts', 'programme' => $prog_arts, 'gs' => 1, 'ds' => 1],
    ['id' => 7, 'name' => 'Senior 5 Science', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
    ['id' => 8, 'name' => 'Senior 6 Science', 'programme' => $prog_science, 'gs' => 1, 'ds' => 1],
];
foreach ($classes as $cl) {
    $db->prepare("INSERT INTO classes (id, name, programme, grading_system, division_system, award_method, status) VALUES (?, ?, ?, ?, ?, 'DIVISION', 'ENABLED')")
       ->execute([$cl['id'], $cl['name'], $cl['programme'], $cl['gs'], $cl['ds']]);
}
$class_rows = $db->query("SELECT id, name, programme FROM classes ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
echo "   Created " . count($class_rows) . " classes\n";

// ─── 6. Subject Combinations (assign subjects to classes) ───
echo "[6/8] Assigning subjects to classes...\n";
$combo_count = 0;
foreach ($class_rows as $cl) {
    // Get programme subjects
    $stmt = $db->prepare("SELECT subjects FROM programmes WHERE id = ?");
    $stmt->execute([$cl['programme']]);
    $prog_subs = @unserialize($stmt->fetchColumn());
    if (!is_array($prog_subs)) $prog_subs = array_slice($subject_ids, 0, 6);

    foreach ($prog_subs as $sid) {
        $db->prepare("INSERT INTO subject_combinations (subject_id, class_id, teacher) VALUES (?, ?, NULL)")
           ->execute([$sid, $cl['id']]);
        $combo_count++;
    }
}
echo "   Created $combo_count subject-class combinations\n";

// ─── 7. Students ───
echo "[7/8] Creating students...\n";

$first_names_m = ['James','Peter','David','Samuel','Joseph','Brian','Ronald','Daniel','Emmanuel','Isaac',
                  'Patrick','Andrew','Kevin','Dennis','Richard','Michael','Stephen','Robert','William','John',
                  'Alex','Timothy','Henry','George','Francis','Martin','Paul','Simon','Gerald','Felix'];
$first_names_f = ['Sarah','Grace','Faith','Esther','Diana','Patience','Agnes','Mercy','Joy','Hope',
                  'Dorothy','Juliet','Christine','Naomi','Irene','Lydia','Ruth','Rebecca','Rachel','Maria',
                  'Anita','Betty','Carol','Deborah','Eva','Florence','Harriet','Janet','Lillian','Miriam'];
$last_names = ['Mugisha','Tumusiime','Asiimwe','Natukunda','Kabagambe','Byaruhanga','Nuwagaba','Kiiza',
               'Atuhaire','Ampaire','Mwesigye','Karungi','Babirye','Namubiru','Tusiime','Kobusingye',
               'Arinaitwe','Ninsiima','Mbabazi','Akankwasa','Kyomuhendo','Twinomujuni','Beesigye','Muhwezi',
               'Kamugisha','Ankunda','Niyonzima','Rutaremara','Ssemanda','Lubega'];

$hashed_pw = password_hash('Student@123', PASSWORD_DEFAULT);
$student_count = 0;
$all_students = [];

foreach ($class_rows as $cl) {
    $num_students = rand(15, 25); // 15-25 students per class
    for ($i = 0; $i < $num_students; $i++) {
        $gender = rand(0, 1) ? 'Male' : 'Female';
        $fname = $gender === 'Male' ? $first_names_m[array_rand($first_names_m)] : $first_names_f[array_rand($first_names_f)];
        $lname = $last_names[array_rand($last_names)];
        $reg_no = 'MSS/' . date('Y') . '/' . str_pad($student_count + 1, 4, '0', STR_PAD_LEFT);
        $email = strtolower($fname . '.' . $lname . ($student_count + 1)) . '@mwangavu.ac.ug';
        $reg_date = date('Y-m-d H:i:s', strtotime('-' . rand(30, 365) . ' days'));

        $db->prepare("INSERT INTO students (reg_no, first_name, last_name, gender, email, hashed_pw, reg_date, class, account_status, display_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'ENABLED', NULL)")
           ->execute([$reg_no, $fname, $lname, $gender, $email, $hashed_pw, $reg_date, $cl['id']]);
        
        $all_students[] = ['reg_no' => $reg_no, 'class_id' => $cl['id'], 'name' => "$fname $lname"];
        $student_count++;
    }
}
echo "   Created $student_count students across " . count($class_rows) . " classes\n";

// ─── 8. Examination Results (the key data for analytics/predictor) ───
echo "[8/8] Generating examination results...\n";

// Performance profiles to create realistic variation
function generate_score($base, $variance = 15) {
    $score = $base + rand(-$variance, $variance);
    return max(5, min(100, $score));
}

$result_count = 0;

foreach ($all_students as $student) {
    $reg_no = $student['reg_no'];
    $class_id = $student['class_id'];

    // Each student gets a "base ability" level
    $ability = rand(30, 90); // base ability 30-90

    // Get subjects for this class
    $stmt = $db->prepare("SELECT subject_id FROM subject_combinations WHERE class_id = ?");
    $stmt->execute([$class_id]);
    $class_subs = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Generate results for multiple terms (simulate term-over-term data)
    // Use 3-5 terms so predictor has enough data
    $num_terms = rand(3, min(5, count($term_ids)));
    $selected_terms = array_slice($term_ids, 0, $num_terms);

    // Create a trend: some students improve, some decline, some stable
    $trend_type = rand(1, 10);
    // 1-3: declining, 4-6: stable, 7-10: improving
    $trend_shift = 0;
    if ($trend_type <= 3) $trend_shift = rand(-5, -2); // declining per term
    elseif ($trend_type <= 6) $trend_shift = rand(-1, 1); // stable
    else $trend_shift = rand(2, 5); // improving

    foreach ($selected_terms as $t_idx => $term_id) {
        $current_base = $ability + ($trend_shift * $t_idx);
        $current_base = max(15, min(95, $current_base));

        foreach ($ca_ids as $ca_id) {
            // Build serialized results array
            $results = [];
            foreach ($class_subs as $sub_id) {
                // Each subject can have some variance from student base
                $sub_offset = rand(-10, 10); // subject affinity
                $score = generate_score($current_base + $sub_offset, 8);
                $results[$sub_id] = (string)$score;
            }

            $serialized = serialize($results);
            $db->prepare("INSERT INTO examination_results (reg_no, class_id, term, ca, results) VALUES (?, ?, ?, ?, ?)")
               ->execute([$reg_no, $class_id, $term_id, $ca_id, $serialized]);
            $result_count++;
        }
    }
}

echo "   Generated $result_count examination result records\n";

echo "\n=== Seeding Complete! ===\n";
echo "Summary:\n";
echo "  • Programmes: " . count($programmes) . "\n";
echo "  • Subjects: " . count($subjects) . "\n";
echo "  • Terms: " . count($term_ids) . "\n";
echo "  • Assessments: " . count($ca_ids) . "\n";
echo "  • Classes: " . count($class_rows) . "\n";
echo "  • Students: $student_count\n";
echo "  • Exam Results: $result_count\n";
echo "\nYou can now log in and visit Analytics Dashboard & AI Predictor!\n";
