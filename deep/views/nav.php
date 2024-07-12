<div class="div_nav print_none">
    <div class="div_header_nav flex-row">
        <p class="p_mall"> info@neurolead.net </p>
        <p class="p_mall"> +32 (0) 81 20 66 23 </p>
    </div>
    <div class="div_body_nav flex-row">
        <img src="../../assets/img/logo-neurolead.png" class="img_logo_nav" />
        <div class="flex-row div_p_nav phone_none">
            <p class="p_nav">
                <a href="../../views/home/control.php"> Home </a>
            </p>
            <p class="p_nav">
                <a href="../../views/profils/edit-profil.php"> edit profils </a>
            </p>
            <p class="p_nav">
                <a href="../../views/survey/edit-intro-survey.php"> edit le text </a>
            </p>
            <p class="p_nav">
                <a href="../../views/home/welcome.php"> Passer le test </a>
            </p>
        </div>
    </div>
</div>
<style media="print">
    .print_none{
        display: none;
    }
    </style>
<style>
    .div_header_nav {
        background: #EF7E33;
        height: 25px;
        font-size: 10px;
        color: white;
        padding-left: 5%;
        ;
    }


    .div_nav {
        position: fixed;
        width: 100vw;
        top: 0;
        left: 0;
        z-index: 11;
        box-shadow: 3px 3px 14px rgb(169, 169, 169);
    }

    .img_logo_nav {
        height: 50px;
        margin-left: 6%;
    }

    .div_body_nav {
        background: white;
        height: 80px;
        padding-top: 30px;

    }

    .div_body {
        position: relative;
    }

    .div_p_nav {
        margin-left: 40%;
        width: 100%;
    }

    .p_nav>a {
        text-decoration: none;
        color: black;
        padding: 0px 5px;
    }
</style>