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
<div class="bekal-sidebar" id="sidebar">

    <div class="bekal-sidebar-logo">

<img
        src="/media/logo/logo.png"
        class="sidebar-logo"
        alt="Bekal Edu">
    </div>


    <nav>

        <a
href="/dashboard/seller.php"
class="<?php echo strpos($currentPath, '/dashboard/seller.php') !== false ? 'active' : ''; ?>">
🏠 Dashboard
</a>

<a
href="/seller/produk.php"
class="<?php echo strpos($currentPath, '/seller/produk.php') !== false ? 'active' : ''; ?>">
📦 Produk Saya
</a>

<a
href="/seller/tambah-produk.php"
class="<?php echo strpos($currentPath, '/seller/tambah-produk.php') !== false ? 'active' : ''; ?>">
➕ Tambah Produk
</a>

<a
href="/seller/pesanan.php"
class="<?php echo strpos($currentPath, '/seller/pesanan.php') !== false ? 'active' : ''; ?>">
🛒 Pesanan
</a>

<a
href="/messages/index.php"
class="<?php echo strpos($currentPath, '/messages/') !== false ? 'active' : ''; ?>">
💬 Chat Pembeli
</a>

<a
href="/profile.php"
class="<?php echo strpos($currentPath, '/profile.php') !== false ? 'active' : ''; ?>">
👤 Profil
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

