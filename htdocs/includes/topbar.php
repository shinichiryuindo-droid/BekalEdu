
<div class="topbar">

    <div class="logo">
        🎓 Bekal Edu
    </div>

    <button class="mobile-menu-btn" id="mobileMenuBtn">
        ☰
    </button>

    <div class="menu" id="topMenu">

        <a href="/index.php">
            Beranda
        </a>

        <a href="/beasiswa.php">
            Beasiswa
        </a>

        <a href="/marketplace.php">
            Marketplace
        </a>

<a href="/bekaledu.php">
🏛️ Bekal Edu
</a>
        

        <a
        href="/login.php"
        class="login-btn">
            Login
        </a>

        <a
        href="/register/index.php"
        class="register-btn">
            Daftar
        </a>

    </div>

</div>

<style>

.mobile-menu-btn{
    display:none;
    border:none;
    background:none;
    font-size:28px;
    cursor:pointer;
    color:var(--primary);
}

@media (max-width:768px){

    .topbar{
        padding:14px 18px;
        position:relative;
    }

    .mobile-menu-btn{
        display:block;
    }

    .menu{
        display:none;
        position:absolute;
        top:100%;
        left:0;
        right:0;
        background:#fff;
        flex-direction:column;
        align-items:stretch;
        gap:0;
        padding:12px;
        box-shadow:0 8px 20px rgba(0,0,0,.12);
        border-top:1px solid #eee;
    }

    .menu.show{
        display:flex;
    }

    .menu a{
        padding:12px 14px;
        border-radius:8px;
    }

    .register-btn{
        text-align:center;
    }

}

</style>

    
    
<script>

document.addEventListener("DOMContentLoaded",function(){

    const btn=document.getElementById("mobileMenuBtn");
    const menu=document.getElementById("topMenu");

    btn.addEventListener("click",function(){
        menu.classList.toggle("show");
    });

});

</script>
