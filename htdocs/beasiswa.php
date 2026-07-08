<?php
session_start();
require_once 'includes/config.php';

$result = $conn->query("SELECT * FROM scholarships ORDER BY deadline ASC");

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'buyer') {
    header('Location: access-denied-siswa.php');
    exit;
}
?>

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Beasiswa - Bekal Edu</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { margin: 0; background: #f8fafc; font-family: 'Segoe UI', Arial, sans-serif; }
        .page-container { max-width: 1200px; margin: 40px auto 40px 300px; padding: 20px; transition: 0.35s ease; }
        @media(max-width: 992px) { .page-container { margin-left: auto; margin-right: auto; } }
        .page-header h1 { margin: 0 0 8px; font-size: 28px; }
        .search-bar { width: 100%; box-sizing: border-box; padding: 16px 20px; border: 1px solid #e2e8f0; border-radius: 16px; background: white; font-size: 15px; outline: none; box-shadow: 0 4px 15px rgba(0,0,0,.02); transition: border 0.2s; }
        .search-bar:focus { border-color: #2563eb; }
        .filter-row { display: flex; gap: 12px; flex-wrap: wrap; margin: 20px 0 25px; }
        .filter-row select { padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; background: white; font-size: 14px; outline: none; font-weight: 500; }
        .beasiswa-item { background: white; border-radius: 16px; padding: 24px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; gap: 20px; box-shadow: 0 4px 10px rgba(0,0,0,.01); border: 1px solid #e2e8f0; transition: all 0.25s; }
        .beasiswa-item:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,.04); border-color: #cbd5e1; }
        .detail-btn { background: #2563eb; color: white; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; transition: background 0.2s; white-space: nowrap; }
        .detail-btn:hover { background: #1d4ed8; }
        
        .no-results { display: none; 
            background: white; 
            padding: 40px; 
            text-align: center; 
            border-radius: 16px; 
            color: #64748b; 
            border: 1px solid #e2e8f0; }
        
        .page-container{

    max-width:1200px;

    margin:40px auto 40px 300px;

    padding:20px;

    transition:.35s ease;

}

.page-container.expanded{

    margin-left:90px;

}
        
        .page-container{
  			max-width:1200px;
    		margin:40px auto 40px 300px;
    		padding:20px;
    		transition:.35s ease;
		}

		.page-container.expanded{
		    margin-left:40px;
		}

		@media(max-width:992px){

    .page-container,
    .page-container.expanded{
        margin-left:auto;
        margin-right:auto;
    }

}
    </style>
</head>
<body>
    <?php
if (!isset($_SESSION['role'])) {
    include 'includes/topbar.php';
} else {
    include 'includes/sidebar-buyer.php';
}
?>
<div
    id="mainContent"
    class="<?php echo isset($_SESSION['user_id']) ? 'main-content' : 'main-content no-sidebar'; ?>">
    <div class="page-header">
            <h1>🎓 Cari Informasi Beasiswa</h1>
            <p style="color:#6b7280; margin:0;">Temukan program bantuan pendidikan terbaik sesuai kriteria jenjang Anda.</p>
        </div>
        <br>
        <input type="text" id="searchInput" class="search-bar" placeholder="Cari beasiswa, nama universitas, atau lembaga penyedia...">
        
        <div class="filter-row">
            <select id="levelFilter">
                <option value="">Semua Jenjang</option>
                <?php
                $levels = $conn->query("SELECT DISTINCT level FROM scholarships ORDER BY level");
                while($lvl = $levels->fetch_assoc()) {
                    echo "<option value='".htmlspecialchars($lvl['level'])."'>".htmlspecialchars($lvl['level'])."</option>";
                }
                ?>
            </select>
            <select id="locationFilter">
                <option value="">Semua Lokasi</option>
                <?php
                $locations = $conn->query("SELECT DISTINCT location FROM scholarships ORDER BY location");
                while($loc = $locations->fetch_assoc()) {
                    echo "<option value='".htmlspecialchars($loc['location'])."'>".htmlspecialchars($loc['location'])."</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom:15px; color:#64748b; font-weight:500;">
            <span id="resultCount" style="color:#2563eb; font-weight:700;"><?php echo $result->num_rows; ?></span> program beasiswa ditemukan
        </div>

        <div id="scholarshipList">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="beasiswa-item" data-level="<?php echo htmlspecialchars($row['level']); ?>" data-location="<?php echo htmlspecialchars($row['location']); ?>">
                    <div>
                        <h3 style="margin:0 0 6px 0; color:#0f172a; font-size:18px;"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p style="margin:0; color:#64748b; font-size:14px;">
                            🏢 <?php echo htmlspecialchars($row['institution']); ?> &nbsp;•&nbsp; 
                            📍 <?php echo htmlspecialchars($row['location']); ?> &nbsp;•&nbsp; 
                            🏷️ <b><?php echo htmlspecialchars($row['level']); ?></b> &nbsp;•&nbsp; 
                            ⏱️ Batas: <span style="color:#ef4444; font-weight:500;"><?php echo date('d F Y', strtotime($row['deadline'])); ?></span>
                        </p>
                    </div>
                    <div>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'buyer'): ?>
                            <a href="beasiswa-detail.php?id=<?php echo $row['id']; ?>" class="detail-btn">Lihat Detail</a>
                        <?php else: ?>
                            <a href="index.php?login_required=1" class="detail-btn">Lihat Detail</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <div id="noResults" class="no-results">🔍 Maaf, pencarian tidak menemukan kecocokan program beasiswa.</div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const levelFilter = document.getElementById('levelFilter');
        const locationFilter = document.getElementById('locationFilter');
        const cards = document.querySelectorAll('.beasiswa-item');
        const resultCount = document.getElementById('resultCount');
        const noResults = document.getElementById('noResults');

        function filterScholarships(){
            let visible = 0;
            const search = searchInput.value.toLowerCase();
            const selectedLevel = levelFilter.value;
            const selectedLocation = locationFilter.value;

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                const lvl = card.dataset.level;
                const loc = card.dataset.location;

                const searchMatch = text.includes(search);
                const levelMatch = !selectedLevel || lvl === selectedLevel;
                const locationMatch = !selectedLocation || loc === selectedLocation;

                if(searchMatch && levelMatch && locationMatch){
                    card.style.display = 'flex';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            resultCount.textContent = visible;
            noResults.style.display = visible === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterScholarships);
        levelFilter.addEventListener('change', filterScholarships);
        locationFilter.addEventListener('change', filterScholarships);
    </script>

    
    </body>
</html>