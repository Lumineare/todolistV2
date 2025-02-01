<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/header.php';

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

// Handle Actions
require_once 'includes/task_actions.php';

// Ambil Data
$search = $_GET['search'] ?? '';
$filter_category = $_GET['category'] ?? '';
$filter_status = $_GET['status'] ?? '';

$tasks = getTasks($_SESSION['user_id'], $search, $filter_category, $filter_status);
$categories = getCategories($_SESSION['user_id']);
?>

<!-- Mobile-Friendly UI -->
<div class="container-fluid mt-3" style="max-width: 768px;">
    <!-- Search & Filter -->
    <form class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari task..." value="<?= $search ?>">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $filter_category == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="active" <?= $filter_status == 'active' ? 'selected' : '' ?>>Aktif</option>
                <option value="completed" <?= $filter_status == 'completed' ? 'selected' : '' ?>>Selesai</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Add Task Form -->
    <form method="POST" class="mb-4 card shadow">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-12">
                    <input type="text" name="task_text" class="form-control" 
                           placeholder="Task baru..." required maxlength="255">
                </div>
                <div class="col-12 col-md-6">
                    <select name="category_id" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input type="date" name="deadline" class="form-control" 
                           min="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-12">
                    <button type="submit" name="add_task" class="btn btn-primary w-100">
                        Tambah Task
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Task List -->
    <div class="card shadow">
        <div class="card-body">
            <?php if (empty($tasks)): ?>
                <p class="text-muted text-center">Tidak ada task</p>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($tasks as $task): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Toggle Status -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                        <button type="submit" name="toggle_status" 
                                                class="btn btn-sm <?= $task['is_completed'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                            <?= $task['is_completed'] ? '✓' : '◻' ?>
                                        </button>
                                    </form>
                                    
                                    <!-- Task Text -->
                                    <div>
                                        <span class="<?= $task['is_completed'] ? 'text-decoration-line-through' : '' ?>">
                                            <?= htmlspecialchars($task['task_text']) ?>
                                        </span>
                                        <div class="text-muted small">
                                            <?php if ($task['category_name']): ?>
                                                <span class="badge bg-info"><?= $task['category_name'] ?></span>
                                            <?php endif; ?>
                                            <?php if ($task['deadline']): ?>
                                                <span class="ms-2">
                                                    📅 <?= date('d M Y', strtotime($task['deadline'])) ?>
                                                    <?php if (date('Y-m-d') > $task['deadline'] && !$task['is_completed']): ?>
                                                        <span class="text-danger">(Terlambat)</span>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Delete Button -->
                                <form method="POST">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" name="delete_task" 
                                            class="btn btn-sm btn-danger">×</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>