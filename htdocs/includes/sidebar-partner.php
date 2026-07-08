<?php

$currentPath = $_SERVER['PHP_SELF'];

?>

<button id="sidebarToggle" class="sidebar-toggle">
☰
</button>
<link
href="https://fonts.googleapis.com/css2?family=Arial:wght@400;500;600;700&display=swap"
rel="stylesheet">

<style>

.bekal-sidebar,
.bekal-sidebar *{

    font-family:'Arial',sans-serif;

}

</style>

<link rel="stylesheet" href="../assets/css/style.css">

<div class="bekal-sidebar" id="sidebar">

    <div class="bekal-sidebar-logo">

<img
        src="/media/logo/logo.png"
        class="sidebar-logo"
        alt="Bekal Edu">
    </div>


    <nav>

<a
href="/dashboard/partner.php"
class="<?php echo $currentPath == '/dashboard/partner.php' ? 'active' : ''; ?>">
🏠 Dashboard
</a>

<a
href="/partner/beasiswa.php"
class="<?php echo strpos($currentPath, '/partner/beasiswa.php') !== false ? 'active' : ''; ?>">
🎓 Kelola Beasiswa
</a>

<a
href="/partner/tambah-beasiswa.php"
class="<?php echo strpos($currentPath, '/partner/tambah-beasiswa.php') !== false ? 'active' : ''; ?>">
➕ Tambah Beasiswa
</a>

<a
href="/messages/index.php"
class="<?php echo strpos($currentPath, '/messages/') !== false ? 'active' : ''; ?>">
💬 Pesan
</a>
<a
href="/profile.php"
class="<?php echo strpos($currentPath, '/profile.php') !== false ? 'active' : ''; ?>">
🏛️ Profil Institusi
</a>

<a href="/logout.php">
🚪 Logout
</a>

<a href="/bekaledu.php">
🏛️ Bekal Edu
</a>
        
    </nav>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const toggleBtn =
        document.getElementById('sidebarToggle');

    const sidebar =
    document.getElementById('sidebar');

	const main =
    document.getElementById('mainContent');

    toggleBtn.addEventListener(
        'click',
        function(){

            sidebar.classList.toggle('closed');

			if(main){
			    main.classList.toggle('expanded');
			}

            if(
                sidebar.classList.contains('closed')
            ){
                toggleBtn.innerHTML = '☰';
            }else{
                toggleBtn.innerHTML = '✕';
            }

        }
    );

});

const main =
    document.getElementById('mainContent');

toggleBtn.addEventListener('click', function () {

    sidebar.classList.toggle('closed');

    if (window.innerWidth > 768 && main) {
        main.classList.toggle('expanded');
    }

});


</script>

