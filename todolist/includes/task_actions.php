<?php
require_once 'config.php';

// Fungsi untuk mengambil semua task
function getTasks($user_id, $search = '', $filter_category = '', $filter_status = '') {
    global $koneksi;

    $query = "SELECT t.*, c.name AS category_name 
              FROM tasks t 
              LEFT JOIN categories c ON t.category_id = c.id 
              WHERE t.user_id = ?";

    $params = array($user_id);
    $types = "i";

    // Tambahkan filter pencarian
    if (!empty($search)) {
        $query .= " AND t.task_text LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    // Tambahkan filter kategori
    if (!empty($filter_category)) {
        $query .= " AND t.category_id = ?";
        $params[] = $filter_category;
        $types .= "i";
    }

    // Tambahkan filter status
    if (!empty($filter_status)) {
        if ($filter_status === 'completed') {
            $query .= " AND t.is_completed = 1";
        } elseif ($filter_status === 'active') {
            $query .= " AND t.is_completed = 0";
        }
    }

    $query .= " ORDER BY t.created_at DESC";

    $stmt = $koneksi->prepare($query);
    
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mengambil kategori
function getCategories($user_id) {
    global $koneksi;
    
    $stmt = $koneksi->prepare("SELECT * FROM categories WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Handle Task Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Tambah Task
    if (isset($_POST['add_task'])) {
        $task_text = sanitize($_POST['task_text']);
        $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;

        $stmt = $koneksi->prepare("INSERT INTO tasks (task_text, category_id, deadline, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $task_text, $category_id, $deadline, $user_id);
        $stmt->execute();
    }

    // Hapus Task
    if (isset($_POST['delete_task'])) {
        $task_id = (int)$_POST['task_id'];
        
        $stmt = $koneksi->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
    }

    // Toggle Status
    if (isset($_POST['toggle_status'])) {
        $task_id = (int)$_POST['task_id'];
        
        $stmt = $koneksi->prepare("UPDATE tasks SET is_completed = NOT is_completed WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
    }
}