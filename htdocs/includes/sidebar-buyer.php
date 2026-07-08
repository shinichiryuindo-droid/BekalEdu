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
href="/dashboard/buyer.php"
class="<?php echo strpos($currentPath, '/dashboard/buyer.php') !== false ? 'active' : ''; ?>">
🏠 Dashboard
</a>

<a
href="/beasiswa.php"
class="<?php echo strpos($currentPath, '/beasiswa.php') !== false ? 'active' : ''; ?>">
🎓 Beasiswa
</a>

<a
href="/buyer/beasiswa-ai.php"
class="<?php echo strpos($currentPath, '/buyer/beasiswa-ai.php') !== false ? 'active' : ''; ?>">
🤖 Beasiswa AI
</a>        

<a
href="/buyer/beasiswa-cari.php"
class="<?php echo strpos($currentPath, '/buyer/beasiswa-cari.php') !== false ? 'active' : ''; ?>">
🌐 Pencari Web Beasiswa
</a>        
        
<a
href="/marketplace.php"
class="<?php echo strpos($currentPath, '/marketplace.php') !== false ? 'active' : ''; ?>">
📚 Marketplace
</a>

<a
href="/messages/index.php"
class="<?php echo strpos($currentPath, '/messages/') !== false ? 'active' : ''; ?>">
💬 Chat
</a>

<a href="/buyer/my-wishlist.php">
    ❤️ Wishlist Saya
</a>
        
<a
href="/buyer/pesanan-saya.php"
class="<?php echo strpos($currentPath, '/buyer/pesanan-saya.php') !== false ? 'active' : ''; ?>">
📦 Pesanan Saya
</a>

<a href="/buyer/keranjang.php">
    🛒 Keranjang
</a>
        
<a
href="/profile.php"
class="<?php echo strpos($currentPath, '/profile.php') !== false ? 'active' : ''; ?>">
👤 Profil
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

